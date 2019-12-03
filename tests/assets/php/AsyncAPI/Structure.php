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
 * AsyncAPI 1.2.0 schema.
 * @method static Structure import($data, Context $options = null)
 */
class Structure extends ClassStructure
{
    const CONST_1_0_0 = '1.0.0';

    const CONST_1_1_0 = '1.1.0';

    const CONST_1_2_0 = '1.2.0';

    const X_PROPERTY_PATTERN = '^x-';

    /** @var string The AsyncAPI specification version of this document. */
    public $asyncapi;

    /** @var Info General information about the API. */
    public $info;

    /** @var string The base topic to the API. Example: 'hitch'. */
    public $baseTopic;

    /** @var Server[]|array */
    public $servers;

    /** @var TopicItem[] Relative paths to the individual topics. They must be relative to the 'baseTopic'. */
    public $topics;

    /** @var Stream */
    public $stream;

    /** @var Events */
    public $events;

    /** @var Components An object to hold a set of reusable objects for different aspects of the AsyncAPI Specification. */
    public $components;

    /** @var Tag[]|array */
    public $tags;

    /** @var string[][]|array[][]|array */
    public $security;

    /** @var ExternalDocs information about external documentation */
    public $externalDocs;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->asyncapi = Schema::string();
        $properties->asyncapi->enum = array(
            self::CONST_1_0_0,
            self::CONST_1_1_0,
            self::CONST_1_2_0,
        );
        $properties->asyncapi->description = "The AsyncAPI specification version of this document.";
        $properties->info = Info::schema();
        $properties->baseTopic = Schema::string();
        $properties->baseTopic->description = "The base topic to the API. Example: 'hitch'.";
        $properties->baseTopic->default = "";
        $properties->baseTopic->pattern = "^[^/.]";
        $properties->servers = Schema::arr();
        $properties->servers->items = Server::schema();
        $properties->servers->uniqueItems = true;
        $properties->topics = Schema::object();
        $properties->topics->additionalProperties = false;
        $x = new Schema();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $properties->topics->setPatternProperty('^x-', $x);
        $property777c12 = TopicItem::schema();
        $properties->topics->setPatternProperty('^[^.]', $property777c12);
        $properties->topics->description = "Relative paths to the individual topics. They must be relative to the 'baseTopic'.";
        $properties->topics->setFromRef('#/definitions/topics');
        $properties->stream = Stream::schema();
        $properties->events = Events::schema();
        $properties->components = Components::schema();
        $properties->tags = Schema::arr();
        $properties->tags->items = Tag::schema();
        $properties->tags->uniqueItems = true;
        $properties->security = Schema::arr();
        $properties->security->items = Schema::object();
        $properties->security->items->additionalProperties = Schema::arr();
        $properties->security->items->additionalProperties->items = Schema::string();
        $properties->security->items->setFromRef('#/definitions/SecurityRequirement');
        $properties->externalDocs = ExternalDocs::schema();
        $ownerSchema->type = Schema::OBJECT;
        $ownerSchema->additionalProperties = false;
        $x = new Schema();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $x);
        $ownerSchemaOneOf0 = new Schema();
        $ownerSchemaOneOf0->required = array(
            self::names()->topics,
        );
        $ownerSchema->oneOf[0] = $ownerSchemaOneOf0;
        $ownerSchemaOneOf1 = new Schema();
        $ownerSchemaOneOf1->required = array(
            self::names()->stream,
        );
        $ownerSchema->oneOf[1] = $ownerSchemaOneOf1;
        $ownerSchemaOneOf2 = new Schema();
        $ownerSchemaOneOf2->required = array(
            self::names()->events,
        );
        $ownerSchema->oneOf[2] = $ownerSchemaOneOf2;
        $ownerSchema->id = "http://asyncapi.hitchhq.com/v1/schema.json#";
        $ownerSchema->schema = "http://json-schema.org/draft-04/schema#";
        $ownerSchema->title = "AsyncAPI 1.2.0 schema.";
        $ownerSchema->required = array(
            self::names()->asyncapi,
            self::names()->info,
        );
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