<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace AsyncAPI;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema as Schema1;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * An object to hold a set of reusable objects for different aspects of the AsyncAPI Specification.
 * Built from #/definitions/components
 */
class Components extends ClassStructure
{
    /** @var Schema[] JSON objects describing schemas the API uses. */
    public $schemas;

    /** @var Message[] JSON objects describing the messages being consumed and produced by the API. */
    public $messages;

    /** @var Reference[]|UserPassword[]|ApiKey[]|X509[]|SymmetricEncryption[]|AsymmetricEncryption[]|NonBearerHTTPSecurityScheme[]|BearerHTTPSecurityScheme[]|APIKeyHTTPSecurityScheme[] */
    public $securitySchemes;

    /** @var Parameter[] JSON objects describing re-usable topic parameters. */
    public $parameters;

    /**
     * @param Properties|static $properties
     * @param Schema1 $ownerSchema
     */
    public static function setUpProperties($properties, Schema1 $ownerSchema)
    {
        $properties->schemas = Schema1::object();
        $properties->schemas->additionalProperties = Schema::schema();
        $properties->schemas->description = "JSON objects describing schemas the API uses.";
        $properties->schemas->setFromRef('#/definitions/schemas');
        $properties->messages = Schema1::object();
        $properties->messages->additionalProperties = Message::schema();
        $properties->messages->description = "JSON objects describing the messages being consumed and produced by the API.";
        $properties->messages->setFromRef('#/definitions/messages');
        $properties->securitySchemes = Schema1::object();
        $aZAZ09 = new Schema1();
        $aZAZ09->oneOf[0] = Reference::schema();
        $aZAZ09OneOf1 = new Schema1();
        $aZAZ09OneOf1->oneOf[0] = UserPassword::schema();
        $aZAZ09OneOf1->oneOf[1] = ApiKey::schema();
        $aZAZ09OneOf1->oneOf[2] = X509::schema();
        $aZAZ09OneOf1->oneOf[3] = SymmetricEncryption::schema();
        $aZAZ09OneOf1->oneOf[4] = AsymmetricEncryption::schema();
        $aZAZ09OneOf1OneOf5 = new Schema1();
        $aZAZ09OneOf1OneOf5->oneOf[0] = NonBearerHTTPSecurityScheme::schema();
        $aZAZ09OneOf1OneOf5->oneOf[1] = BearerHTTPSecurityScheme::schema();
        $aZAZ09OneOf1OneOf5->oneOf[2] = APIKeyHTTPSecurityScheme::schema();
        $aZAZ09OneOf1OneOf5->setFromRef('#/definitions/HTTPSecurityScheme');
        $aZAZ09OneOf1->oneOf[5] = $aZAZ09OneOf1OneOf5;
        $aZAZ09OneOf1->setFromRef('#/definitions/SecurityScheme');
        $aZAZ09->oneOf[1] = $aZAZ09OneOf1;
        $properties->securitySchemes->setPatternProperty('^[a-zA-Z0-9\\.\\-_]+$', $aZAZ09);
        $properties->parameters = Schema1::object();
        $properties->parameters->additionalProperties = Parameter::schema();
        $properties->parameters->description = "JSON objects describing re-usable topic parameters.";
        $properties->parameters->setFromRef('#/definitions/parameters');
        $ownerSchema->type = Schema1::OBJECT;
        $ownerSchema->additionalProperties = false;
        $ownerSchema->description = "An object to hold a set of reusable objects for different aspects of the AsyncAPI Specification.";
        $ownerSchema->setFromRef('#/definitions/components');
    }
}