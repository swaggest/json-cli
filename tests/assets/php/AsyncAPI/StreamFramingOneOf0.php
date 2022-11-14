<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace AsyncAPI;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


class StreamFramingOneOf0 extends ClassStructure
{
    const CHUNKED = 'chunked';

    const R_N = '\\r\\n';

    const N = '\\n';

    /** @var string */
    public $type;

    /** @var string */
    public $delimiter;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->type = Schema::string();
        $properties->type->enum = array(
            self::CHUNKED,
        );
        $properties->delimiter = Schema::string();
        $properties->delimiter->enum = array(
            self::R_N,
            self::N,
        );
        $properties->delimiter->default = "\\r\\n";
        $ownerSchema->additionalProperties = false;
    }
}