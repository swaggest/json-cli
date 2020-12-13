<?php

namespace Swaggest\JsonCli\GenPhp;

use Swaggest\PhpCodeBuilder\JsonSchema\PhpBuilder;
use Yaoi\Command\Option;

trait BuilderOptions
{
    /** @var bool */
    public $setters = false;
    /** @var bool */
    public $getters = false;
    /** @var bool */
    public $noEnumConst = false;

    /** @var bool */
    public $declarePropertyDefaults = false;

    /** @var bool */
    public $buildAdditionalPropertiesAccessors = false;

    /**
     * @param \stdClass|static $options
     */
    static public function setupBuilderOptions($options)
    {
        $options->setters = Option::create()->setDescription('Build setters');
        $options->getters = Option::create()->setDescription('Build getters');
        $options->noEnumConst = Option::create()
            ->setDescription('Do not create constants for enum/const values');

        $options->declarePropertyDefaults = Option::create()
            ->setDescription('Use default values to initialize properties');

        $options->buildAdditionalPropertiesAccessors = Option::create()
            ->setDescription('Build accessors for additionalProperties');
    }

    protected function setupBuilder(PhpBuilder $builder)
    {
        $builder->buildSetters = $this->setters;
        $builder->buildGetters = $this->getters;

        $builder->makeEnumConstants = !$this->noEnumConst;
        $builder->declarePropertyDefaults = $this->declarePropertyDefaults;
        $builder->buildAdditionalPropertyMethodsOnTrue = $this->buildAdditionalPropertiesAccessors;
    }

}