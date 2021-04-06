<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonCli\GenPhp\BuilderOptions;
use Swaggest\JsonSchema\Schema;
use Swaggest\PhpCodeBuilder\JSDoc\TypeBuilder;
use Yaoi\Command;

class GenJSDoc extends Base
{
    use BuilderOptions;

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    public static function setUpDefinition(Command\Definition $definition, $options)
    {
        $definition->description = 'Generate JSDoc code from JSON schema';
        Base::setupGenOptions($definition, $options);
    }


    public function performAction()
    {
        try {
            $skipRoot = false;
            $baseName = null;
            $schema = $this->loadSchema($skipRoot, $baseName);

            $jb = new TypeBuilder();
            $jb->trimNamePrefix = $this->defPtr;

            if (!$schema instanceof Schema) {
                $this->response->error('failed to assert Schema type, ' . get_class($schema) . ' received');
                throw new ExitCode('', 1);
            }

            $jb->getTypeString($schema);

            if ($this->output) {
                if (!file_exists(dirname($this->output))) {
                    $this->response->error('Destination directory does not exist, please create: ' . dirname($this->output));
                    throw new ExitCode('', 1);
                }
                file_put_contents($this->output, $jb->file);

            } else {
                echo $jb->file;
            }
        } catch (\Exception $e) {
            throw $e;
            $this->response->error($e->getMessage());
            throw new ExitCode('', 1);
        }
    }
}