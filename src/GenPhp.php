<?php

namespace Swaggest\JsonCli;


use Swaggest\GoCodeBuilder\JsonSchema\GoBuilder;
use Swaggest\GoCodeBuilder\JsonSchema\StructHookCallback;
use Swaggest\GoCodeBuilder\Templates\GoFile;
use Swaggest\GoCodeBuilder\Templates\Struct\StructDef;
use Swaggest\JsonSchema\Schema;
use Yaoi\Command;

class GenPhp extends Command
{
    /** @var string */
    public $schema;
    /** @var string */
    public $packageName = 'entities';
    /** @var string */
    public $rootName = 'Structure';
    /** @var bool */
    public $hideConstProperties = true;
    /** @var bool */
    public $trimParentFromPropertyNames = true;

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    public static function setUpDefinition(Command\Definition $definition, $options)
    {
        $definition->description = 'Generate Go code from JSON schema, output to STDOUT';
        $options->schema = Command\Option::create()
            ->setDescription('Path to JSON schema file')->setIsUnnamed()->setIsRequired();

        $options->packageName = Command\Option::create()->setType()
            ->setDescription('Go package name, default "entities"');
        $options->rootName = Command\Option::create()->setType()
            ->setDescription('Go root struct name, default "Structure"');

//        $options->hideConstProperties = Command\Option::create()
//            ->setDescription('Hide properties with constant values');
//
//        $options->trimParentFromPropertyNames = Command\Option::create()
//            ->setDescription('Remove parent prefix from property name');

    }


    public function performAction()
    {
        $schemaData = json_decode(file_get_contents($this->schema));
        if (!$schemaData) {
            $this->response->error('Unable to find schema in ' . $this->schema);
            die(1);
        }
        $schema = Schema::import($schemaData);


        $builder = new GoBuilder();
        $builder->options->hideConstProperties = $this->hideConstProperties;
        $builder->options->trimParentFromPropertyNames = $this->trimParentFromPropertyNames;
        $builder->structCreatedHook = new StructHookCallback(function (StructDef $structDef, $path, $schema) use ($builder) {
            if ('#' === $path) {
                $structDef->setName($this->rootName);
            } elseif (0 === strpos($path, '#/definitions/')) {
                $name = $builder->codeBuilder->exportableName(substr($path, strlen('#/definitions/')));
                $structDef->setName($name);
            }
        });
        $builder->getType($schema);

        $goFile = new GoFile($this->packageName);
        foreach ($builder->getGeneratedStructs() as $generatedStruct) {
            $goFile->getCode()->addSnippet($generatedStruct->structDef);
        }
        $goFile->getCode()->addSnippet($builder->getCode());

        echo $goFile->render();
    }
}