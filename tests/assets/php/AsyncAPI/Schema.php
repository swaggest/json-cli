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
 * A deterministic version of a JSON Schema object.
 * Built from #/definitions/schema
 */
class Schema extends ClassStructure
{
    const _ARRAY = 'array';

    const BOOLEAN = 'boolean';

    const INTEGER = 'integer';

    const NULL = 'null';

    const NUMBER = 'number';

    const OBJECT = 'object';

    const STRING = 'string';

    const X_PROPERTY_PATTERN = '^x-';

    /** @var string */
    public $ref;

    /** @var string */
    public $format;

    /** @var string */
    public $title;

    /** @var string */
    public $description;

    /** @var mixed */
    public $default;

    /** @var float */
    public $multipleOf;

    /** @var float */
    public $maximum;

    /** @var bool */
    public $exclusiveMaximum;

    /** @var float */
    public $minimum;

    /** @var bool */
    public $exclusiveMinimum;

    /** @var int */
    public $maxLength;

    /** @var int */
    public $minLength;

    /** @var string */
    public $pattern;

    /** @var int */
    public $maxItems;

    /** @var int */
    public $minItems;

    /** @var bool */
    public $uniqueItems;

    /** @var int */
    public $maxProperties;

    /** @var int */
    public $minProperties;

    /** @var string[]|array */
    public $required;

    /** @var array */
    public $enum;

    /** @var Schema|bool */
    public $additionalProperties;

    /** @var array */
    public $type;

    /** @var Schema|Schema[]|array */
    public $items;

    /** @var Schema[]|array */
    public $allOf;

    /** @var Schema[]|array */
    public $oneOf;

    /** @var Schema[]|array */
    public $anyOf;

    /** @var Schema A deterministic version of a JSON Schema object. */
    public $not;

    /** @var Schema[] */
    public $properties;

    /** @var string */
    public $discriminator;

    /** @var bool */
    public $readOnly;

    /** @var Xml */
    public $xml;

    /** @var ExternalDocs information about external documentation */
    public $externalDocs;

    /** @var mixed */
    public $example;

