<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonDiff\JsonValueReplace;
use Symfony\Component\Yaml\Yaml;
use Yaoi\Command;

class Replace extends Command
{
    public $path;
    public $output;

    public $search;
    public $replace;
    public $pathFilter;

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Command\Definition $definition, $options)
    {
        $options->path = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to JSON/YAML file');
        $options->search = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Search JSON value');
        $options->replace = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Replace JSON value');
        $options->pathFilter = Command\Option::create()->setType()
            ->setDescription('JSON path filter regex, example "/definitions/.*/properties/deletedAt"');
        $options->output = Command\Option::create()->setType()
            ->setDescription('Path to output, default STDOUT');
        $definition->description = 'Minify JSON document';
    }

    public function performAction()
    {
        if (!file_exists($this->path)) {
            $this->response->error('File not found: ' . $this->path);
            return;
        }
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

        $search = json_decode($this->search);
        if (json_last_error()) {
            $this->response->error('Invalid JSON: ' . $this->search);
            return;
        }
        $replace = json_decode($this->replace);
        if (json_last_error()) {
            $this->response->error('Invalid JSON: ' . $this->replace);
            return;
        }

        $pathFilter = null;
        if ($this->pathFilter) {
            $pathFilter = '|' . $this->pathFilter . '|';
        }

        $replacer = new JsonValueReplace($search, $replace, $pathFilter);
        $jsonData = $replacer->process($jsonData);

        $result = json_encode($jsonData, JSON_UNESCAPED_SLASHES);

        if ($this->output) {
            file_put_contents($this->output, $result);
        } else {
            $this->response->addContent($result);
        }
    }

}