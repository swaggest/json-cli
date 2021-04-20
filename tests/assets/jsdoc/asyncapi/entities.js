/**
 * Contact information for the owners of the API.
 * @typedef Contact
 * @type {Object}
 * @property {String} name - The identifying name of the contact person/organization.
 * @property {String} url - The URL pointing to the contact information.
 * @property {String} email - The email address of the contact person/organization.
 */

/**
 * @typedef License
 * @type {Object}
 * @property {String} name - The name of the license type. It's encouraged to use an OSI compatible license.
 * @property {String} url - The URL pointing to the license.
 */

/**
 * General information about the API.
 * @typedef Info
 * @type {Object}
 * @property {String} title - A unique and precise title of the API.
 * @property {String} version - A semantic version number of the API.
 * @property {String} description - A longer description of the API. Should be different from the title. CommonMark is allowed.
 * @property {String} termsOfService - A URL to the Terms of Service for the API. MUST be in the format of a URL.
 * @property {Contact|Object|Array} contact - Contact information for the owners of the API.
 * @property {License|Object|Array} license
 */

/**
 * An object representing a Server Variable for server URL template substitution.
 * @typedef ServerVariable
 * @type {Object}
 * @property {Array<String>} enum
 * @property {String} default
 * @property {String} description
 */

/**
 * An object representing a Server.
 * @typedef Server
 * @type {Object}
 * @property {String} url
 * @property {String} description
 * @property {('kafka'|'kafka-secure'|'amqp'|'amqps'|'mqtt'|'mqtts'|'secure-mqtt'|'ws'|'wss'|'stomp'|'stomps'|'jms'|'http'|'https')} scheme - The transfer protocol.
 * @property {String} schemeVersion
 * @property {Object.<String,ServerVariable|Object|Array>} variables
 */

/**
 * @typedef Xml
 * @type {Object}
 * @property {String} name
 * @property {String} namespace
 * @property {String} prefix
 * @property {Boolean} attribute
 * @property {Boolean} wrapped
 */

/**
 * information about external documentation
 * @typedef ExternalDocs
 * @type {Object}
 * @property {String} description
 * @property {String} url
 */

/**
 * A deterministic version of a JSON Schema object.
 * @typedef Schema
 * @type {Object}
 * @property {String} $ref
 * @property {String} format
 * @property {String} title
 * @property {String} description
 * @property {*} default
 * @property {Number} multipleOf
 * @property {Number} maximum
 * @property {Boolean} exclusiveMaximum
 * @property {Number} minimum
 * @property {Boolean} exclusiveMinimum
 * @property {Number} maxLength
 * @property {Number} minLength
 * @property {String} pattern
 * @property {Number} maxItems
 * @property {Number} minItems
 * @property {Boolean} uniqueItems
 * @property {Number} maxProperties
 * @property {Number} minProperties
 * @property {Array<String>} required
 * @property {Array} enum
 * @property {Schema|Object|Array|Boolean} additionalProperties
 * @property {('array'|'boolean'|'integer'|'null'|'number'|'object'|'string')|Array<('array'|'boolean'|'integer'|'null'|'number'|'object'|'string')>} type
 * @property {Schema|Object|Array|Array<Schema|Object|Array>} items
 * @property {Array<Schema|Object|Array>} allOf
 * @property {Array<Schema|Object|Array>} oneOf
 * @property {Array<Schema|Object|Array>} anyOf
 * @property {Schema|Object|Array} not - A deterministic version of a JSON Schema object.
 * @property {Object.<String,Schema|Object|Array>} properties
 * @property {String} discriminator
 * @property {Boolean} readOnly
 * @property {Xml} xml
 * @property {ExternalDocs|Object|Array} externalDocs - information about external documentation.
 * @property {*} example
 */

/**
 * @typedef Parameter
 * @type {Object}
 * @property {String} description - A brief description of the parameter. This could contain examples of use.  GitHub Flavored Markdown is allowed.
 * @property {String} name - The name of the parameter.
 * @property {Schema|Object|Array} schema - A deterministic version of a JSON Schema object.
 * @property {String} $ref
 */

/**
 * @typedef Tag
 * @type {Object}
 * @property {String} name
 * @property {String} description
 * @property {ExternalDocs|Object|Array} externalDocs - information about external documentation.
 */

/**
 * @typedef Message
 * @type {Object}
 * @property {String} $ref
 * @property {Schema|Object|Array} headers - A deterministic version of a JSON Schema object.
 * @property {Schema|Object|Array} payload - A deterministic version of a JSON Schema object.
 * @property {Array<Tag|Object|Array>} tags
 * @property {String} summary - A brief summary of the message.
 * @property {String} description - A longer description of the message. CommonMark is allowed.
 * @property {ExternalDocs|Object|Array} externalDocs - information about external documentation.
 * @property {Boolean} deprecated
 * @property {*} example
 */

