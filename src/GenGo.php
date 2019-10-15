<?php

namespace Swaggest\JsonCli;

use Swaggest\GoCodeBuilder\JsonSchema\GoBuilder;
use Swaggest\GoCodeBuilder\JsonSchema\StripPrefixPathToNameHook;
use Swaggest\GoCodeBuilder\JsonSchema\StructHookCallback;
use Swaggest\GoCodeBuilder\Templates\GoFile;
use Swaggest\GoCodeBuilder\Templates\Struct\StructDef;
use Swaggest\JsonCli\JsonSchema\ResolverMux;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\RemoteRef\BasicFetcher;
use Swaggest\JsonSchema\RemoteRef\Preloaded;
use Swaggest\JsonSchema\Schema;
use Yaoi\Command;

class GenGo extends Command
{
    /** @var string */
    public $schema;
    /** @var string */
    public $packageName = 'entities';
    /** @var string */
    public $rootName = 'Structure';
    /** @var bool */
    public $showConstProperties = false;
    /** @var bool */
    public $keepParentInPropertyNames = false;
    /** @var bool */
    public $ignoreNullable;
    /** @var bool */
    public $ignoreXGoType;
    /** @var bool */
    public $withZeroValues;
    /** @var bool */
    public $enableXNullable;
    /** @var bool */
    public $enableDefaultAdditionalProperties;
    /** @var string[] */
    public $defPtr = ['#/definitions'];
    /** @var string[] */
    public $ptrInSchema;

    public $output;


    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    public static function setUpDefinition(Command\Definition $definition, $options)
    {
        $definition->description = 'Generate Go code from JSON schema';
        $options->schema = Command\Option::create()
            ->setDescription('Path to JSON schema file')->setIsUnnamed()->setIsRequired();

        $options->output = Command\Option::create()
            ->setDescription('Path to output .go file, STDOUT is used by default')->setType();

        $options->ptrInSchema = Command\Option::create()->setType()->setIsVariadic()
            ->setDescription('JSON pointers to structure in in root schema, default #');

        $options->packageName = Command\Option::create()->setType()
            ->setDescription('Go package name, default "entities"');

        $options->rootName = Command\Option::create()->setType()
            ->setDescription('Go root struct name, default "Structure", only used for # pointer');

        $options->defPtr = Command\Option::create()->setType()->setIsVariadic()
            ->setDescription('Definitions pointers to strip from symbol names, default #/definitions');

        $options->showConstProperties = Command\Option::create()
            ->setDescription('Show properties with constant values, hidden by default');

        $options->keepParentInPropertyNames = Command\Option::create()
            ->setDescription('Keep parent prefix in property name, removed by default');

        $options->ignoreNullable = Command\Option::create()
            ->setDescription('Add `omitempty` to nullable properties, removed by default');

        $options->ignoreXGoType = Command\Option::create()
            ->setName('ignore-x-go-type')
            ->setDescription('Ignore `x-go-type` in schema to skip generation');

        $options->withZeroValues = Command\Option::create()
            ->setDescription('Use pointer types to avoid zero value ambiguity');

        $options->enableXNullable = Command\Option::create()
            ->setDescription('Add `null` to types if `x-nullable` or `nullable` is available');

        $options->enableDefaultAdditionalProperties = Command\Option::create()
            ->setDescription('Add field property for undefined `additionalProperties`');
    }


    public function performAction()
    {
        try {

            $dataValue = Base::readJsonOrYaml($this->schema, $this->response);
            if (!$dataValue) {
                $this->response->error('Unable to find schema in ' . $this->schema);
                die(1);
            }

            $resolver = new ResolverMux();

            $data = $dataValue;
            $skipRoot = false;
            if (!empty($this->ptrInSchema)) {
                $baseName = basename($this->schema);
                $skipRoot = true;
                $preloaded = new Preloaded();
                $preloaded->setSchemaData($baseName, $dataValue);
                $resolver->resolvers[] = $preloaded;
                $data = new \stdClass();
                foreach ($this->ptrInSchema as $i => $ptr) {
                    $data->oneOf[$i] = (object)[Schema::PROP_REF => $baseName . $ptr];
                }
            }

            $resolver->resolvers[] = new BasicFetcher();
            $schema = Schema::import($data, new Context($resolver));

            $builder = new GoBuilder();
            $builder->options->hideConstProperties = !$this->showConstProperties;
            $builder->options->trimParentFromPropertyNames = !$this->keepParentInPropertyNames;
            $builder->options->ignoreNullable = $this->ignoreNullable;
            $builder->options->ignoreXGoType = $this->ignoreXGoType;
            $builder->options->withZeroValues = $this->withZeroValues;
            $builder->options->enableXNullable = $this->enableXNullable;
            $builder->options->defaultAdditionalProperties = $this->enableDefaultAdditionalProperties;
            $pathToNameHook = new StripPrefixPathToNameHook();

            if (!empty($this->defPtr)) {
                $pathToNameHook->prefixes = [];
                foreach ($this->defPtr as $defPtr) {
                    if (isset($baseName)) {
                        $pathToNameHook->prefixes[] = $baseName . $defPtr;
                    }
                    $pathToNameHook->prefixes[] = $defPtr;
                }
            }

            if (isset($baseName)) {
                $pathToNameHook->prefixes[] = $baseName;
            }

            $builder->pathToNameHook = $pathToNameHook;

            $builder->structCreatedHook = new StructHookCallback(function (StructDef $structDef, $path, $schema) {
                if ('#' === $path) {
                    $structDef->setName($this->rootName);
                }
            });
            if ($schema instanceof Schema) {
                $builder->getType($schema);
            }

            $goFile = new GoFile($this->packageName);
            $goFile->fileComment = 'Code generated by github.com/swaggest/json-cli ' . App::$ver . ', DO NOT EDIT.';
            $goFile->setComment('Package ' . $this->packageName . ' contains JSON mapping structures.');

            foreach ($builder->getGeneratedStructs() as $generatedStruct) {
                if ($skipRoot && $generatedStruct->path === '#') {
                    continue;
                }
                $goFile->getCode()->addSnippet($generatedStruct->structDef);
            }
            $goFile->getCode()->addSnippet($builder->getCode());

            if ($this->output) {
                if (!file_exists(dirname($this->output))) {
                    $this->response->error('Destination directory does not exist, please create: ' . dirname($this->output));
                    throw new ExitCode('', 1);
                }
                file_put_contents($this->output, $goFile->render());
            } else {
                echo $goFile->render();
            }
        } catch (\Exception $e) {
            $this->response->error($e->getMessage());
            throw new ExitCode('', 1);
        }
    }
}