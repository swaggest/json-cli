<?php

namespace Swaggest\JsonCli;

use Swaggest\GoCodeBuilder\JsonSchema\GoBuilder;
use Swaggest\GoCodeBuilder\JsonSchema\MarshalingTestFunc;
use Swaggest\GoCodeBuilder\JsonSchema\StripPrefixPathToNameHook;
use Swaggest\GoCodeBuilder\JsonSchema\StructHookCallback;
use Swaggest\GoCodeBuilder\Templates\GoFile;
use Swaggest\GoCodeBuilder\Templates\Struct\StructDef;
use Swaggest\JsonCli\JsonSchema\ResolverMux;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\RemoteRef\BasicFetcher;
use Swaggest\JsonSchema\RemoteRef\Preloaded;
use Swaggest\JsonSchema\Schema;
use Yaoi\Command;

class GenGo extends Base
{
    /** @var string */
    public $packageName = 'entities';
    /** @var string */
    public $rootName = 'Structure';
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
    /** @var bool */
    public $withTests = false;

    /** @var array */
    public $renames = [];

    /** @var bool */
    public $requireXGenerate = false;

    /** @var bool */
    public $validateRequired = false;

    /** @var string[] */
    public $nameTags = [];

    public $output;


    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    public static function setUpDefinition(Command\Definition $definition, $options)
    {
        $definition->description = 'Generate Go code from JSON schema';
        Base::setupGenOptions($definition, $options);

        $options->output = Command\Option::create()
            ->setDescription('Path to output .go file, STDOUT is used by default')->setType();

        $options->packageName = Command\Option::create()->setType()
            ->setDescription('Go package name, default "entities"');

        $options->rootName = Command\Option::create()->setType()
            ->setDescription('Go root struct name, default "Structure", only used for # pointer');

        $options->showConstProperties = Command\Option::create()
            ->setDescription('Show properties with constant values, hidden by default');

        $options->keepParentInPropertyNames = Command\Option::create()
            ->setDescription('Keep parent prefix in property name, removed by default');

        $options->ignoreNullable = Command\Option::create()
            ->setDescription('Add `omitempty` to nullable properties, removed by default');

        $options->ignoreXGoType = Command\Option::create()
            ->setName('ignore-x-go-type')
            ->setDescription('Ignore `x-go-type` in schema to skip generation');

        $options->withZeroValues = Command\Option::create()
            ->setDescription('Use pointer types to avoid zero value ambiguity');

        $options->enableXNullable = Command\Option::create()
            ->setDescription('Add `null` to types if `x-nullable` or `nullable` is available');

        $options->enableDefaultAdditionalProperties = Command\Option::create()
            ->setDescription('Add field property for undefined `additionalProperties`');

        $options->fluentSetters = Command\Option::create()
            ->setDescription('Add fluent setters to struct fields');

        $options->ignoreRequired = Command\Option::create()
            ->setDescription('Ignore if property is required when deciding on pointer type or omitempty');

        $options->renames = Command\Option::create()->setIsVariadic()->setType()
            ->setDescription('Map of exported symbol renames, example From:To');

        $options->withTests = Command\Option::create()
            ->setDescription('Generate (un)marshaling tests for entities (experimental feature)');

        $options->requireXGenerate = Command\Option::create()
            ->setDescription('Generate properties with `x-generate: true` only');

        $options->validateRequired = Command\Option::create()
            ->setDescription('Generate validation code to check required properties during unmarshal');

        $options->nameTags = Command\Option::create()->setIsVariadic()->setType()
            ->setDescription('Set additional field tags with property name, example "msgp bson"');
    }


    public function performAction()
    {
        try {
            $skipRoot = false;
            $baseName = null;
            $schema = $this->loadSchema($skipRoot, $baseName);

            $builder = new GoBuilder();
            $builder->options->hideConstProperties = !$this->showConstProperties;
            $builder->options->trimParentFromPropertyNames = !$this->keepParentInPropertyNames;
            $builder->options->ignoreNullable = $this->ignoreNullable;
            $builder->options->ignoreXGoType = $this->ignoreXGoType;
            $builder->options->withZeroValues = $this->withZeroValues;
            $builder->options->enableXNullable = $this->enableXNullable;
            $builder->options->defaultAdditionalProperties = $this->enableDefaultAdditionalProperties;
            $builder->options->fluentSetters = $this->fluentSetters;
            $builder->options->ignoreRequired = $this->ignoreRequired;
            $builder->options->requireXGenerate = $this->requireXGenerate;
            $builder->options->validateRequired = $this->validateRequired;
            $builder->options->nameTags = $this->nameTags;
            if (!empty($this->renames)) {
                foreach ($this->renames as $rename) {
                    $rename = explode(':', $rename, 2);
                    $builder->options->renames[$rename[0]] = $rename[1];
                }
            }
            $pathToNameHook = new StripPrefixPathToNameHook();

            if (!empty($this->defPtr)) {
                $pathToNameHook->prefixes = [];
                foreach ($this->defPtr as $defPtr) {
                    if (isset($baseName)) {
                        $pathToNameHook->prefixes[] = $baseName . $defPtr;
                    }
                    $pathToNameHook->prefixes[] = $defPtr;
                }
            }

            if (isset($baseName)) {
                $pathToNameHook->prefixes[] = $baseName;
            }

            $builder->pathToNameHook = $pathToNameHook;

            $builder->structCreatedHook = new StructHookCallback(function (StructDef $structDef, $path, $schema) {
                if ('#' === $path) {
                    $structDef->setName($this->rootName);
                }
            });
            if ($schema instanceof Schema) {
                $builder->getType($schema);
            }

            $goFile = new GoFile($this->packageName);
            $goFile->fileComment = 'Code generated by github.com/swaggest/json-cli ' . App::$ver . ', DO NOT EDIT.';
            $goFile->setComment('Package ' . $this->packageName . ' contains JSON mapping structures.');

            $goTestFile = new GoFile($this->packageName . '_test');
            $goTestFile->setPackage($this->packageName);
            $goTestFile->fileComment = 'Code generated by github.com/swaggest/json-cli ' . App::$ver . ', DO NOT EDIT.';

            mt_srand(1);

            foreach ($builder->getGeneratedStructs() as $generatedStruct) {
                if ($skipRoot && $generatedStruct->path === '#') {
                    continue;
                }
                $goFile->getCode()->addSnippet($generatedStruct->structDef);
                if ($this->withTests) {
                    $goTestFile->getCode()->addSnippet(MarshalingTestFunc::make($generatedStruct, $builder->options));
                }
            }
            $goFile->getCode()->addSnippet($builder->getCode());

            if ($this->output) {
                if (!file_exists(dirname($this->output))) {
                    $this->response->error('Destination directory does not exist, please create: ' . dirname($this->output));
                    throw new ExitCode('', 1);
                }
                file_put_contents($this->output, $goFile->render());

                if ($this->withTests) {
                    file_put_contents(str_replace('.go', '_test.go', $this->output), $goTestFile->render());
                }
            } else {
                echo $goFile->render();
            }
        } catch (\Exception $e) {
            $this->response->error($e->getMessage());
            throw new ExitCode('', 1);
        }
    }
}