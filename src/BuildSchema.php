<?php


namespace Swaggest\JsonCli;

use Swaggest\JsonCli\JsonSchema\ResolverMux;
use Swaggest\JsonDiff\JsonDiff;
use Swaggest\JsonDiff\JsonPointer;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\InvalidValue;
use Swaggest\JsonSchema\RemoteRef\BasicFetcher;
use Swaggest\JsonSchema\RemoteRef\Preloaded;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchemaMaker\SchemaMaker;
use Yaoi\Command;

class BuildSchema extends Base
{
    public $schema;
    public $data;

    public $additionalData;

    /** @var string */
    public $ptrInSchema;

    /** @var string */
    public $ptrInData;

    public $jsonl = false;

    public $useNullable = false;

    public $useXNullable = false;

    public $collectExamples = false;

    public $defsPtr = '#/definitions/';

    public $heuristicRequired = false;

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Command\Definition $definition, $options)
    {
        $options->data = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to data (JSON/YAML)');
        $options->schema = Command\Option::create()->setIsUnnamed()
            ->setDescription('Path to parent schema');
        $options->ptrInSchema = Command\Option::create()->setType()
            ->setDescription('JSON pointer to structure in root schema, default #');
        $options->ptrInData = Command\Option::create()->setType()
            ->setDescription('JSON pointer to structure in data, default #');
        $options->jsonl = Command\Option::create()->setDescription('Data is a stream of JSON Lines');

        $options->useNullable = Command\Option::create()
            ->setDescription('Use `nullable: true` instead of `type: null`, OAS 3.0 compatibility');

        $options->useXNullable = Command\Option::create()
            ->setDescription('Use `x-nullable: true` instead of `type: null`, Swagger 2.0 compatibility');

        $options->defsPtr = Command\Option::create()->setType()
            ->setDescription('Location to put new definitions. default: "#/definitions/"');

        $options->collectExamples = Command\Option::create()
            ->setDescription('Collect scalar values example');

        $options->heuristicRequired = Command\Option::create()
            ->setDescription('Mark properties that are available in all samples as `required`.');

        $options->additionalData = Command\Option::create()->setType()->setIsVariadic()
            ->setDescription('Additional paths to data');

        parent::setUpDefinition($definition, $options);
    }


    /**
     * @throws ExitCode
     * @throws \Swaggest\JsonSchema\Exception
     */
    public function performAction()
    {
        $schema = new Schema();

        if ($this->schema) {
            $schemaDataOrig = $this->readData($this->schema);
            $schemaData = $schemaDataOrig;

            $resolver = new ResolverMux();

            if (!empty($this->ptrInSchema)) {
                $baseName = basename($this->schema);
                $preloaded = new Preloaded();
                $preloaded->setSchemaData($baseName, $schemaData);
                $resolver->resolvers[] = $preloaded;
                $schemaData = (object)[Schema::PROP_REF => $baseName . $this->ptrInSchema];
            }

            $resolver->resolvers[] = new BasicFetcher();

            try {
                $schemaContract = Schema::import($schemaData, new Context($resolver));
                if ($schemaContract instanceof Schema) {
                    $schema = $schemaContract;
                }
            } catch (InvalidValue $e) {
                $this->response->error('Invalid schema');
                $this->response->addContent($e->getMessage());
                throw new ExitCode('', 1);
            } catch (\Exception $e) {
                $this->response->error('Failed to import schema:' . $e->getMessage());
                throw new ExitCode('', 1);
            }
        }

        $maker = new SchemaMaker($schema);
        $maker->options->useXNullable = $this->useXNullable;
        $maker->options->useNullable = $this->useNullable;
        $maker->options->defsPtr = $this->defsPtr;
        $maker->options->collectExamples = $this->collectExamples;
        $maker->options->heuristicRequired = $this->heuristicRequired;

        if ($this->jsonl) {
            $pathInData = [];
            if ($this->ptrInData) {
                $pathInData = JsonPointer::splitPath($this->ptrInData);
            }

            $handle = fopen($this->data, "r");
            if ($handle) {
                while (($buffer = fgets($handle)) !== false) {
                    $item = json_decode($buffer);
                    // Tolerate and skip malformed JSON line.
                    if (null === $item) {
                        continue;
                    }
                    if ($this->ptrInData) {
                        $item = JsonPointer::get($item, $pathInData);
                    }
                    $maker->addInstanceValue($item);
                }
                if (!feof($handle)) {
                    echo "Error: unexpected fgets() fail\n";
                }
                fclose($handle);
            }
        } else {
            $data = $this->readData($this->data);
            $maker->addInstanceValue($data);

            if (!empty($this->additionalData)) {
                foreach ($this->additionalData as $path) {
                    $data = $this->readData($path);
                    $maker->addInstanceValue($data);
                }
            }
        }


        $s = Schema::export($schema);
        $this->out = $s;

        if ($this->ptrInSchema && isset($schemaDataOrig)) {
            $tmp = json_encode($schemaDataOrig);
            if ($tmp === false) {
                throw new ExitCode('Failed to encode JSON', 1);
            }
            $schemaDataResult = json_decode($tmp);

            $defs = JsonPointer::get($s, JsonPointer::splitPath(rtrim($this->defsPtr, '/')));
            foreach ($defs as $name => $def) {
                JsonPointer::add($schemaDataResult, JsonPointer::splitPath($this->defsPtr . $name), $def);
            }
            JsonPointer::remove($s, JsonPointer::splitPath(rtrim($this->defsPtr, '/')));
            JsonPointer::add($schemaDataResult, JsonPointer::splitPath($this->ptrInSchema), $s);

            $tmp = json_encode($schemaDataResult);
            if ($tmp === false) {
                throw new ExitCode('Failed to encode JSON', 1);
            }
            $schemaDataResult = json_decode($tmp);
            $diff = new JsonDiff($schemaDataOrig, $schemaDataResult, JsonDiff::REARRANGE_ARRAYS);
            $this->out = $diff->getRearranged();
        }

        $this->postPerform();
    }
}