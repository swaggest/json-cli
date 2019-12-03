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
 * An object representing a Server.
 * Built from #/definitions/server
 */
class Server extends ClassStructure
{
    const KAFKA = 'kafka';

    const KAFKA_SECURE = 'kafka-secure';

    const AMQP = 'amqp';

    const AMQPS = 'amqps';

    const MQTT = 'mqtt';

    const MQTTS = 'mqtts';

    const SECURE_MQTT = 'secure-mqtt';

    const WS = 'ws';

    const WSS = 'wss';

    const STOMP = 'stomp';

    const STOMPS = 'stomps';

    const JMS = 'jms';

    const HTTP = 'http';

    const HTTPS = 'https';

    const X_PROPERTY_PATTERN = '^x-';

    /** @var string */
    public $url;

    /** @var string */
    public $description;

    /** @var string The transfer protocol. */
    public $scheme;

    /** @var string */
    public $schemeVersion;

    /** @var ServerVariable[] */
    public $variables;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->url = Schema::string();
        $properties->description = Schema::string();
        $properties->scheme = Schema::string();
        $properties->scheme->enum = array(
            self::KAFKA,
            self::KAFKA_SECURE,
            self::AMQP,
            self::AMQPS,
            self::MQTT,
            self::MQTTS,
            self::SECURE_MQTT,
            self::WS,
            self::WSS,
            self::STOMP,
            self::STOMPS,
            self::JMS,
            self::HTTP,
            self::HTTPS,
        );
        $properties->scheme->description = "The transfer protocol.";
        $properties->schemeVersion = Schema::string();
        $properties->variables = Schema::object();
        $properties->variables->additionalProperties = ServerVariable::schema();
        $properties->variables->setFromRef('#/definitions/serverVariables');
        $ownerSchema->type = Schema::OBJECT;
        $ownerSchema->additionalProperties = false;
        $x = new Schema();
        $x->additionalProperties = true;
        $x->additionalItems = true;
        $x->description = "Any property starting with x- is valid.";
        $x->setFromRef('#/definitions/vendorExtension');
        $ownerSchema->setPatternProperty('^x-', $x);
        $ownerSchema->description = "An object representing a Server.";
        $ownerSchema->required = array(
            self::names()->url,
            self::names()->scheme,
        );
        $ownerSchema->setFromRef('#/definitions/server');
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