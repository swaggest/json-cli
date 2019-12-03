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
use Swaggest\JsonSchema\Schema as Schema1;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * Built from #/definitions/message
 * @property mixed $example
 */
class Message extends ClassStructure
{
    const X_PROPERTY_PATTERN = '^x-';

    /** @var string */
    public $ref;

    /** @var Schema A deterministic version of a JSON Schema object. */
    public $headers;

    /** @var Schema A deterministic version of a JSON Schema object. */
    public $payload;

    /** @var Tag[]|array */
    public $tags;

    /** @var string A brief summary of the message. */
    public $summary;

    /** @var string A longer description of the message. CommonMark is allowed. */
    public $description;

    /** @var ExternalDocs information about external documentation */
    public $externalDocs;

    /** @var bool */
    public $deprecated;

    /**
     * @param Properties|static $properties
     * @param Schema1 $ownerSchema
     */
    public static function setUpProperties($properties, Schema1 $ownerSchema)
    {
        $properties->ref = Schema1::string();
        $ownerSchema->addPropertyMapping('$ref', self::names()->ref);
        $properties->headers = Schema::schema();
        $properties->payload = Schema::schema();
        $properties->tags = Schema1::arr();
        $properties->tags->items = Tag::schema();
        $properties->tags->uniqueItems = true;
        $properties->summary = Schema1::string();
        $properties->summary->description = "A brief summary of the message.";
        $properties->description = Schema1::string();
        $properties->description->description = "A longer description of the message. CommonMark is allowed.";
        $properties->externalDocs = ExternalDocs::schema();
        $properties->deprecated = Schema1::boolean();
        $properties->deprecated->default = false;
        $properties->example = new Schema1();
        $ownerSchema->type = Schema1::OBJECT;
        $ownerSchema->additionalProperties = false;
        $x = new Schema1();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $x);
        $ownerSchema->setFromRef('#/definitions/message');
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
        if (!preg_match(Helper::toPregPattern(self::X_PROPERTY_PATTERN), $name)) {
            throw new StringException('Pattern mismatch', StringException::PATTERN_MISMATCH);
        }
        $this->addPatternPropertyName(self::X_PROPERTY_PATTERN, $name);
        $this->{$name} = $value;
        return $this;
    }
    /** @codeCoverageIgnoreEnd */
}