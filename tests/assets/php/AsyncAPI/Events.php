<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace AsyncAPI;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\Exception\StringException;
use Swaggest\JsonSchema\Helper;
use Swaggest\JsonSchema\InvalidValue;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * Events Object
 * Built from #/definitions/events
 * @method static Events import($data, Context $options = null)
 */
class Events extends ClassStructure
{
    const X_PROPERTY_PATTERN = '^x-';

    /** @var Message[]|array */
    public $receive;

    /** @var Message[]|array */
    public $send;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->receive = Schema::arr();
        $properties->receive->items = Message::schema();
        $properties->receive->title = "Events Receive Object";
        $properties->receive->minItems = 1;
        $properties->receive->uniqueItems = true;
        $properties->send = Schema::arr();
        $properties->send->items = Message::schema();
        $properties->send->title = "Events Send Object";
        $properties->send->minItems = 1;
        $properties->send->uniqueItems = true;
        $ownerSchema->type = Schema::OBJECT;
        $ownerSchema->additionalProperties = false;
        $x = new Schema();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $x);
        $ownerSchemaAnyOf0 = new Schema();
        $ownerSchemaAnyOf0->required = array(
            self::names()->receive,
        );
        $ownerSchema->anyOf[0] = $ownerSchemaAnyOf0;
        $ownerSchemaAnyOf1 = new Schema();
        $ownerSchemaAnyOf1->required = array(
            self::names()->send,
        );
        $ownerSchema->anyOf[1] = $ownerSchemaAnyOf1;
        $ownerSchema->title = "Events Object";
        $ownerSchema->minProperties = 1;
        $ownerSchema->setFromRef('#/definitions/events');
    }

    /**
     * @return array
     * @codeCoverageIgnoreStart
     */
    public function getXValues()
    {
        $result = array();
        if (!$names = $this->getPatternPropertyNames(self::X_PROPERTY_PATTERN)) {
            return $result;
        }
        foreach ($names as $name) {
            $result[$name] = $this->$name;
        }
        return $result;
    }
    /** @codeCoverageIgnoreEnd */

    /**
     * @param string $name
     * @param mixed $value
     * @return self
     * @throws InvalidValue
     * @codeCoverageIgnoreStart
     */
    public function setXValue($name, $value)
    {
        if (preg_match(Helper::toPregPattern(self::X_PROPERTY_PATTERN), $name)) {
            throw new StringException('Pattern mismatch', StringException::PATTERN_MISMATCH);
        }
        $this->addPatternPropertyName(self::X_PROPERTY_PATTERN, $name);
        $this->{$name} = $value;
        return $this;
    }
    /** @codeCoverageIgnoreEnd */
}