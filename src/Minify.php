<?php

namespace Swaggest\JsonCli;

use Yaoi\Command;
use Yaoi\Command\Definition;

class Minify extends Base
{
    public $path;

    /**
     * @param Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Definition $definition, $options)
    {
        $options->path = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to JSON/YAML file');
        parent::setUpDefinition($definition, $options);
        unset($options->pretty);
        unset($options->toYaml);
        $definition->description = 'Minify JSON document';
    }

    public function performAction()
    {
        $this->out = $this->readData($this->path);
        $this->postPerform();
    }

}