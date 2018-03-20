<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonDiff\JsonValueReplace;
use Symfony\Component\Yaml\Yaml;
use Yaoi\Command;

class Replace extends Base
{
    public $path;

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
        $definition->description = 'Minify JSON document';
    }

    public function performAction()
    {
        $jsonData = $this->readData($this->path);

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
        $this->out = $replacer->process($jsonData);
        $this->postPerform();
    }

}