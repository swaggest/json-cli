<?php

namespace Swaggest\JsonCli;

use Yaoi\Command;
use Yaoi\Command\Definition;

class PrettyPrint extends Base
{
    public $path;
    public $pretty = true;

    /**
     * @param Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Definition $definition, $options)
    {
        $options->path = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to JSON/YAML file');
        parent::setUpDefinition($definition, $options);
        $definition->description = 'Pretty print JSON document';
        unset($options->pretty);
    }

    public function performAction()
    {
        $this->out = $this->readData($this->path);
        $this->postPerform();
    }

}