<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonDiff\Exception;
use Swaggest\JsonDiff\JsonDiff;
use Yaoi\Command;

abstract class BaseDiff extends Base
{
    public $originalPath;
    public $newPath;
    public $rearrangeArrays;

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Command\Definition $definition, $options)
    {
        $options->originalPath = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to old (original) json file');

        $options->newPath = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to new json file');

        $options->rearrangeArrays = Command\Option::create()
            ->setDescription('Rearrange arrays to match original');

        parent::setUpDefinition($definition, $options);
    }

    /** @var JsonDiff */
    protected $diff;

    protected function prePerform()
    {
        $original = Base::readJsonOrYaml($this->originalPath, $this->response);
        $new = Base::readJsonOrYaml($this->newPath, $this->response);

        $options = 0;
        if ($this->rearrangeArrays) {
            $options += JsonDiff::REARRANGE_ARRAYS;
        }
        try {
            $this->diff = new JsonDiff($original, $new, $options);
        } catch (Exception $e) {
            $this->response->error($e->getMessage());
            return;
        }

        $this->out = '';
    }

}