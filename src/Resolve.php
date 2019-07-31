<?php

namespace Swaggest\JsonCli;


use Swaggest\JsonDiff\Exception;
use Swaggest\JsonDiff\JsonPointer;
use Yaoi\Command\Definition;
use Yaoi\Command\Option;

class Resolve extends Base
{
    public $pointer;
    public $path;

    /**
     * @param Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Definition $definition, $options)
    {
        $options->path = Option::create()->setType()->setIsUnnamed()
            ->setDescription('Path to JSON/YAML file');
        $options->pointer = Option::create()->setType()->setIsUnnamed()
            ->setDescription('JSON Pointer, example /key4/1/a');
    }

    /**
     * @throws ExitCode
     */
    public function performAction()
    {
        $jsonData = $this->readData($this->path);
        try {
            $this->out = JsonPointer::getByPointer($jsonData, $this->pointer);
        } catch (Exception $e) {
            $this->response->error($e->getMessage());
            throw new ExitCode('', 1);
        }
        $this->postPerform();
    }

}