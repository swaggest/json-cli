<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonCli\GenPhp\BuilderOptions;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchemaMaker\InstanceFaker;
use Swaggest\JsonSchemaMaker\Options;
use Yaoi\Command;

class GenJson extends Base
{
    public $maxNesting = 10;
    public $defaultAdditionalProperties;
    public $randSeed;

    use BuilderOptions;

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    public static function setUpDefinition(Command\Definition $definition, $options)
    {
        $definition->description = 'Generate JSON sample from JSON schema';
        Base::setupGenOptions($definition, $options);
        $options->maxNesting = Command\Option::create()->setType()
            ->setDescription('Max nesting level, default 10');
        $options->defaultAdditionalProperties = Command\Option::create()
            ->setDescription('Treat non-existent `additionalProperties` as `additionalProperties: true`');
        $options->randSeed = Command\Option::create()->setType()
            ->setDescription('Integer random seed for deterministic output');
        Base::setUpDefinition($definition, $options);
        Base::setupLoadFileOptions($options);
    }

    public function performAction()
    {
        if ($this->randSeed !== null) {
            mt_srand((int)$this->randSeed);
        }

        try {
            $skipRoot = false;
            $baseName = null;
            $schema = $this->loadSchema($skipRoot, $baseName);

            if (!$schema instanceof Schema) {
                $this->response->error('failed to assert Schema type, ' . get_class($schema) . ' received');
                throw new ExitCode('', 1);
            }

            $options = new Options;
            $options->maxNesting = $this->maxNesting;
            $options->defaultAdditionalProperties = $this->defaultAdditionalProperties;
            $instanceFaker = new InstanceFaker($schema, $options);

            $this->out = $instanceFaker->makeValue();

            $this->postPerform();
        } catch (\Exception $e) {
            $this->response->error($e->getMessage());
            throw new ExitCode('', 1);
        }
    }
}