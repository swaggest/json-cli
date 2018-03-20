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
        $originalJson = file_get_contents($this->originalPath);
        if (!$originalJson) {
            $this->response->error('Unable to read ' . $this->originalPath);
            return;
        }

        $newJson = file_get_contents($this->newPath);
        if (!$newJson) {
            $this->response->error('Unable to read ' . $this->newPath);
            return;
        }

        $options = 0;
        if ($this->rearrangeArrays) {
            $options += JsonDiff::REARRANGE_ARRAYS;
        }
        try {
            $this->diff = new JsonDiff(json_decode($originalJson), json_decode($newJson), $options);
        } catch (Exception $e) {
            $this->response->error($e->getMessage());
            return;
        }

        $this->out = '';
    }

}