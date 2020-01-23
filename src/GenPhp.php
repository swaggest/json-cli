<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonCli\JsonSchema\ResolverMux;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\RemoteRef\BasicFetcher;
use Swaggest\JsonSchema\RemoteRef\Preloaded;
use Swaggest\JsonSchema\Schema;
use Swaggest\PhpCodeBuilder\App\PhpApp;
use Swaggest\PhpCodeBuilder\JsonSchema\ClassHookCallback;
use Swaggest\PhpCodeBuilder\JsonSchema\PhpBuilder;
use Swaggest\PhpCodeBuilder\PhpClass;
use Swaggest\PhpCodeBuilder\PhpCode;
use Yaoi\Command;

class GenPhp extends Command
{
    /** @var string */
    public $schema;
    /** @var string */
    public $ns;
    /** @var string */
    public $nsPath;
    /** @var string */
    public $rootName = 'Structure';
    /** @var string[] */
    public $defPtr = ['#/definitions'];
    /** @var string[] */
    public $ptrInSchema;

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
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    public static function setUpDefinition(Command\Definition $definition, $options)
    {
        $definition->description = 'Generate PHP code from JSON schema';
        $options->schema = Command\Option::create()
            ->setDescription('Path to JSON schema file')->setIsUnnamed()->setIsRequired();

        $options->ns = Command\Option::create()
            ->setDescription('Namespace to use for generated classes, example \MyClasses')->setType()->setIsRequired();

        $options->nsPath = Command\Option::create()
            ->setDescription('Path to store generated classes, example ./src/MyClasses')
            ->setType()
            ->setIsRequired();

        $options->ptrInSchema = Command\Option::create()->setType()->setIsVariadic()
            ->setDescription('JSON pointers to structure in in root schema, default #');

        $options->rootName = Command\Option::create()->setType()
            ->setDescription('Go root struct name, default "Structure", only used for # pointer');

        $options->defPtr = Command\Option::create()->setType()->setIsVariadic()
            ->setDescription('Definitions pointers to strip from symbol names, default #/definitions');

        $options->setters = Command\Option::create()->setDescription('Build setters');
        $options->getters = Command\Option::create()->setDescription('Build getters');
        $options->noEnumConst = Command\Option::create()
            ->setDescription('Do not create constants for enum/const values');

        $options->declarePropertyDefaults = Command\Option::create()
            ->setDescription('Use default values to initialize properties');

        $options->buildAdditionalPropertiesAccessors = Command\Option::create()
            ->setDescription('Build accessors for additionalProperties');

    }


    public function performAction()
    {
        try {


            $dataValue = Base::readJsonOrYaml($this->schema, $this->response);
            if (!$dataValue) {
                $this->response->error('Unable to find schema in ' . $this->schema);
                die(1);
            }

            $baseName = null;
            $skipRoot = false;
            $data = $dataValue;

            $resolver = new ResolverMux();

            if (!empty($this->ptrInSchema)) {
                $baseName = basename($this->schema);
                $skipRoot = true;
                $preloaded = new Preloaded();
                $preloaded->setSchemaData($baseName, $dataValue);
                $resolver->resolvers[] = $preloaded;
                $data = new \stdClass();
                foreach ($this->ptrInSchema as $i => $ptr) {
                    $data->oneOf[$i] = (object)[Schema::PROP_REF => $baseName . $ptr];
                }
            }

            $resolver->resolvers[] = new BasicFetcher();
            $schema = Schema::import($data, new Context($resolver));


            $appPath = realpath($this->nsPath);
            if (!$appPath) {
                $this->response->error('Could not find directory ' . $this->nsPath);
                throw new ExitCode('', 1);
            }
            $appNs = $this->ns;

            $app = new PhpApp();
            $app->setNamespaceRoot($appNs, '.');

            $builder = new PhpBuilder();
            $builder->buildSetters = $this->setters;
            $builder->buildGetters = $this->getters;

            $builder->makeEnumConstants = !$this->noEnumConst;
            $builder->declarePropertyDefaults = $this->declarePropertyDefaults;
            $builder->buildAdditionalPropertyMethodsOnTrue = $this->buildAdditionalPropertiesAccessors;

            $builder->classCreatedHook = new ClassHookCallback(function (PhpClass $class, $path, $schema)
            use ($app, $appNs, $skipRoot, $baseName) {
                if ($skipRoot && '#' === $path) {
                    return;
                }

                $desc = '';
                if ($schema->title) {
                    $desc = $schema->title;
                }
                if ($schema->description) {
                    $desc .= "\n" . $schema->description;
                }
                if ($fromRefs = $schema->getFromRefs()) {
                    $desc .= "\nBuilt from " . implode("\n" . ' <- ', $fromRefs);
                }
                $class->setDescription(trim($desc));

                $class->setNamespace($appNs);
                if ('#' === $path) {
                    $class->setName($this->rootName);
                } else {
                    if (!empty($fromRefs)) {
                        $path = $fromRefs[0];
                    }
                    foreach ($this->defPtr as $defPtr) {
                        if (isset($baseName)) {
                            $baseNameDefPtr = $baseName . $defPtr;
                            if ($baseNameDefPtr === substr($path, 0, strlen($baseNameDefPtr))) {
                                $path = substr($path, strlen($baseNameDefPtr));
                                $className = PhpCode::makePhpClassName($path);
                                $class->setName($className);
                            }
                        }

                        if ($defPtr === substr($path, 0, strlen($defPtr))) {
                            $className = PhpCode::makePhpClassName(substr($path, strlen($defPtr)));
                            $class->setName($className);
                        }
                    }
                }
                $app->addClass($class);
            });

            if (!$schema instanceof Schema) {
                $this->response->error('failed to assert Schema type, ' . get_class($schema) . ' received');
                throw new ExitCode('', 1);
            }
            $builder->getType($schema);
            $app->store($appPath);
            $this->response->success("Classes are generated in " . $appPath);
        } catch (\Exception $e) {
            $this->response->error($e->getMessage());
            throw new ExitCode('', 1);
        }
    }
}