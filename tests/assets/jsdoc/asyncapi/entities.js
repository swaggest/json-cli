/**
 * Contact information for the owners of the API.
 * @typedef Contact
 * @type {object}
 * @property {string} name - The identifying name of the contact person/organization.
 * @property {string} url - The URL pointing to the contact information.
 * @property {string} email - The email address of the contact person/organization.
 */

/**
 * @typedef License
 * @type {object}
 * @property {string} name - The name of the license type. It's encouraged to use an OSI compatible license.
 * @property {string} url - The URL pointing to the license.
 */

/**
 * General information about the API.
 * @typedef Info
 * @type {object}
 * @property {string} title - A unique and precise title of the API.
 * @property {string} version - A semantic version number of the API.
 * @property {string} description - A longer description of the API. Should be different from the title. CommonMark is allowed.
 * @property {string} termsOfService - A URL to the Terms of Service for the API. MUST be in the format of a URL.
 * @property {Contact} contact - Contact information for the owners of the API.
 * @property {License} license.
 */

/**
 * An object representing a Server Variable for server URL template substitution.
 * @typedef ServerVariable
 * @type {object}
 * @property {array<string>} enum.
 * @property {string} default.
 * @property {string} description.
 */

/**
 * An object representing a Server.
 * @typedef Server
 * @type {object}
 * @property {string} url.
 * @property {string} description.
 * @property {string} scheme - The transfer protocol.
 * @property {string} schemeVersion.
 * @property {object<string, ServerVariable>} variables.
 */

/**
 * @typedef Xml
 * @type {object}
 * @property {string} name.
 * @property {string} namespace.
 * @property {string} prefix.
 * @property {boolean} attribute.
 * @property {boolean} wrapped.
 */

/**
 * information about external documentation
 * @typedef ExternalDocs
 * @type {object}
 * @property {string} description.
 * @property {string} url.
 */

/**
 * A deterministic version of a JSON Schema object.
 * @typedef Schema
 * @type {object}
 * @property {string} $ref.
 * @property {string} format.
 * @property {string} title.
 * @property {string} description.
 * @property {*} default.
 * @property {number} multipleOf.
 * @property {number} maximum.
 * @property {boolean} exclusiveMaximum.
 * @property {number} minimum.
 * @property {boolean} exclusiveMinimum.
 * @property {number} maxLength.
 * @property {number} minLength.
 * @property {string} pattern.
 * @property {number} maxItems.
 * @property {number} minItems.
 * @property {boolean} uniqueItems.
 * @property {number} maxProperties.
 * @property {number} minProperties.
 * @property {array<string>} required.
 * @property {array} enum.
 * @property {Schema|boolean} additionalProperties.
 * @property {array<*>} type.
 * @property {Schema|array<Schema>} items.
 * @property {array<Schema>} allOf.
 * @property {array<Schema>} oneOf.
 * @property {array<Schema>} anyOf.
 * @property {Schema} not - A deterministic version of a JSON Schema object.
 * @property {object<string, Schema>} properties.
 * @property {string} discriminator.
 * @property {boolean} readOnly.
 * @property {Xml} xml.
 * @property {ExternalDocs} externalDocs - information about external documentation.
 * @property {*} example.
 */

/**
 * @typedef Tag
 * @type {object}
 * @property {string} name.
 * @property {string} description.
 * @property {ExternalDocs} externalDocs - information about external documentation.
 */

/**
 * @typedef Message
 * @type {object}
 * @property {string} $ref.
 * @property {Schema} headers - A deterministic version of a JSON Schema object.
 * @property {Schema} payload - A deterministic version of a JSON Schema object.
 * @property {array<Tag>} tags.
 * @property {string} summary - A brief summary of the message.
 * @property {string} description - A longer description of the message. CommonMark is allowed.
 * @property {ExternalDocs} externalDocs - information about external documentation.
 * @property {boolean} deprecated.
 * @property {*} example.
 */

/**
 * @typedef Propertyd41d8c
 * @type {object}
 * @property {array<Message>} oneOf.
 */

/**
 * @typedef TopicItem
 * @type {object}
 * @property {string} $ref.
 * @property {array<*>} parameters.
 * @property {Message|Propertyd41d8c} publish.
 * @property {Message|Propertyd41d8c} subscribe.
 * @property {boolean} deprecated.
 */

/**
 * Stream Object
 * @typedef Stream
 * @type {object}
 * @property {*} framing - Stream Framing Object.
 * @property {array<Message>} read - Stream Read Object.
 * @property {array<Message>} write - Stream Write Object.
 */

/**
 * Events Object
 * @typedef Events
 * @type {object}
 * @property {array<Message>} receive - Events Receive Object.
 * @property {array<Message>} send - Events Send Object.
 */

/**
 * @typedef Reference
 * @type {object}
 * @property {string} $ref.
 */

/**
 * @typedef UserPassword
 * @type {object}
 * @property {string} type.
 * @property {string} description.
 */

/**
 * @typedef ApiKey
 * @type {object}
 * @property {string} type.
 * @property {string} in.
 * @property {string} description.
 */

/**
 * @typedef X509
 * @type {object}
 * @property {string} type.
 * @property {string} description.
 */

/**
 * @typedef SymmetricEncryption
 * @type {object}
 * @property {string} type.
 * @property {string} description.
 */

/**
 * @typedef AsymmetricEncryption
 * @type {object}
 * @property {string} type.
 * @property {string} description.
 */

/**
 * @typedef NonBearerHTTPSecurityScheme
 * @type {object}
 * @property {string} scheme.
 * @property {string} description.
 * @property {string} type.
 */

/**
 * @typedef BearerHTTPSecurityScheme
 * @type {object}
 * @property {string} scheme.
 * @property {string} bearerFormat.
 * @property {string} type.
 * @property {string} description.
 */

/**
 * @typedef APIKeyHTTPSecurityScheme
 * @type {object}
 * @property {string} type.
 * @property {string} name.
 * @property {string} in.
 * @property {string} description.
 */

/**
 * An object to hold a set of reusable objects for different aspects of the AsyncAPI Specification.
 * @typedef Components
 * @type {object}
 * @property {object<string, Schema>} schemas - JSON objects describing schemas the API uses.
 * @property {object<string, Message>} messages - JSON objects describing the messages being consumed and produced by the API.
 * @property {Reference|UserPassword|ApiKey|X509|SymmetricEncryption|AsymmetricEncryption|NonBearerHTTPSecurityScheme|BearerHTTPSecurityScheme|APIKeyHTTPSecurityScheme} securitySchemes.
 * @property {object<string, *>} parameters - JSON objects describing re-usable topic parameters.
 */

/**
 * AsyncAPI 1.2.0 schema.
 * @typedef Propertyd41d8c
 * @type {object}
 * @property {string} asyncapi - The AsyncAPI specification version of this document.
 * @property {Info} info - General information about the API.
 * @property {string} baseTopic - The base topic to the API. Example: 'hitch'.
 * @property {array<Server>} servers.
 * @property {TopicItem} topics - Relative paths to the individual topics. They must be relative to the 'baseTopic'.
 * @property {Stream} stream - Stream Object.
 * @property {Events} events - Events Object.
 * @property {Components} components - An object to hold a set of reusable objects for different aspects of the AsyncAPI Specification.
 * @property {array<Tag>} tags.
 * @property {array<object<string, array<string>>>} security.
 * @property {ExternalDocs} externalDocs - information about external documentation.
 */

