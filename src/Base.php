<?php

namespace Swaggest\JsonCli;


use Swaggest\JsonDiff\Exception;
use Swaggest\JsonDiff\JsonDiff;
use Symfony\Component\Yaml\Yaml;
use Yaoi\Command;

abstract class Base extends Command
{
    public $originalPath;
    public $newPath;
    public $pretty;
    public $rearrangeArrays;
    public $toYaml;
    public $output;

    static function setUpDefinition(Command\Definition $definition, $options)
    {
        $options->originalPath = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to old (original) json file');
        $options->newPath = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to new json file');
        $options->pretty = Command\Option::create()
            ->setDescription('Pretty-print result JSON');
        $options->rearrangeArrays = Command\Option::create()
            ->setDescription('Rearrange arrays to match original');
        $options->output = Command\Option::create()
            ->setDescription('Path to output result, default STDOUT');
        $options->toYaml = Command\Option::create()->setDescription('Output in YAML format');
    }


    /** @var JsonDiff */
    protected $diff;
    protected $out;

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

    protected function postPerform()
    {
        $options = JSON_UNESCAPED_SLASHES;
        if ($this->pretty) {
            $options += JSON_PRETTY_PRINT;
        }

        if ($this->toYaml) {
            $result = Yaml::dump($this->out, 2, 2, Yaml::DUMP_OBJECT_AS_MAP);
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