<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonCli\JsonSchema\ResolverMux;
use Swaggest\JsonDiff\Exception;
use Swaggest\JsonDiff\JsonMergePatch;
use Swaggest\JsonDiff\JsonPatch;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\RemoteRef\BasicFetcher;
use Swaggest\JsonSchema\RemoteRef\Preloaded;
use Swaggest\JsonSchema\Schema;
use Symfony\Component\Yaml\Yaml;
use Yaoi\Command;
use Yaoi\Io\Response;

abstract class Base extends Command
{
    public $pretty;
    public $toYaml;
    public $toSerialized;
    public $output;

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Command\Definition $definition, $options)
    {
        $options->pretty = Command\Option::create()
            ->setDescription('Pretty-print result JSON');
        $options->output = Command\Option::create()->setType()
            ->setDescription('Path to output result, default STDOUT');
        $options->toYaml = Command\Option::create()->setDescription('Output in YAML format');
        $options->toSerialized = Command\Option::create()->setDescription('Output in PHP serialized format');
    }


    protected $out;

    /**
     * @param string $path
     * @return mixed
     * @throws ExitCode
     */
    protected function readData($path)
    {
        return self::readJsonOrYaml($path, $this->response);
    }

    /**
     * @param string $path
     * @param Response $response
     * @return mixed
     * @throws ExitCode
     */
    public static function readJsonOrYaml($path, $response)
    {
        $fileData = file_get_contents($path);
        if (!$fileData) {
            $response->error('Unable to read ' . $path);
            throw new ExitCode('', 1);
        }
        if (substr($path, -5) === '.yaml' || substr($path, -4) === '.yml') {
            $jsonData = Yaml::parse($fileData, Yaml::PARSE_OBJECT + Yaml::PARSE_OBJECT_FOR_MAP);
        } elseif (substr($path, -11) === '.serialized') {
            $jsonData = unserialize($fileData);
        } else {
            $jsonData = json_decode($fileData);
        }

        return $jsonData;
    }


    protected function postPerform()
    {
        $options = JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE;
        if ($this->pretty) {
            $options += JSON_PRETTY_PRINT;
        }

        if ($this->toYaml) {
            $result = Yaml::dump($this->out, 2, 2, Yaml::DUMP_OBJECT_AS_MAP);
        } elseif ($this->toSerialized) {
            $result = serialize($this->out);
        } else {
            $result = json_encode($this->out, $options);
        }

        if ($this->output) {
            file_put_contents($this->output, $result);
        } else {
            echo $result;
        }
    }


    /** @var string */
    public $schema;
    /** @var string[] */
    public $defPtr = ['#/definitions'];
    /** @var string[] */
    public $ptrInSchema;
    /** @var string[] */
    public $patches = [];

    /**
     * @param Command\Definition $definition
     * @param static|mixed $options
     */
    protected static function setupGenOptions(Command\Definition $definition, $options)
    {
        $options->schema = Command\Option::create()
            ->setDescription('Path to JSON schema file')->setIsUnnamed()->setIsRequired();

        $options->ptrInSchema = Command\Option::create()->setType()->setIsVariadic()
            ->setDescription('JSON pointers to structure in in root schema, default #');

        $options->defPtr = Command\Option::create()->setType()->setIsVariadic()
            ->setDescription('Definitions pointers to strip from symbol names, default #/definitions');

        $options->patches = Command\Option::create()->setType()->setIsVariadic()
            ->setDescription('JSON patches to apply to schema file before processing, merge patches are also supported');
    }

    /**
     * @param bool $skipRoot
     * @param string $baseName
     * @return \Swaggest\JsonSchema\SchemaContract
     * @throws Exception
     * @throws ExitCode
     * @throws \Swaggest\JsonSchema\Exception
     * @throws \Swaggest\JsonSchema\InvalidValue
     */
    protected function loadSchema(&$skipRoot, &$baseName)
    {
        $dataValue = Base::readJsonOrYaml($this->schema, $this->response);
        if (!$dataValue) {
            $this->response->error('Unable to find schema in ' . $this->schema);
            die(1);
        }

        if (!empty($this->patches)) {
            foreach ($this->patches as $patchPath) {
                $patch = Base::readJsonOrYaml($patchPath, $this->response);
                if (is_array($patch)) {
                    $jp = JsonPatch::import($patch);
                    try {
                        $jp->apply($dataValue);
                    } catch (Exception $e) {
                        throw new ExitCode($e->getMessage(), 1);
                    }
                }  else {
                    JsonMergePatch::apply($dataValue, $patch);
                }
            }
        }

        $resolver = new ResolverMux();

        $data = $dataValue;
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
        return Schema::import($data, new Context($resolver));
    }
}