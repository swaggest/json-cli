# Types

  * [`APIKeyHTTPSecurityScheme`](#apikeyhttpsecurityscheme)
  * [`ApiKey`](#apikey)
  * [`AsymmetricEncryption`](#asymmetricencryption)
  * [`AsyncAPI120Schema`](#asyncapi120schema)
  * [`BaseTopic`](#basetopic)
  * [`BearerHTTPSecurityScheme`](#bearerhttpsecurityscheme)
  * [`Components`](#components)
  * [`Contact`](#contact)
  * [`EventsReceive`](#eventsreceive)
  * [`EventsSend`](#eventssend)
  * [`Events`](#events)
  * [`ExternalDocs`](#externaldocs)
  * [`Info`](#info)
  * [`License`](#license)
  * [`MessageTags`](#messagetags)
  * [`Message`](#message)
  * [`NonBearerHTTPSecurityScheme`](#nonbearerhttpsecurityscheme)
  * [`OperationOneOf1OneOf`](#operationoneof1oneof)
  * [`OperationOneOf1`](#operationoneof1)
  * [`Parameter`](#parameter)
  * [`PositiveInteger`](#positiveinteger)
  * [`PropertiesEnum`](#propertiesenum)
  * [`PropertiesMultipleOf`](#propertiesmultipleof)
  * [`PropertiesTypeAnyOf1`](#propertiestypeanyof1)
  * [`Reference`](#reference)
  * [`SchemaAllOf`](#schemaallof)
  * [`SchemaAnyOf`](#schemaanyof)
  * [`SchemaItemsAnyOf1`](#schemaitemsanyof1)
  * [`SchemaOneOf`](#schemaoneof)
  * [`Schema`](#schema)
  * [`ServerVariableEnum`](#servervariableenum)
  * [`ServerVariable`](#servervariable)
  * [`Server`](#server)
  * [`Servers`](#servers)
  * [`StreamFramingOneOf0`](#streamframingoneof0)
  * [`StreamFramingOneOf1`](#streamframingoneof1)
  * [`StreamFraming`](#streamframing)
  * [`StreamRead`](#streamread)
  * [`StreamWrite`](#streamwrite)
  * [`Stream`](#stream)
  * [`StringArray`](#stringarray)
  * [`SymmetricEncryption`](#symmetricencryption)
  * [`Tag`](#tag)
  * [`Tags`](#tags)
  * [`TopicItemParameters`](#topicitemparameters)
  * [`TopicItem`](#topicitem)
  * [`UserPassword`](#userpassword)
  * [`X509`](#x509)
  * [`Xml`](#xml)




### <a id="apikeyhttpsecurityscheme"></a>APIKeyHTTPSecurityScheme



|Property         |Type                                     |
|-----------------|-----------------------------------------|
|`type` (required)|`'httpApiKey'`                           |
|`name` (required)|`String`                                 |
|`in` (required)  |`'header'`, <br>`'query'`, <br>`'cookie'`|
|`description`    |`String`                                 |


### <a id="apikey"></a>ApiKey



|Property         |Type                      |
|-----------------|--------------------------|
|`type` (required)|`'apiKey'`                |
|`in` (required)  |`'user'`, <br>`'password'`|
|`description`    |`String`                  |


### <a id="asymmetricencryption"></a>AsymmetricEncryption



|Property         |Type                    |
|-----------------|------------------------|
|`type` (required)|`'asymmetricEncryption'`|
|`description`    |`String`                |


### <a id="asyncapi120schema"></a>AsyncAPI120Schema
AsyncAPI 1.2.0 schema.



|Property             |Type                                                                  |Description                                                                                     |
|---------------------|----------------------------------------------------------------------|------------------------------------------------------------------------------------------------|
|`asyncapi` (required)|`'1.0.0'`, <br>`'1.1.0'`, <br>`'1.2.0'`                               |The AsyncAPI specification version of this document.                                            |
|`info` (required)    |[`Info`](#info), `Object`, `Array`                                    |General information about the API.                                                              |
|`baseTopic`          |[`BaseTopic`](#basetopic), `String`                                   |The base topic to the API. Example: 'hitch'.                                                    |
|`servers`            |[`Servers`](#servers), `Array<`[`Server`](#server), `Object`, `Array>`|                                                                                                |
|`topics`             |`Object`, `Array`, [`TopicItem`](#topicitem), `Object`, `Array`       |Relative paths to the individual topics. They must be relative to the 'baseTopic'.              |
|`stream`             |[`Stream`](#stream), `Object`, `Array`                                |Stream Object.                                                                                  |
|`events`             |`*`, `*`, [`Events`](#events), `Object`, `Array`                      |Events Object.                                                                                  |
|`components`         |[`Components`](#components)                                           |An object to hold a set of reusable objects for different aspects of the AsyncAPI Specification.|
|`tags`               |[`Tags`](#tags), `Array<`[`Tag`](#tag), `Object`, `Array>`            |                                                                                                |
|`security`           |`Array<Map<String,Array<String>>>`                                    |                                                                                                |
|`externalDocs`       |[`ExternalDocs`](#externaldocs), `Object`, `Array`                    |information about external documentation.                                                       |


### <a id="basetopic"></a>BaseTopic
The base topic to the API. Example: 'hitch'.

|Constraint|Value |
|----------|------|
|pattern   |^[^/.]|




### <a id="bearerhttpsecurityscheme"></a>BearerHTTPSecurityScheme



|Property           |Type      |
|-------------------|----------|
|`scheme` (required)|`'bearer'`|
|`bearerFormat`     |`String`  |
|`type` (required)  |`'http'`  |
|`description`      |`String`  |


### <a id="components"></a>Components
An object to hold a set of reusable objects for different aspects of the AsyncAPI Specification.



|Property         |Type                                                                                                                                                                                                                                                                                                                                                                                                                     |Description                                                                 |
|-----------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------|
|`schemas`        |`Map<String,`[`Schema`](#schema), `Object`, `Array>`                                                                                                                                                                                                                                                                                                                                                                     |JSON objects describing schemas the API uses.                               |
|`messages`       |`Map<String,`[`Message`](#message), `Object`, `Array>`                                                                                                                                                                                                                                                                                                                                                                   |JSON objects describing the messages being consumed and produced by the API.|
|`securitySchemes`|[`Reference`](#reference), [`UserPassword`](#userpassword), `*`, [`ApiKey`](#apikey), `*`, [`X509`](#x509), `*`, [`SymmetricEncryption`](#symmetricencryption), `*`, [`AsymmetricEncryption`](#asymmetricencryption), `*`, [`NonBearerHTTPSecurityScheme`](#nonbearerhttpsecurityscheme), `*`, [`BearerHTTPSecurityScheme`](#bearerhttpsecurityscheme), `*`, [`APIKeyHTTPSecurityScheme`](#apikeyhttpsecurityscheme), `*`|                                                                            |
|`parameters`     |`Map<String,`[`Parameter`](#parameter), `Object`, `Array>`                                                                                                                                                                                                                                                                                                                                                               |JSON objects describing re-usable topic parameters.                         |


### <a id="contact"></a>Contact
Contact information for the owners of the API.



|Property|Type                     |Description                                             |
|--------|-------------------------|--------------------------------------------------------|
|`name`  |`String`                 |The identifying name of the contact person/organization.|
|`url`   |`String`, Format: `uri`  |The URL pointing to the contact information.            |
|`email` |`String`, Format: `email`|The email address of the contact person/organization.   |


### <a id="eventsreceive"></a>EventsReceive
Events Receive Object

|Constraint |Value|
|-----------|-----|
|minItems   |1    |
|uniqueItems|1    |




### <a id="eventssend"></a>EventsSend
Events Send Object

|Constraint |Value|
|-----------|-----|
|minItems   |1    |
|uniqueItems|1    |




### <a id="events"></a>Events
Events Object

|Constraint   |Value|
|-------------|-----|
|minProperties|1    |


|Property |Type                                                                                |Description           |
|---------|------------------------------------------------------------------------------------|----------------------|
|`receive`|[`EventsReceive`](#eventsreceive), `Array<`[`Message`](#message), `Object`, `Array>`|Events Receive Object.|
|`send`   |[`EventsSend`](#eventssend), `Array<`[`Message`](#message), `Object`, `Array>`      |Events Send Object.   |


### <a id="externaldocs"></a>ExternalDocs
information about external documentation



|Property        |Type                   |
|----------------|-----------------------|
|`description`   |`String`               |
|`url` (required)|`String`, Format: `uri`|


### <a id="info"></a>Info
General information about the API.



|Property            |Type                                    |Description                                                                                |
|--------------------|----------------------------------------|-------------------------------------------------------------------------------------------|
|`title` (required)  |`String`                                |A unique and precise title of the API.                                                     |
|`version` (required)|`String`                                |A semantic version number of the API.                                                      |
|`description`       |`String`                                |A longer description of the API. Should be different from the title. CommonMark is allowed.|
|`termsOfService`    |`String`, Format: `uri`                 |A URL to the Terms of Service for the API. MUST be in the format of a URL.                 |
|`contact`           |[`Contact`](#contact), `Object`, `Array`|Contact information for the owners of the API.                                             |
|`license`           |[`License`](#license), `Object`, `Array`|                                                                                           |


### <a id="license"></a>License



|Property         |Type                   |Description                                                                    |
|-----------------|-----------------------|-------------------------------------------------------------------------------|
|`name` (required)|`String`               |The name of the license type. It's encouraged to use an OSI compatible license.|
|`url`            |`String`, Format: `uri`|The URL pointing to the license.                                               |


### <a id="messagetags"></a>MessageTags

|Constraint |Value|
|-----------|-----|
|uniqueItems|1    |




### <a id="message"></a>Message



|Property      |Type                                                                    |Description                                                |
|--------------|------------------------------------------------------------------------|-----------------------------------------------------------|
|`$ref`        |`String`                                                                |                                                           |
|`headers`     |[`Schema`](#schema), `Object`, `Array`                                  |A deterministic version of a JSON Schema object.           |
|`payload`     |[`Schema`](#schema), `Object`, `Array`                                  |A deterministic version of a JSON Schema object.           |
|`tags`        |[`MessageTags`](#messagetags), `Array<`[`Tag`](#tag), `Object`, `Array>`|                                                           |
|`summary`     |`String`                                                                |A brief summary of the message.                            |
|`description` |`String`                                                                |A longer description of the message. CommonMark is allowed.|
|`externalDocs`|[`ExternalDocs`](#externaldocs), `Object`, `Array`                      |information about external documentation.                  |
|`deprecated`  |`Boolean`                                                               |                                                           |
|`example`     |`*`                                                                     |                                                           |


### <a id="nonbearerhttpsecurityscheme"></a>NonBearerHTTPSecurityScheme



|Property           |Type    |
|-------------------|--------|
|`scheme` (required)|`String`|
|`description`      |`String`|
|`type` (required)  |`'http'`|


### <a id="operationoneof1oneof"></a>OperationOneOf1OneOf

|Constraint|Value|
|----------|-----|
|minItems  |2    |




### <a id="operationoneof1"></a>OperationOneOf1



|Property          |Type                                                                                              |
|------------------|--------------------------------------------------------------------------------------------------|
|`oneOf` (required)|[`OperationOneOf1OneOf`](#operationoneof1oneof), `Array<`[`Message`](#message), `Object`, `Array>`|


### <a id="parameter"></a>Parameter



|Property     |Type                                  |Description                                                                                                    |
|-------------|--------------------------------------|---------------------------------------------------------------------------------------------------------------|
|`description`|`String`                              |A brief description of the parameter. This could contain examples of use.  GitHub Flavored Markdown is allowed.|
|`name`       |`String`                              |The name of the parameter.                                                                                     |
|`schema`     |[`Schema`](#schema), `Object`, `Array`|A deterministic version of a JSON Schema object.                                                               |
|`$ref`       |`String`                              |                                                                                                               |


### <a id="positiveinteger"></a>PositiveInteger

|Constraint|Value|
|----------|-----|
|minimum   |0    |




### <a id="propertiesenum"></a>PropertiesEnum

|Constraint |Value|
|-----------|-----|
|minItems   |1    |
|uniqueItems|1    |




### <a id="propertiesmultipleof"></a>PropertiesMultipleOf

|Constraint      |Value|
|----------------|-----|
|minimum         |0    |
|exclusiveMinimum|1    |




### <a id="propertiestypeanyof1"></a>PropertiesTypeAnyOf1

|Constraint |Value|
|-----------|-----|
|minItems   |1    |
|uniqueItems|1    |




### <a id="reference"></a>Reference



|Property         |Type                   |
|-----------------|-----------------------|
|`$ref` (required)|`String`, Format: `uri`|


### <a id="schemaallof"></a>SchemaAllOf

|Constraint|Value|
|----------|-----|
|minItems  |1    |




### <a id="schemaanyof"></a>SchemaAnyOf

|Constraint|Value|
|----------|-----|
|minItems  |2    |




### <a id="schemaitemsanyof1"></a>SchemaItemsAnyOf1

|Constraint|Value|
|----------|-----|
|minItems  |1    |




### <a id="schemaoneof"></a>SchemaOneOf

|Constraint|Value|
|----------|-----|
|minItems  |2    |




### <a id="schema"></a>Schema
A deterministic version of a JSON Schema object.



|Property              |Type                                                                                                                                                                                                                                                                        |Description                                     |
|----------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------|
|`$ref`                |`String`                                                                                                                                                                                                                                                                    |                                                |
|`format`              |`String`                                                                                                                                                                                                                                                                    |                                                |
|`title`               |`String`                                                                                                                                                                                                                                                                    |                                                |
|`description`         |`String`                                                                                                                                                                                                                                                                    |                                                |
|`default`             |`*`                                                                                                                                                                                                                                                                         |                                                |
|`multipleOf`          |[`PropertiesMultipleOf`](#propertiesmultipleof), `Number`                                                                                                                                                                                                                   |                                                |
|`maximum`             |`Number`                                                                                                                                                                                                                                                                    |                                                |
|`exclusiveMaximum`    |`Boolean`                                                                                                                                                                                                                                                                   |                                                |
|`minimum`             |`Number`                                                                                                                                                                                                                                                                    |                                                |
|`exclusiveMinimum`    |`Boolean`                                                                                                                                                                                                                                                                   |                                                |
|`maxLength`           |[`PositiveInteger`](#positiveinteger), `Number`                                                                                                                                                                                                                             |                                                |
|`minLength`           |[`PositiveInteger`](#positiveinteger), `Number`, `*`                                                                                                                                                                                                                        |                                                |
|`pattern`             |`String`, Format: `regex`                                                                                                                                                                                                                                                   |                                                |
|`maxItems`            |[`PositiveInteger`](#positiveinteger), `Number`                                                                                                                                                                                                                             |                                                |
|`minItems`            |[`PositiveInteger`](#positiveinteger), `Number`, `*`                                                                                                                                                                                                                        |                                                |
|`uniqueItems`         |`Boolean`                                                                                                                                                                                                                                                                   |                                                |
|`maxProperties`       |[`PositiveInteger`](#positiveinteger), `Number`                                                                                                                                                                                                                             |                                                |
|`minProperties`       |[`PositiveInteger`](#positiveinteger), `Number`, `*`                                                                                                                                                                                                                        |                                                |
|`required`            |[`StringArray`](#stringarray), `Array<String>`                                                                                                                                                                                                                              |                                                |
|`enum`                |[`PropertiesEnum`](#propertiesenum), `Array`                                                                                                                                                                                                                                |                                                |
|`additionalProperties`|[`Schema`](#schema), `Object`, `Array`, `Boolean`                                                                                                                                                                                                                           |                                                |
|`type`                |`'array'`, <br>`'boolean'`, <br>`'integer'`, <br>`'null'`, <br>`'number'`, <br>`'object'`, <br>`'string'`, [`PropertiesTypeAnyOf1`](#propertiestypeanyof1), `Array<'array'`, <br>`'boolean'`, <br>`'integer'`, <br>`'null'`, <br>`'number'`, <br>`'object'`, <br>`'string'>`|                                                |
|`items`               |[`Schema`](#schema), `Object`, `Array`, [`SchemaItemsAnyOf1`](#schemaitemsanyof1), `Array<`[`Schema`](#schema), `Object`, `Array>`                                                                                                                                          |                                                |
|`allOf`               |[`SchemaAllOf`](#schemaallof), `Array<`[`Schema`](#schema), `Object`, `Array>`                                                                                                                                                                                              |                                                |
|`oneOf`               |[`SchemaOneOf`](#schemaoneof), `Array<`[`Schema`](#schema), `Object`, `Array>`                                                                                                                                                                                              |                                                |
|`anyOf`               |[`SchemaAnyOf`](#schemaanyof), `Array<`[`Schema`](#schema), `Object`, `Array>`                                                                                                                                                                                              |                                                |
|`not`                 |[`Schema`](#schema), `Object`, `Array`                                                                                                                                                                                                                                      |A deterministic version of a JSON Schema object.|
|`properties`          |`Map<String,`[`Schema`](#schema), `Object`, `Array>`                                                                                                                                                                                                                        |                                                |
|`discriminator`       |`String`                                                                                                                                                                                                                                                                    |                                                |
|`readOnly`            |`Boolean`                                                                                                                                                                                                                                                                   |                                                |
|`xml`                 |[`Xml`](#xml)                                                                                                                                                                                                                                                               |                                                |
|`externalDocs`        |[`ExternalDocs`](#externaldocs), `Object`, `Array`                                                                                                                                                                                                                          |information about external documentation.       |
|`example`             |`*`                                                                                                                                                                                                                                                                         |                                                |


### <a id="servervariableenum"></a>ServerVariableEnum

|Constraint |Value|
|-----------|-----|
|uniqueItems|1    |




### <a id="servervariable"></a>ServerVariable
An object representing a Server Variable for server URL template substitution.

|Constraint   |Value|
|-------------|-----|
|minProperties|1    |


|Property     |Type                                                        |
|-------------|------------------------------------------------------------|
|`enum`       |[`ServerVariableEnum`](#servervariableenum), `Array<String>`|
|`default`    |`String`                                                    |
|`description`|`String`                                                    |


### <a id="server"></a>Server
An object representing a Server.



|Property           |Type                                                                                                                                                                                                            |Description           |
|-------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------|
|`url` (required)   |`String`                                                                                                                                                                                                        |                      |
|`description`      |`String`                                                                                                                                                                                                        |                      |
|`scheme` (required)|`'kafka'`, <br>`'kafka-secure'`, <br>`'amqp'`, <br>`'amqps'`, <br>`'mqtt'`, <br>`'mqtts'`, <br>`'secure-mqtt'`, <br>`'ws'`, <br>`'wss'`, <br>`'stomp'`, <br>`'stomps'`, <br>`'jms'`, <br>`'http'`, <br>`'https'`|The transfer protocol.|
|`schemeVersion`    |`String`                                                                                                                                                                                                        |                      |
|`variables`        |`Map<String,`[`ServerVariable`](#servervariable), `Object`, `Array>`                                                                                                                                            |                      |


### <a id="servers"></a>Servers

|Constraint |Value|
|-----------|-----|
|uniqueItems|1    |




### <a id="streamframingoneof0"></a>StreamFramingOneOf0



|Property   |Type                   |
|-----------|-----------------------|
|`type`     |`'chunked'`            |
|`delimiter`|`'\\r\\n'`, <br>`'\\n'`|


### <a id="streamframingoneof1"></a>StreamFramingOneOf1



|Property   |Type      |
|-----------|----------|
|`type`     |`'sse'`   |
|`delimiter`|`'\\n\\n'`|


### <a id="streamframing"></a>StreamFraming
Stream Framing Object

|Constraint   |Value|
|-------------|-----|
|minProperties|1    |




### <a id="streamread"></a>StreamRead
Stream Read Object

|Constraint |Value|
|-----------|-----|
|minItems   |1    |
|uniqueItems|1    |




### <a id="streamwrite"></a>StreamWrite
Stream Write Object

|Constraint |Value|
|-----------|-----|
|minItems   |1    |
|uniqueItems|1    |




### <a id="stream"></a>Stream
Stream Object

|Constraint   |Value|
|-------------|-----|
|minProperties|1    |


|Property |Type                                                                                                                                              |Description           |
|---------|--------------------------------------------------------------------------------------------------------------------------------------------------|----------------------|
|`framing`|[`StreamFramingOneOf0`](#streamframingoneof0), [`StreamFramingOneOf1`](#streamframingoneof1), [`StreamFraming`](#streamframing), `Object`, `Array`|Stream Framing Object.|
|`read`   |[`StreamRead`](#streamread), `Array<`[`Message`](#message), `Object`, `Array>`                                                                    |Stream Read Object.   |
|`write`  |[`StreamWrite`](#streamwrite), `Array<`[`Message`](#message), `Object`, `Array>`                                                                  |Stream Write Object.  |


### <a id="stringarray"></a>StringArray

|Constraint |Value|
|-----------|-----|
|minItems   |1    |
|uniqueItems|1    |




### <a id="symmetricencryption"></a>SymmetricEncryption



|Property         |Type                   |
|-----------------|-----------------------|
|`type` (required)|`'symmetricEncryption'`|
|`description`    |`String`               |


### <a id="tag"></a>Tag



|Property         |Type                                              |Description                              |
|-----------------|--------------------------------------------------|-----------------------------------------|
|`name` (required)|`String`                                          |                                         |
|`description`    |`String`                                          |                                         |
|`externalDocs`   |[`ExternalDocs`](#externaldocs), `Object`, `Array`|information about external documentation.|


### <a id="tags"></a>Tags

|Constraint |Value|
|-----------|-----|
|uniqueItems|1    |




### <a id="topicitemparameters"></a>TopicItemParameters

|Constraint |Value|
|-----------|-----|
|minItems   |1    |
|uniqueItems|1    |




### <a id="topicitem"></a>TopicItem

|Constraint   |Value|
|-------------|-----|
|minProperties|1    |


|Property    |Type                                                                                                |
|------------|----------------------------------------------------------------------------------------------------|
|`$ref`      |`String`                                                                                            |
|`parameters`|[`TopicItemParameters`](#topicitemparameters), `Array<`[`Parameter`](#parameter), `Object`, `Array>`|
|`publish`   |[`Message`](#message), `Object`, `Array`, [`OperationOneOf1`](#operationoneof1), `Object`, `Array`  |
|`subscribe` |[`Message`](#message), `Object`, `Array`, [`OperationOneOf1`](#operationoneof1), `Object`, `Array`  |
|`deprecated`|`Boolean`                                                                                           |


### <a id="userpassword"></a>UserPassword



|Property         |Type            |
|-----------------|----------------|
|`type` (required)|`'userPassword'`|
|`description`    |`String`        |


### <a id="x509"></a>X509



|Property         |Type    |
|-----------------|--------|
|`type` (required)|`'X509'`|
|`description`    |`String`|


### <a id="xml"></a>Xml



|Property   |Type     |
|-----------|---------|
|`name`     |`String` |
|`namespace`|`String` |
|`prefix`   |`String` |
|`attribute`|`Boolean`|
|`wrapped`  |`Boolean`|
