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
 * General information about the API.
 * Built from #/definitions/info
 */
class Info extends ClassStructure
{
    const X_PROPERTY_PATTERN = '^x-';

    /** @var string A unique and precise title of the API. */
    public $title;

    /** @var string A semantic version number of the API. */
    public $version;

    /** @var string A longer description of the API. Should be different from the title. CommonMark is allowed. */
    public $description;

    /** @var string A URL to the Terms of Service for the API. MUST be in the format of a URL. */
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
        $properties->description->description = "A longer description of the API. Should be different from the title. CommonMark is allowed.";
        $properties->termsOfService = Schema::string();
        $properties->termsOfService->description = "A URL to the Terms of Service for the API. MUST be in the format of a URL.";
        $properties->termsOfService->format = "uri";
        $properties->contact = Contact::schema();
        $properties->license = License::schema();
        $ownerSchema->type = 'object';
        $ownerSchema->additionalProperties = false;
        $patternProperty = new Schema();
        $patternProperty->additionalProperties = true;
        $patternProperty->additionalItems = true;
        $patternProperty->description = "Any property starting with x- is valid.";
        $patternProperty->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $patternProperty);
        $ownerSchema->description = "General information about the API.";
        $ownerSchema->required = array(
            0 => 'version',
            1 => 'title',
        );
        $ownerSchema->setFromRef('#/definitions/info');
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