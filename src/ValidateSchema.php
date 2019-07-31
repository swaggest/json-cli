<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonSchema\InvalidValue;
use Swaggest\JsonSchema\Schema;
use Yaoi\Command;

class ValidateSchema extends Base
{
    public $schema;
    public $data;

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Command\Definition $definition, $options)
    {
        $options->data = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to data (JSON/YAML)');
        $options->schema = Command\Option::create()->setIsUnnamed()
            ->setDescription('Path to schema, default JSON Schema');
    }


    /**
     * @throws ExitCode
     * @throws \Swaggest\JsonSchema\Exception
     */
    public function performAction()
    {
        if ($this->schema) {
            $schemaData = $this->readData($this->schema);
            try {
                $schema = Schema::import($schemaData);
            } catch (InvalidValue $e) {
                $this->response->error('Invalid schema');
                $this->response->addContent($e->getMessage());
                throw new ExitCode('', 1);
            } catch (\Exception $e) {
                $this->response->error('Failed to import schema:' . $e->getMessage());
                throw new ExitCode('', 1);
            }
        } else {
            $schema = new Schema();
        }

        $data = $this->readData($this->data);

        try {
            $schema->in($data);
            $this->response->success('Data is valid');
        } catch (InvalidValue $exception) {
            $this->response->error('Data is invalid');
            $this->response->addContent($exception->getMessage());
            throw new ExitCode('', 1);
        }
    }
}