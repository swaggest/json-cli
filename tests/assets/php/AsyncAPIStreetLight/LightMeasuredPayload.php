<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace AsyncAPIStreetLight;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * Built from #/components/schemas/lightMeasuredPayload
 *  <- streetlights.yml#/components/messages/lightMeasured/payload
 */
class LightMeasuredPayload extends ClassStructure
{
    /** @var int Light intensity measured in lumens. */
    public $lumens;

    /** @var string Date and time when the message was sent. */
    public $sentAt;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->lumens = Schema::integer();
        $properties->lumens->description = "Light intensity measured in lumens.";
        $properties->lumens->minimum = 0;
        $properties->sentAt = Schema::string();
        $properties->sentAt->description = "Date and time when the message was sent.";
        $properties->sentAt->format = "date-time";
        $properties->sentAt->setFromRef('#/components/schemas/sentAt');
        $ownerSchema->type = Schema::OBJECT;
        $ownerSchema->setFromRef('streetlights.yml#/components/messages/lightMeasured/payload');
    }
}