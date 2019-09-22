<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace Swagger;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Exception\StringException;
use Swaggest\JsonSchema\Helper;
use Swaggest\JsonSchema\InvalidValue;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * General information about the API.
 * Built from swagger-schema.json#/definitions/info
 */
class Info extends ClassStructure
{
    const X_PROPERTY_PATTERN = '^x-';

    /** @var string A unique and precise title of the API. */
    public $title;

    /** @var string A semantic version number of the API. */
    public $version;

    /** @var string A longer description of the API. Should be different from the title.  GitHub Flavored Markdown is allowed. */
    public $description;

    /** @var string The terms of service for the API. */
    public $termsOfService;

    /** @var Contact Contact information for the owners of the API. */
    public $contact;

    /** @var License */
    public $license;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->title = Schema::string();
        $properties->title->description = "A unique and precise title of the API.";
        $properties->version = Schema::string();
        $properties->version->description = "A semantic version number of the API.";
        $properties->description = Schema::string();
        $properties->description->description = "A longer description of the API. Should be different from the title.  GitHub Flavored Markdown is allowed.";
        $properties->termsOfService = Schema::string();
        $properties->termsOfService->description = "The terms of service for the API.";
        $properties->contact = Contact::schema();
        $properties->license = License::schema();
        $ownerSchema->type = Schema::OBJECT;
        $ownerSchema->additionalProperties = false;
        $x = new Schema();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $x);
        $ownerSchema->description = "General information about the API.";
        $ownerSchema->required = array(
            self::names()->version,
            self::names()->title,
        );
        $ownerSchema->setFromRef('swagger-schema.json#/definitions/info');
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