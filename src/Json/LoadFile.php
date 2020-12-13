<?php

namespace Swaggest\JsonCli\Json;

use Swaggest\JsonCli\Base;
use Swaggest\JsonCli\ExitCode;
use Swaggest\JsonDiff\Exception;
use Swaggest\JsonDiff\JsonMergePatch;
use Swaggest\JsonDiff\JsonPatch;
use Yaoi\Command\Option;

trait LoadFile
{
    /** @var string[] */
    public $patches = [];

    /**
     * @param \stdClass|static $options
     */
    public static function setupLoadFileOptions($options)
    {
        $options->patches = Option::create()->setType()->setIsVariadic()
            ->setDescription('JSON patches to apply to schema file before processing, merge patches are also supported');

    }

    protected function loadFile()
    {
        $dataValue = Base::readJsonOrYaml($this->schema, $this->response);
        if (!$dataValue) {
            throw new ExitCode('Unable to find schema in ' . $this->schema, 1);
        }

        if (!empty($this->patches)) {
            foreach ($this->patches as $patchPath) {
                $patch = Base::readJsonOrYaml($patchPath, $this->response);
                if (is_array($patch)) {
                    $jp = JsonPatch::import($patch);
                    try {
                        $jp->apply($dataValue);
                    } catch (Exception $e) {
                        throw new ExitCode($e->getMessage(), 1);
                    }
                } else {
                    JsonMergePatch::apply($dataValue, $patch);
                }
            }
        }

        return $dataValue;
    }
}