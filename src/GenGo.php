<?php

namespace Swaggest\JsonCli;


use Swaggest\GoCodeBuilder\JsonSchema\GoBuilder;
use Swaggest\GoCodeBuilder\JsonSchema\StructHookCallback;
use Swaggest\GoCodeBuilder\Templates\GoFile;
use Swaggest\GoCodeBuilder\Templates\Struct\StructDef;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\RemoteRef\Preloaded;
use Swaggest\JsonSchema\Schema;
use Yaoi\Command;

class GenGo extends Command
{
    /** @var string */
    public $schema;
    /** @var string */
    public $packageName = 'entities';
    /** @var string */
    public $rootName = 'Structure';
    /** @var bool */
    public $showConstProperties = false;
    /** @var bool */
    public $keepParentInPropertyNames = false;
    /** @var string */
    public $defPtr = '#/definitions/';
    /** @var []string */
    public $ptrInSchema;


    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    public static function setUpDefinition(Command\Definition $definition, $options)
    {
        $definition->description = 'Generate Go code from JSON schema, output to STDOUT';
        $options->schema = Command\Option::create()
            ->setDescription('Path to JSON schema file')->setIsUnnamed()->setIsRequired();

        $options->ptrInSchema = Command\Option::create()->setType()->setIsUnnamed()->setIsVariadic()
            ->setDescription('JSON pointer to structure in in root schema, default #');

        $options->packageName = Command\Option::create()->setType()
            ->setDescription('Go package name, default "entities"');

        $options->rootName = Command\Option::create()->setType()
            ->setDescription('Go root struct name, default "Structure"');

        $options->defPtr = Command\Option::create()->setType()
            ->setDescription('Definitions pointer, default #/definitions');

        $options->showConstProperties = Command\Option::create()
            ->setDescription('Show properties with constant values, hidden by default');

        $options->keepParentInPropertyNames = Command\Option::create()
            ->setDescription('Keep parent prefix in property name, removed by default');

    }


    public function performAction()
    {


        $dataValue = Base::readJsonOrYaml($this->schema, $this->response);
        if (!$dataValue) {
            $this->response->error('Unable to find schema in ' . $this->schema);
            die(1);
        }
        if (empty($this->ptrInSchema)) {
            $schemas = [Schema::import($dataValue)];
        } else {
            $preloaded = new Preloaded();
            $preloaded->setSchemaData($this->schema, $dataValue);

            $data = (object)[
                Schema::PROP_REF => $this->schema . $this->ptrInSchema
            ];
            $schema = Schema::import($data, new Context($preloaded));
        }

        $builder = new GoBuilder();
        $builder->options->hideConstProperties = !$this->showConstProperties;
        $builder->options->trimParentFromPropertyNames = !$this->keepParentInPropertyNames;
        $builder->structCreatedHook = new StructHookCallback(function (StructDef $structDef, $path, $schema) use ($builder) {
            if ('#' === $path) {
                $structDef->setName($this->rootName);
            } elseif (0 === strpos($path, $this->defPtr)) {
                $name = $builder->codeBuilder->exportableName(substr($path, strlen($this->defPtr)));
                $structDef->setName($name);
            }
        });
        $builder->getType($schema);

        $goFile = new GoFile($this->packageName);
        $goFile->fileComment = 'Code generated by github.com/swaggest/json-cli, DO NOT EDIT.';
        $goFile->setComment('Package ' . $this->packageName . ' contains JSON mapping structures.');
        foreach ($builder->getGeneratedStructs() as $generatedStruct) {
            $goFile->getCode()->addSnippet($generatedStruct->structDef);
        }
        $goFile->getCode()->addSnippet($builder->getCode());

        echo $goFile->render();
    }
}