    /**
     * @param Properties|static $properties
     * @param Schema1 $ownerSchema
     */
    public static function setUpProperties($properties, Schema1 $ownerSchema)
    {
        $properties->ref = Schema1::string();
        $ownerSchema->addPropertyMapping('$ref', self::names()->ref);
        $properties->format = Schema1::string();
        $properties->title = Schema1::string();
        $properties->title->setFromRef('http://json-schema.org/draft-04/schema#/properties/title');
        $properties->description = Schema1::string();
        $properties->description->setFromRef('http://json-schema.org/draft-04/schema#/properties/description');
        $properties->default = new Schema1();
        $properties->default->setFromRef('http://json-schema.org/draft-04/schema#/properties/default');
        $properties->multipleOf = Schema1::number();
        $properties->multipleOf->minimum = 0;
        $properties->multipleOf->exclusiveMinimum = true;
        $properties->multipleOf->setFromRef('http://json-schema.org/draft-04/schema#/properties/multipleOf');
        $properties->maximum = Schema1::number();
        $properties->maximum->setFromRef('http://json-schema.org/draft-04/schema#/properties/maximum');
        $properties->exclusiveMaximum = Schema1::boolean();
        $properties->exclusiveMaximum->default = false;
        $properties->exclusiveMaximum->setFromRef('http://json-schema.org/draft-04/schema#/properties/exclusiveMaximum');
        $properties->minimum = Schema1::number();
        $properties->minimum->setFromRef('http://json-schema.org/draft-04/schema#/properties/minimum');
        $properties->exclusiveMinimum = Schema1::boolean();
        $properties->exclusiveMinimum->default = false;
        $properties->exclusiveMinimum->setFromRef('http://json-schema.org/draft-04/schema#/properties/exclusiveMinimum');
        $properties->maxLength = Schema1::integer();
        $properties->maxLength->minimum = 0;
        $properties->maxLength->setFromRef('http://json-schema.org/draft-04/schema#/definitions/positiveInteger');
        $properties->minLength = new Schema1();
        $propertiesMinLengthAllOf0 = Schema1::integer();
        $propertiesMinLengthAllOf0->minimum = 0;
        $propertiesMinLengthAllOf0->setFromRef('http://json-schema.org/draft-04/schema#/definitions/positiveInteger');
        $properties->minLength->allOf[0] = $propertiesMinLengthAllOf0;
        $propertiesMinLengthAllOf1 = new Schema1();
        $propertiesMinLengthAllOf1->default = 0;
        $properties->minLength->allOf[1] = $propertiesMinLengthAllOf1;
        $properties->minLength->setFromRef('http://json-schema.org/draft-04/schema#/definitions/positiveIntegerDefault0');
        $properties->pattern = Schema1::string();
        $properties->pattern->format = "regex";
        $properties->pattern->setFromRef('http://json-schema.org/draft-04/schema#/properties/pattern');
        $properties->maxItems = Schema1::integer();
        $properties->maxItems->minimum = 0;
        $properties->maxItems->setFromRef('http://json-schema.org/draft-04/schema#/definitions/positiveInteger');
        $properties->minItems = new Schema1();
        $propertiesMinItemsAllOf0 = Schema1::integer();
        $propertiesMinItemsAllOf0->minimum = 0;
        $propertiesMinItemsAllOf0->setFromRef('http://json-schema.org/draft-04/schema#/definitions/positiveInteger');
        $properties->minItems->allOf[0] = $propertiesMinItemsAllOf0;
        $propertiesMinItemsAllOf1 = new Schema1();
        $propertiesMinItemsAllOf1->default = 0;
        $properties->minItems->allOf[1] = $propertiesMinItemsAllOf1;
        $properties->minItems->setFromRef('http://json-schema.org/draft-04/schema#/definitions/positiveIntegerDefault0');
        $properties->uniqueItems = Schema1::boolean();
        $properties->uniqueItems->default = false;
        $properties->uniqueItems->setFromRef('http://json-schema.org/draft-04/schema#/properties/uniqueItems');
        $properties->maxProperties = Schema1::integer();
        $properties->maxProperties->minimum = 0;
        $properties->maxProperties->setFromRef('http://json-schema.org/draft-04/schema#/definitions/positiveInteger');
        $properties->minProperties = new Schema1();
        $propertiesMinPropertiesAllOf0 = Schema1::integer();
        $propertiesMinPropertiesAllOf0->minimum = 0;
        $propertiesMinPropertiesAllOf0->setFromRef('http://json-schema.org/draft-04/schema#/definitions/positiveInteger');
        $properties->minProperties->allOf[0] = $propertiesMinPropertiesAllOf0;
        $propertiesMinPropertiesAllOf1 = new Schema1();
        $propertiesMinPropertiesAllOf1->default = 0;
        $properties->minProperties->allOf[1] = $propertiesMinPropertiesAllOf1;
        $properties->minProperties->setFromRef('http://json-schema.org/draft-04/schema#/definitions/positiveIntegerDefault0');
        $properties->required = Schema1::arr();
        $properties->required->items = Schema1::string();
        $properties->required->minItems = 1;
        $properties->required->uniqueItems = true;
        $properties->required->setFromRef('http://json-schema.org/draft-04/schema#/definitions/stringArray');
        $properties->enum = Schema1::arr();
        $properties->enum->minItems = 1;
        $properties->enum->uniqueItems = true;
        $properties->enum->setFromRef('http://json-schema.org/draft-04/schema#/properties/enum');
        $properties->additionalProperties = new Schema1();
        $properties->additionalProperties->anyOf[0] = Schema::schema();
        $properties->additionalProperties->anyOf[1] = Schema1::boolean();
        $properties->additionalProperties->default = (object)array();
        $properties->type = new Schema1();
        $propertiesTypeAnyOf0 = new Schema1();
        $propertiesTypeAnyOf0->enum = array(
            self::_ARRAY,
            self::BOOLEAN,
            self::INTEGER,
            self::NULL,
            self::NUMBER,
            self::OBJECT,
            self::STRING,
        );
        $propertiesTypeAnyOf0->setFromRef('#/definitions/simpleTypes');
        $properties->type->anyOf[0] = $propertiesTypeAnyOf0;
        $propertiesTypeAnyOf1 = Schema1::arr();
        $propertiesTypeAnyOf1->items = new Schema1();
        $propertiesTypeAnyOf1->items->enum = array(
            self::_ARRAY,
            self::BOOLEAN,
            self::INTEGER,
            self::NULL,
            self::NUMBER,
            self::OBJECT,
            self::STRING,
        );
        $propertiesTypeAnyOf1->items->setFromRef('#/definitions/simpleTypes');
        $propertiesTypeAnyOf1->minItems = 1;
        $propertiesTypeAnyOf1->uniqueItems = true;
        $properties->type->anyOf[1] = $propertiesTypeAnyOf1;
        $properties->type->setFromRef('http://json-schema.org/draft-04/schema#/properties/type');
        $properties->items = new Schema1();
        $properties->items->anyOf[0] = Schema::schema();
        $propertiesItemsAnyOf1 = Schema1::arr();
        $propertiesItemsAnyOf1->items = Schema::schema();
        $propertiesItemsAnyOf1->minItems = 1;
        $properties->items->anyOf[1] = $propertiesItemsAnyOf1;
        $properties->items->default = (object)array();
        $properties->allOf = Schema1::arr();
        $properties->allOf->items = Schema::schema();
        $properties->allOf->minItems = 1;
        $properties->oneOf = Schema1::arr();
        $properties->oneOf->items = Schema::schema();
        $properties->oneOf->minItems = 2;
        $properties->anyOf = Schema1::arr();
        $properties->anyOf->items = Schema::schema();
        $properties->anyOf->minItems = 2;
        $properties->not = Schema::schema();
        $properties->properties = Schema1::object();
        $properties->properties->additionalProperties = Schema::schema();
        $properties->properties->default = (object)array();
        $properties->discriminator = Schema1::string();
        $properties->readOnly = Schema1::boolean();
        $properties->readOnly->default = false;
        $properties->xml = Xml::schema();
        $properties->externalDocs = ExternalDocs::schema();
        $properties->example = new Schema1();
        $ownerSchema->type = Schema1::OBJECT;
        $ownerSchema->additionalProperties = false;
        $x = new Schema1();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $x);
        $ownerSchema->description = "A deterministic version of a JSON Schema object.";
        $ownerSchema->setFromRef('#/definitions/schema');
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