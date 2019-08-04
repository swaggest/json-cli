<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace AsyncAPI;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


class StreamFraming extends ClassStructure
{
    const SSE = 'sse';

    const N_N = '\\n\\n';

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
            self::SSE,
        );
        $properties->delimiter = Schema::string();
        $properties->delimiter->enum = array(
            self::N_N,
        );
        $properties->delimiter->default = "\\n\\n";
        $ownerSchema->additionalProperties = false;
    }
}