<?php

namespace Swaggest\JsonCli;

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

    protected function readData($path)
    {
        return self::readJsonOrYaml($path, $this->response);
    }

    /**
     * @param string $path
     * @param Response $response
     * @return mixed
     */
    public static function readJsonOrYaml($path, $response)
    {
        $fileData = file_get_contents($path);
        if (!$fileData) {
            $response->error('Unable to read ' . $path);
            die(1);
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
        $options = JSON_UNESCAPED_SLASHES;
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
}