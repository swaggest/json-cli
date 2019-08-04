<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace AsyncAPI;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


class NonBearerHTTPSecuritySchemeNot extends ClassStructure
{
    const BEARER = 'bearer';

    /** @var string */
    public $scheme;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->scheme = Schema::string();
        $properties->scheme->enum = array(
            self::BEARER,
        );
        $ownerSchema->type = 'object';
    }
}