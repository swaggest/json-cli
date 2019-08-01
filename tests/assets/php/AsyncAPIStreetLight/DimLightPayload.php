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
 * Built from #/components/schemas/dimLightPayload
 *  <- streetlights.yml#/components/messages/dimLight/payload
 */
class DimLightPayload extends ClassStructure
{
    /** @var int Percentage to which the light should be dimmed to. */
    public $percentage;

    /** @var string Date and time when the message was sent. */
    public $sentAt;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->percentage = Schema::integer();
        $properties->percentage->description = "Percentage to which the light should be dimmed to.";
        $properties->percentage->maximum = 100;
        $properties->percentage->minimum = 0;
        $properties->sentAt = Schema::string();
        $properties->sentAt->description = "Date and time when the message was sent.";
        $properties->sentAt->format = "date-time";
        $properties->sentAt->setFromRef('#/components/schemas/sentAt');
        $ownerSchema->type = 'object';
        $ownerSchema->components = (object)array(
            'schemas' => 
            (object)(array(
                 'sentAt' => 
                (object)(array(
                     'description' => 'Date and time when the message was sent.',
                     'type' => 'string',
                     'format' => 'date-time',
                )),
            )),
        );
        $ownerSchema->setFromRef('streetlights.yml#/components/messages/dimLight/payload');
    }
}