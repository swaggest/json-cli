<?php

namespace Swaggest\JsonCli\GenGo;

use Swaggest\GoCodeBuilder\JsonSchema\Options;
use Swaggest\JsonCli\ExitCode;
use Swaggest\PhpCodeBuilder\Markdown\TypeBuilder;
use Yaoi\Command\Option;

trait BuilderOptions
{
    /** @var bool */
    public $showConstProperties = false;
    /** @var bool */
    public $keepParentInPropertyNames = false;
    /** @var bool */
    public $ignoreNullable;
    /** @var bool */
    public $ignoreXGoType;
    /** @var bool */
    public $withZeroValues;
    /** @var bool */
    public $enableXNullable;
    /** @var bool */
    public $enableDefaultAdditionalProperties;
    /** @var bool */
    public $fluentSetters;
    /** @var bool */
    public $ignoreRequired = false;

    /** @var array<string, string> */
    public $renames = [];

    /** @var bool */
    public $requireXGenerate = false;

    /** @var bool */
    public $validateRequired = false;

    /** @var string[] */
    public $nameTags = [];

    /** @var string */
    public $config;

    /**
     * @param \stdClass|static $options
     */
    public static function setUpBuilderOptions($options)
    {
        $options->showConstProperties = Option::create()
            ->setDescription('Show properties with constant values, hidden by default');

        $options->keepParentInPropertyNames = Option::create()
            ->setDescription('Keep parent prefix in property name, removed by default');

        $options->ignoreNullable = Option::create()
            ->setDescription('Add `omitempty` to nullable properties, removed by default');

        $options->ignoreXGoType = Option::create()
            ->setName('ignore-x-go-type')
            ->setDescription('Ignore `x-go-type` in schema to skip generation');

        $options->withZeroValues = Option::create()
            ->setDescription('Use pointer types to avoid zero value ambiguity');

        $options->enableXNullable = Option::create()
            ->setDescription('Add `null` to types if `x-nullable` or `nullable` is available');

        $options->enableDefaultAdditionalProperties = Option::create()
            ->setDescription('Add field property for undefined `additionalProperties`');

        $options->fluentSetters = Option::create()
            ->setDescription('Add fluent setters to struct fields');

        $options->ignoreRequired = Option::create()
            ->setDescription('Ignore if property is required when deciding on pointer type or omitempty');

        $options->renames = Option::create()->setIsVariadic()->setType()
            ->setDescription('Map of exported symbol renames, example From:To');

        $options->requireXGenerate = Option::create()
            ->setDescription('Generate properties with `x-generate: true` only');

        $options->validateRequired = Option::create()
            ->setDescription('Generate validation code to check required properties during unmarshal');

        $options->nameTags = Option::create()->setIsVariadic()->setType()
            ->setDescription('Set additional field tags with property name, example "msgp bson"');

        $options->config = Option::create()->setType()
            ->setDescription('Path to config JSON file to load options from. Schema:');

        $tb = new TypeBuilder();
        $tb->getTypeString(Options::schema()->exportSchema());
        $options->config->description .= "\n" . trim(substr($tb->file, 97)); // Stripping header.
    }

    /**
     * @return Options
     * @throws ExitCode
     */
    protected function makeGoBuilderOptions()
    {
        $options = new Options();
        if (!empty($this->config)) {
            $data = file_get_contents($this->config);
            if (empty($data)) {
                throw new ExitCode("empty or missing config file", 1);
            }
            $json = json_decode($data);
            if (empty($json)) {
                throw new ExitCode("invalid json in config file", 1);
            }

            $options = Options::import($json);
        }

        $options = $options->jsonSerialize();

        $options->hideConstProperties = !$this->showConstProperties;
        $options->trimParentFromPropertyNames = !$this->keepParentInPropertyNames;
        $options->ignoreNullable = $this->ignoreNullable;
        $options->ignoreXGoType = $this->ignoreXGoType;
        $options->withZeroValues = $this->withZeroValues;
        $options->enableXNullable = $this->enableXNullable;
        $options->defaultAdditionalProperties = $this->enableDefaultAdditionalProperties;
        $options->fluentSetters = $this->fluentSetters;
        $options->ignoreRequired = $this->ignoreRequired;
        $options->requireXGenerate = $this->requireXGenerate;
        $options->validateRequired = $this->validateRequired;
        $options->nameTags = $this->nameTags;
        if (!empty($this->renames)) {
            foreach ($this->renames as $rename) {
                $rename = explode(':', $rename, 2);
                $options->renames[$rename[0]] = $rename[1];
            }
        }

        return $options;
    }

}