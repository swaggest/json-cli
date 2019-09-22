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
 * Built from #/definitions/parameter
 */
class Parameter extends ClassStructure
{
    const X_PROPERTY_PATTERN = '^x-';

    /** @var string A brief description of the parameter. This could contain examples of use.  GitHub Flavored Markdown is allowed. */
    public $description;

    /** @var string The name of the parameter. */
    public $name;

    /** @var Schema A deterministic version of a JSON Schema object. */
    public $schema;

    /** @var string */
    public $ref;

    /**
     * @param Properties|static $properties
     * @param Schema1 $ownerSchema
     */
    public static function setUpProperties($properties, Schema1 $ownerSchema)
    {
        $properties->description = Schema1::string();
        $properties->description->description = "A brief description of the parameter. This could contain examples of use.  GitHub Flavored Markdown is allowed.";
        $properties->name = Schema1::string();
        $properties->name->description = "The name of the parameter.";
        $properties->schema = Schema::schema();
        $properties->ref = Schema1::string();
        $ownerSchema->addPropertyMapping('$ref', self::names()->ref);
        $ownerSchema->additionalProperties = false;
        $x = new Schema1();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $x);
        $ownerSchema->setFromRef('#/definitions/parameter');
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