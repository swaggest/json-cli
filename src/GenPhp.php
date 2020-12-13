<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonCli\GenPhp\BuilderOptions;
use Swaggest\JsonSchema\Schema;
use Swaggest\PhpCodeBuilder\App\PhpApp;
use Swaggest\PhpCodeBuilder\JsonSchema\ClassHookCallback;
use Swaggest\PhpCodeBuilder\JsonSchema\PhpBuilder;
use Swaggest\PhpCodeBuilder\PhpClass;
use Swaggest\PhpCodeBuilder\PhpCode;
use Yaoi\Command;

class GenPhp extends Base
{
    use BuilderOptions;

    /** @var string */
    public $ns;
    /** @var string */
    public $nsPath;
    /** @var string */
    public $rootName = 'Structure';

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    public static function setUpDefinition(Command\Definition $definition, $options)
    {
        $definition->description = 'Generate PHP code from JSON schema';
        Base::setupGenOptions($definition, $options);

        $options->ns = Command\Option::create()
            ->setDescription('Namespace to use for generated classes, example \MyClasses')->setType()->setIsRequired();

        $options->nsPath = Command\Option::create()
            ->setDescription('Path to store generated classes, example ./src/MyClasses')
            ->setType()
            ->setIsRequired();

        $options->rootName = Command\Option::create()->setType()
            ->setDescription('Go root struct name, default "Structure", only used for # pointer');

        static::setupBuilderOptions($options);
        Base::setupGenOptions($definition, $options);
    }


    public function performAction()
    {
        try {
            $skipRoot = false;
            $baseName = null;
            $schema = $this->loadSchema($skipRoot, $baseName);

            $appPath = realpath($this->nsPath);
            if (!$appPath) {
                $this->response->error('Could not find directory ' . $this->nsPath);
                throw new ExitCode('', 1);
            }
            $appNs = $this->ns;

            $app = new PhpApp();
            $app->setNamespaceRoot($appNs, '.');

            $builder = new PhpBuilder();
            $this->setupBuilder($builder);

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