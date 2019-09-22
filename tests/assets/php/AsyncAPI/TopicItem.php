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
 * Built from #/definitions/topicItem
 */
class TopicItem extends ClassStructure
{
    const X_PROPERTY_PATTERN = '^x-';

    /** @var string */
    public $ref;

    /** @var Parameter[]|array */
    public $parameters;

    /** @var Message|Operation */
    public $publish;

    /** @var Message|Operation */
    public $subscribe;

    /** @var bool */
    public $deprecated;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->ref = Schema::string();
        $ownerSchema->addPropertyMapping('$ref', self::names()->ref);
        $properties->parameters = Schema::arr();
        $properties->parameters->items = Parameter::schema();
        $properties->parameters->minItems = 1;
        $properties->parameters->uniqueItems = true;
        $properties->publish = new Schema();
        $properties->publish->oneOf[0] = Message::schema();
        $properties->publish->oneOf[1] = Operation::schema();
        $properties->publish->setFromRef('#/definitions/operation');
        $properties->subscribe = new Schema();
        $properties->subscribe->oneOf[0] = Message::schema();
        $properties->subscribe->oneOf[1] = Operation::schema();
        $properties->subscribe->setFromRef('#/definitions/operation');
        $properties->deprecated = Schema::boolean();
        $properties->deprecated->default = false;
        $ownerSchema->type = Schema::OBJECT;
        $ownerSchema->additionalProperties = false;
        $x = new Schema();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $x);
        $ownerSchema->minProperties = 1;
        $ownerSchema->setFromRef('#/definitions/topicItem');
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