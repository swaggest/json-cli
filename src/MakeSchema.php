<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonSchema\InvalidValue;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchemaMaker\JsonSchemaFromInstance;
use Yaoi\Command;

class MakeSchema extends Base
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


        $maker = new JsonSchemaFromInstance($schema);
        $maker->addInstanceValue($data);

        print_r(json_encode($schema, JSON_PRETTY_PRINT));

        $this->out = Schema::export($schema);
    }
}