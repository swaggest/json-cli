<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace Issue39;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


class Structure extends ClassStructure
{
    /** @var int|float|LabelAnyOf2|LabelAnyOf3 */
    public $label;

    /** @var int|float|Label2OneOf2|Label2OneOf3 */
    public $label2;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->label = new Schema();
        $properties->label->anyOf[0] = Schema::integer();
        $properties->label->anyOf[1] = Schema::number();
        $properties->label->anyOf[2] = LabelAnyOf2::schema();
        $properties->label->anyOf[3] = LabelAnyOf3::schema();
        $properties->label2 = new Schema();
        $properties->label2->oneOf[0] = Schema::integer();
        $properties->label2->oneOf[1] = Schema::number();
        $properties->label2->oneOf[2] = Label2OneOf2::schema();
        $properties->label2->oneOf[3] = Label2OneOf3::schema();
        $ownerSchema->type = Schema::OBJECT;
        $ownerSchema->id = "/Test";
    }
}