/**
 * @typedef OperationOneOf1
 * @type {Object}
 * @property {Array<Message|Object|Array>} oneOf
 */

/**
 * @typedef TopicItem
 * @type {Object}
 * @property {String} $ref
 * @property {Array<Parameter|Object|Array>} parameters
 * @property {Message|Object|Array|OperationOneOf1|Object|Array} publish
 * @property {Message|Object|Array|OperationOneOf1|Object|Array} subscribe
 * @property {Boolean} deprecated
 */

/**
 * @typedef StreamFramingOneOf0
 * @type {Object}
 * @property {('chunked')} type
 * @property {('\\r\\n'|'\\n')} delimiter
 */

/**
 * @typedef StreamFramingOneOf1
 * @type {Object}
 * @property {('sse')} type
 * @property {('\\n\\n')} delimiter
 */

/**
 * Stream Object
 * @typedef Stream
 * @type {Object}
 * @property {StreamFramingOneOf0|StreamFramingOneOf1|Object|Array} framing - Stream Framing Object.
 * @property {Array<Message|Object|Array>} read - Stream Read Object.
 * @property {Array<Message|Object|Array>} write - Stream Write Object.
 */

/**
 * Events Object
 * @typedef Events
 * @type {Object}
 * @property {Array<Message|Object|Array>} receive - Events Receive Object.
 * @property {Array<Message|Object|Array>} send - Events Send Object.
 */

/**
 * @typedef Reference
 * @type {Object}
 * @property {String} $ref
 */

/**
 * @typedef UserPassword
 * @type {Object}
 * @property {('userPassword')} type
 * @property {String} description
 */

/**
 * @typedef ApiKey
 * @type {Object}
 * @property {('apiKey')} type
 * @property {('user'|'password')} in
 * @property {String} description
 */

/**
 * @typedef X509
 * @type {Object}
 * @property {('X509')} type
 * @property {String} description
 */

/**
 * @typedef SymmetricEncryption
 * @type {Object}
 * @property {('symmetricEncryption')} type
 * @property {String} description
 */

/**
 * @typedef AsymmetricEncryption
 * @type {Object}
 * @property {('asymmetricEncryption')} type
 * @property {String} description
 */

/**
 * @typedef NonBearerHTTPSecurityScheme
 * @type {Object}
 * @property {String} scheme
 * @property {String} description
 * @property {('http')} type
 */

/**
 * @typedef BearerHTTPSecurityScheme
 * @type {Object}
 * @property {('bearer')} scheme
 * @property {String} bearerFormat
 * @property {('http')} type
 * @property {String} description
 */

/**
 * @typedef APIKeyHTTPSecurityScheme
 * @type {Object}
 * @property {('httpApiKey')} type
 * @property {String} name
 * @property {('header'|'query'|'cookie')} in
 * @property {String} description
 */

/**
 * An object to hold a set of reusable objects for different aspects of the AsyncAPI Specification.
 * @typedef Components
 * @type {Object}
 * @property {Object.<String,Schema|Object|Array>} schemas - JSON objects describing schemas the API uses.
 * @property {Object.<String,Message|Object|Array>} messages - JSON objects describing the messages being consumed and produced by the API.
 * @property {Reference|UserPassword|ApiKey|X509|SymmetricEncryption|AsymmetricEncryption|NonBearerHTTPSecurityScheme|BearerHTTPSecurityScheme|APIKeyHTTPSecurityScheme} securitySchemes
 * @property {Object.<String,Parameter|Object|Array>} parameters - JSON objects describing re-usable topic parameters.
 */

/**
 * AsyncAPI 1.2.0 schema.
 * @typedef Propertyb14a7b
 * @type {Object}
 * @property {('1.0.0'|'1.1.0'|'1.2.0')} asyncapi - The AsyncAPI specification version of this document.
 * @property {Info|Object|Array} info - General information about the API.
 * @property {String} baseTopic - The base topic to the API. Example: 'hitch'.
 * @property {Array<Server|Object|Array>} servers
 * @property {Object|Array|TopicItem|Object|Array} topics - Relative paths to the individual topics. They must be relative to the 'baseTopic'.
 * @property {Stream|Object|Array} stream - Stream Object.
 * @property {Events|Object|Array} events - Events Object.
 * @property {Components} components - An object to hold a set of reusable objects for different aspects of the AsyncAPI Specification.
 * @property {Array<Tag|Object|Array>} tags
 * @property {Array<Object.<String,Array<String>>>} security
 * @property {ExternalDocs|Object|Array} externalDocs - information about external documentation.
 */

