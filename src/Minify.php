<?php

namespace Swaggest\JsonCli;

use Symfony\Component\Yaml\Yaml;
use Yaoi\Command;
use Yaoi\Command\Definition;

class Minify extends Command
{
    public $path;
    public $output;

    /**
     * @param Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Definition $definition, $options)
    {
        $options->path = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to JSON/YAML file');
        $options->output = Command\Option::create()->setType()
            ->setDescription('Path to output, default STDOUT');
        $definition->description = 'Minify JSON document';
    }

    public function performAction()
    {
        $fileData = file_get_contents($this->path);
        if (!$fileData) {
            $this->response->error('Unable to read ' . $this->path);
            return;
        }
        if (substr($this->path, -5) === '.yaml' || substr($this->path, -4) === '.yml') {
            $jsonData = Yaml::parse($fileData, Yaml::PARSE_OBJECT);
        } else {
            $jsonData = json_decode($fileData);
        }

        $result = json_encode($jsonData, JSON_UNESCAPED_SLASHES);

        if ($this->output) {
            file_put_contents($this->output, $result);
        } else {
            $this->response->addContent($result);
        }
    }

}