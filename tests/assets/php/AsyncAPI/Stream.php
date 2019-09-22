<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace AsyncAPI;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Exception\StringException;
use Swaggest\JsonSchema\Helper;
use Swaggest\JsonSchema\InvalidValue;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * Stream Object
 * Built from #/definitions/stream
 */
class Stream extends ClassStructure
{
    const X_PROPERTY_PATTERN = '^x-';

    /** @var StreamFraming */
    public $framing;

    /** @var Message[]|array */
    public $read;

    /** @var Message[]|array */
    public $write;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->framing = Schema::object();
        $x = new Schema();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $properties->framing->setPatternProperty('^x-', $x);
        $properties->framing->oneOf[0] = StreamFraming::schema();
        $properties->framing->oneOf[1] = StreamFraming::schema();
        $properties->framing->title = "Stream Framing Object";
        $properties->framing->minProperties = 1;
        $properties->read = Schema::arr();
        $properties->read->items = Message::schema();
        $properties->read->title = "Stream Read Object";
        $properties->read->minItems = 1;
        $properties->read->uniqueItems = true;
        $properties->write = Schema::arr();
        $properties->write->items = Message::schema();
        $properties->write->title = "Stream Write Object";
        $properties->write->minItems = 1;
        $properties->write->uniqueItems = true;
        $ownerSchema->type = Schema::OBJECT;
        $ownerSchema->additionalProperties = false;
        $x = new Schema();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $x);
        $ownerSchema->title = "Stream Object";
        $ownerSchema->minProperties = 1;
        $ownerSchema->setFromRef('#/definitions/stream');
    }

    /**
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