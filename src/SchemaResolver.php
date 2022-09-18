<?php

namespace Swaggest\JsonCli;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;

class SchemaResolver extends ClassStructure
{
    public $schemaData = [];

    public $schemaFiles = [];

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->schemaData = Schema::object()->setAdditionalProperties(Schema::object())
            ->setDescription('Map of schema url to schema data.');
        $properties->schemaFiles = Schema::object()->setAdditionalProperties(Schema::string())
            ->setDescription('Map of schema url to file path containing schema data.');
    }
}