# JSON CLI multitool

<img align="right" width="100px" height="100px" alt="Swiss Knife" src="./knife.svg">

A CLI app to find unordered diff between two `JSON` documents (based
on [`swaggest/json-diff`](https://github.com/swaggest/json-diff)), generate JSON Schema and Go/PHP code, pretty print,
minify, yaml convert, etc....

[![Build Status](https://travis-ci.org/swaggest/json-cli.svg?branch=master)](https://travis-ci.org/swaggest/json-cli)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/swaggest/json-cli/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/swaggest/json-cli/?branch=master)
[![Code Climate](https://codeclimate.com/github/swaggest/json-cli/badges/gpa.svg)](https://codeclimate.com/github/swaggest/json-cli)
[![Code Coverage](https://scrutinizer-ci.com/g/swaggest/json-cli/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/swaggest/json-cli/code-structure/master/code-coverage)
[![Image Size](https://images.microbadger.com/badges/image/swaggest/json-cli.svg)](https://microbadger.com/images/swaggest/json-cli)
![Code lines](https://sloc.xyz/github/swaggest/json-cli/?category=code)
![Comments](https://sloc.xyz/github/swaggest/json-cli/?category=comments)

## Purpose

* To simplify changes review between two `JSON` files you can use a standard `diff` tool on rearranged
  pretty-printed `JSON`.
* To detect breaking changes by analyzing removals and changes from original `JSON`.
* To keep original order of object sets (for
  example `swagger.json` [parameters](https://swagger.io/docs/specification/describing-parameters/) list).
* To make and apply JSON Patches, specified in [RFC 6902](http://tools.ietf.org/html/rfc6902) from the IETF.
* To convert between YAML/JSON/PHP serialization.
* To resolve `JSON Pointer` to data.
* To resolve `JSON Pointer` to file position.
* To validate JSON data against [`JSON Schema`](http://json-schema.org/).
* To [generate or update](#buildschema) JSON Schema with instance value(s).
* To [generate](#genjson) sample JSON value from JSON Schema.
* To [render](#gengo) `JSON Schema` as [`Go`](http://golang.org/) structure.
* To [render](#genphp) `JSON Schema` as `PHP` classes.
* To [render](#genjsdoc) `JSON Schema` as `JSDoc` type definitions.

## Installation

### Docker

```
docker run swaggest/json-cli json-cli --help
v1.6.1 json-cli
JSON CLI tool, https://github.com/swaggest/json-cli
...
```

`json-cli` can load schema from stdin (using `-` as a file path) which can be handy with docker, for example:

```
cat ./tests/assets/swagger-schema.json | docker run -i --rm swaggest/json-cli json-cli gen-jsdoc -
```

### Composer

[Install PHP Composer](https://getcomposer.org/doc/00-intro.md)

```bash
composer require swaggest/json-cli
```

## CLI tool

### Usage

```
v1.9.0 json-cli
JSON CLI tool, https://github.com/swaggest/json-cli
Usage: 
   json-cli <action>
   action   Action name
            Allowed values: diff, apply, rearrange, diff-info, pretty-print, minify, replace, resolve,
            resolve-pos, validate-schema, gen-go, gen-php, gen-jsdoc, gen-json, build-schema
```

Input paths can be .json/.yaml/.yml/.serialized files, file format is detected by file extension:

* `.json` JSON
* `.yaml`, `.yml` YAML
* `.serialized` PHP serialization format

#### Diff, make `JSON Patch` from two documents

```
v1.3.0 json-cli diff
JSON CLI tool, https://github.com/swaggest/json-cli
Make patch from two json documents, output to STDOUT
Usage:
   json-cli diff <originalPath> <newPath>
   originalPath   Path to old (original) json file
   newPath        Path to new json file

Options:
   --rearrange-arrays    Rearrange arrays to match original
   --pretty              Pretty-print result JSON
   --output <output>     Path to output result, default STDOUT
   --to-yaml             Output in YAML format
   --pretty-short        Pretty short format
```

Example:

Making `JSON Patch`

```
json-cli diff tests/assets/original.json tests/assets/new.json --rearrange-arrays --pretty-short
[
    {"value":4,"op":"test","path":"/key1/0"},
    {"value":5,"op":"replace","path":"/key1/0"},
    {"op":"remove","path":"/key2"},
    {"op":"remove","path":"/key3/sub0"},
    {"value":"a","op":"test","path":"/key3/sub1"},
    {"value":"c","op":"replace","path":"/key3/sub1"},
    {"value":"b","op":"test","path":"/key3/sub2"},
    {"value":false,"op":"replace","path":"/key3/sub2"},
    {"value":0,"op":"add","path":"/key3/sub3"},
    {"op":"remove","path":"/key4/1/b"},
    {"value":false,"op":"add","path":"/key4/1/c"},
    {"value":1,"op":"add","path":"/key4/2/c"},
    {"value":"wat","op":"add","path":"/key5"}
]
```

#### Apply `JSON Patch` to document

```
v1.3.0 json-cli apply
JSON CLI tool, https://github.com/swaggest/json-cli
Apply patch to base json document, output to STDOUT
Usage:
   json-cli apply [patchPath] [basePath]
   patchPath   Path to JSON patch file
   basePath    Path to JSON base file

Options:
   --pretty             Pretty-print result JSON
   --output <output>    Path to output result, default STDOUT
   --to-yaml            Output in YAML format
   --tolerate-errors    Continue on error
```

#### Rearrange JSON document to keep original order

```
v1.3.0 json-cli rearrange
JSON CLI tool, https://github.com/swaggest/json-cli
Rearrange json document in the order of another (original) json document
Usage:
   json-cli rearrange <originalPath> <newPath>
   originalPath   Path to old (original) json file
   newPath        Path to new json file

Options:
   --rearrange-arrays    Rearrange arrays to match original
   --pretty              Pretty-print result JSON
   --output <output>     Path to output result, default STDOUT
   --to-yaml             Output in YAML format
```

Example:

Using with standard `diff`

```
json-cli rearrange tests/assets/original.json tests/assets/new.json --rearrange-arrays --pretty | diff <(json-cli pretty-print ./tests/assets/original.json) -
3c3
<         4,
---
>         5,
8d7
<     "key2": 2,
10,12c9,11
<         "sub0": 0,
<         "sub1": "a",
<         "sub2": "b"
---
>         "sub1": "c",
>         "sub2": false,
>         "sub3": 0
21c20
<             "b": false
---
>             "c": false
24c23,24
<             "a": 3
---
>             "a": 3,
>             "c": 1
26c26,27
<     ]
---
>     ],
>     "key5": "wat"
```

#### Show difference between two JSON documents

```
json-cli diff-info --help
v1.3.0 json-cli diff-info
JSON CLI tool, https://github.com/swaggest/json-cli
Show diff info for two JSON documents
Usage:
   json-cli diff-info <originalPath> <newPath>
   originalPath   Path to old (original) json file
   newPath        Path to new json file

Options:
   --rearrange-arrays    Rearrange arrays to match original
   --pretty              Pretty-print result JSON
   --output <output>     Path to output result, default STDOUT
   --to-yaml             Output in YAML format
   --with-contents       Add content to output
   --with-paths          Add paths to output
```

Example:

Showing differences in `JSON` mode

```
json-cli diff-info tests/assets/original.json tests/assets/new.json --with-paths --pretty
{
    "addedCnt": 4,
    "modifiedCnt": 4,
    "removedCnt": 3,
    "addedPaths": [
        "/key3/sub3",
        "/key4/0/c",
        "/key4/2/c",
        "/key5"
    ],
    "modifiedPaths": [
        "/key1/0",
        "/key3/sub1",
        "/key3/sub2",
        "/key4/0/a",
        "/key4/1/a",
        "/key4/1/b"
    ],
    "removedPaths": [
        "/key2",
        "/key3/sub0",
        "/key4/0/b"
    ]
}
```

#### Pretty-print JSON document or convert between formats

```
json-cli pretty-print --help
v1.4.2 json-cli pretty-print
JSON CLI tool, https://github.com/swaggest/json-cli
Pretty print JSON document
Usage: 
   json-cli pretty-print <path>
   path   Path to JSON/YAML file

Options: 
   --output <output>   Path to output result, default STDOUT
   --to-yaml           Output in YAML format
   --to-serialized     Output in PHP serialized format
```

#### Minify JSON document

```
json-cli minify --help
v1.7.5 json-cli minify
JSON CLI tool, https://github.com/swaggest/json-cli
Minify JSON document
Usage: 
   json-cli minify <path>
   path   Path to JSON/YAML file
   
Options: 
   --output <output>   Path to output result, default STDOUT
   --to-serialized     Output in PHP serialized format      
   --eol               Add line break to the output         
```

Bash command to minify all JSON files in current directory.

```
for f in *.json; do json-cli minify $f --output $f; done
```

#### Replace values in JSON document

```
json-cli replace --help
v1.3.0 json-cli replace
JSON CLI tool, https://github.com/swaggest/json-cli
Minify JSON document
Usage:
   json-cli replace <path> <search> <replace>
   path      Path to JSON/YAML file
   search    Search JSON value
   replace   Replace JSON value

Options:
   --path-filter <pathFilter>   JSON path filter regex, example "/definitions/.*/properties/deletedAt"
```

Example:

```
json-cli replace swagger.json '{"type": "string","format": "date-time"}' '{"type": "string","format": "date-time","x-nullable":true}' --path-filter '/definitions/.*/properties/deletedAt' --output swagger-fixed.json
```

#### Resolve `JSON Pointer` to a value from document

```
json-cli resolve --help
v1.3.0 json-cli resolve
JSON CLI tool, https://github.com/swaggest/json-cli
Usage:
   json-cli resolve [path] [pointer]
   path      Path to JSON/YAML file
   pointer   JSON Pointer, example /key4/1/a
```

Example:

```
json-cli resolve tests/assets/original.json /key4/1
{"a":2,"b":false}
```

#### Resolve `JSON Pointer` to a position in JSON file (line:col)

```
json-cli resolve-pos --help
v1.3.0 json-cli resolve-pos
JSON CLI tool, https://github.com/swaggest/json-cli
Usage:
   json-cli resolve-pos [path] [pointer]
   path      Path to JSON file
   pointer   JSON Pointer, example /key4/1/a

Options:
   --dump-all    Dump all pointer positions from JSON
```

Example:

```
json-cli resolve-pos tests/assets/original.json /key4/1
19:9
```

#### Validate JSON document against `JSON Schema`

```
json-cli validate-schema --help
v1.4.0 json-cli validate-schema
JSON CLI tool, https://github.com/swaggest/json-cli
Usage:
   json-cli validate-schema <data> [schema]
   data     Path to data (JSON/YAML)
   schema   Path to schema, default JSON Schema
```

Example:

```
json-cli validate-schema tests/assets/sample-data.json tests/assets/sample-schema.json
Data is invalid
No valid results for oneOf {
 0: String expected, 5 received at #->oneOf[0]
 1: Value more than 10 expected, 5 received at #->oneOf[1]->$ref[#/definitions/int10plus]
}
```

#### <a name="buildschema"></a> Generate/update `JSON Schema` from instance value(s).

New or existing schema is synchronized to match data samples.

```
v1.7.8 json-cli build-schema
JSON CLI tool, https://github.com/swaggest/json-cli
Usage: 
   json-cli build-schema <data> [schema]
   data     Path to data (JSON/YAML)
   schema   Path to parent schema   
   
Options: 
   --ptr-in-schema <ptrInSchema>           JSON pointer to structure in root schema, default #                      
   --ptr-in-data <ptrInData>               JSON pointer to structure in data, default #                             
   --jsonl                                 Data is a stream of JSON Lines                                           
   --use-nullable                          Use `nullable: true` instead of `type: null`, OAS 3.0 compatibility      
   --use-xnullable                         Use `x-nullable: true` instead of `type: null`, Swagger 2.0 compatibility
   --defs-ptr <defsPtr>                    Location to put new definitions. default: "#/definitions/"               
   --collect-examples                      Collect scalar values example                                            
   --heuristic-required                    Mark properties that are available in all samples as `required`.         
   --additional-data <additionalData...>   Additional paths to data                                                 
   --pretty                                Pretty-print result JSON                                                 
   --output <output>                       Path to output result, default STDOUT                                    
   --to-yaml                               Output in YAML format                                                    
   --to-serialized                         Output in PHP serialized format                                          
```

Basic example:

```
json-cli build-schema tests/assets/original.json 

{"properties":{"key1":{"items":{"type":"integer"},"type":"array"},"key2":{"type":"integer"},"key3":{"$ref":"#/definitions/key3"},"key4":{"items":{"$ref":"#/definitions/key4.element"},"type":"array"}},"type":"object","definitions":{"key3":{"properties":{"sub0":{"type":"integer"},"sub1":{"type":"string"},"sub2":{"type":"string"}},"type":"object"},"key4.element":{"properties":{"a":{"type":"integer"},"b":{"type":"boolean"}},"type":"object"}}}
```

Advanced example:

```
json-cli build-schema dump-responses.jsonl ./acme-service/swagger.json --ptr-in-schema "#/definitions/Orders" --jsonl --ptr-in-data "#/responseValue" --pretty --output swagger.json
```

Updates `swagger.json` with actual response samples provided in `dump-responses.jsonl`.

#### <a name="gengo"></a> Generate [`Go`](http://golang.org/) structure from `JSON Schema`.

`Go` code is built using [`swaggest/go-code-builder`](http://github.com/swaggest/go-code-builder).

```
v1.8.0 json-cli gen-go
JSON CLI tool, https://github.com/swaggest/json-cli
Generate Go code from JSON schema
Usage: 
   json-cli gen-go <schema>
   schema   Path to JSON schema file

Options: 
   --ptr-in-schema <ptrInSchema...>          JSON pointers to structure in root schema, default #
   --def-ptr <defPtr...>                     Definitions pointers to strip from symbol names, default #/definitions
   --patches <patches...>                    JSON patches to apply to schema file before processing, merge patches are also supported
   --output <output>                         Path to output .go file, STDOUT is used by default
   --package-name <packageName>              Go package name, default "entities"
   --root-name <rootName>                    Go root struct name, default "Structure", only used for # pointer
   --show-const-properties                   Show properties with constant values, hidden by default
   --keep-parent-in-property-names           Keep parent prefix in property name, removed by default
   --ignore-nullable                         Add `omitempty` to nullable properties, removed by default
   --ignore-xgo-type                         Ignore `x-go-type` in schema to skip generation
   --with-zero-values                        Use pointer types to avoid zero value ambiguity
   --enable-xnullable                        Add `null` to types if `x-nullable` or `nullable` is available
   --enable-default-additional-properties    Add field property for undefined `additionalProperties`
   --fluent-setters                          Add fluent setters to struct fields
   --ignore-required                         Ignore if property is required when deciding on pointer type or omitempty
   --renames <renames...>                    Map of exported symbol renames, example From:To
   --with-tests                              Generate (un)marshaling tests for entities (experimental feature)
   --require-xgenerate                       Generate properties with `x-generate: true` only
   --validate-required                       Generate validation code to check required properties during unmarshal
   --name-tags <nameTags...>                 Set additional field tags with property name, example "msgp bson"
```

Example:

```
json-cli gen-go http://json-schema.org/learn/examples/address.schema.json
```

```
// Code generated by github.com/swaggest/json-cli v1.6.3, DO NOT EDIT.

// Package entities contains JSON mapping structures.
package entities



// Structure structure is generated from "#".
//
// An address similar to http://microformats.org/wiki/h-card.
type Structure struct {
        PostOfficeBox   string `json:"post-office-box,omitempty"`
        ExtendedAddress string `json:"extended-address,omitempty"`
        StreetAddress   string `json:"street-address,omitempty"`
        Locality        string `json:"locality,omitempty"`
        Region          string `json:"region,omitempty"`
        PostalCode      string `json:"postal-code,omitempty"`
        CountryName     string `json:"country-name,omitempty"`
}
```

Advanced example:

```
json-cli gen-go "https://raw.githubusercontent.com/asyncapi/asyncapi/2.0.0-rc1/examples/1.2.0/streetlights.yml" \
    --ptr-in-schema "#/components/messages/lightMeasured/payload" "#/components/messages/turnOnOff/payload" \
    --def-ptr "#/components/schemas" \
    --package-name message \
    --output ./entities.go

cat ./entities.go
```

```
// Code generated by github.com/swaggest/json-cli v1.6.3, DO NOT EDIT.

// Package message contains JSON mapping structures.
package message

import (
        "fmt"
        "time"
)

// LightMeasuredPayload structure is generated from "#/components/schemas/lightMeasuredPayload".
type LightMeasuredPayload struct {
        Lumens int64      `json:"lumens,omitempty"` // Light intensity measured in lumens.
        SentAt *time.Time `json:"sentAt,omitempty"` // Date and time when the message was sent.
}

// TurnOnOffPayload structure is generated from "#/components/schemas/turnOnOffPayload".
type TurnOnOffPayload struct {
        Command TurnOnOffPayloadCommand `json:"command,omitempty"` // Whether to turn on or off the light.
        SentAt  *time.Time              `json:"sentAt,omitempty"`  // Date and time when the message was sent.
}

// TurnOnOffPayloadCommand is an enum type.
type TurnOnOffPayloadCommand string

// TurnOnOffPayloadCommand values enumeration.
const (
        TurnOnOffPayloadCommandOn = TurnOnOffPayloadCommand("on")
        TurnOnOffPayloadCommandOff = TurnOnOffPayloadCommand("off")
)

// MarshalJSON encodes JSON.
func (i TurnOnOffPayloadCommand) MarshalJSON() ([]byte, error) {
        switch i {
        case TurnOnOffPayloadCommandOn:
        case TurnOnOffPayloadCommandOff:

        default:
                return nil, fmt.Errorf("unexpected TurnOnOffPayloadCommand value: %v", i)
        }

        return json.Marshal(string(i))
}

// UnmarshalJSON decodes JSON.
func (i *TurnOnOffPayloadCommand) UnmarshalJSON(data []byte) error {
        var ii string
        err := json.Unmarshal(data, &ii)
        if err != nil {
                return err
        }
        v := TurnOnOffPayloadCommand(ii)
        switch v {
        case TurnOnOffPayloadCommandOn:
        case TurnOnOffPayloadCommandOff:

        default:
                return fmt.Errorf("unexpected TurnOnOffPayloadCommand value: %v", v)
        }

        *i = v
        return nil
}
```

#### <a name="genphp"></a> Generate `PHP` classes from `JSON Schema`.

`PHP` code is built using [`swaggest/php-code-builder`](http://github.com/swaggest/php-code-builder).

Generated classes require [`swaggest/json-schema`](http://github.com/swaggest/php-json-schema) package.

```
v1.8.0 json-cli gen-php
JSON CLI tool, https://github.com/swaggest/json-cli
Generate PHP code from JSON schema
Usage: 
   json-cli gen-php <schema> --ns <ns> --ns-path <nsPath>
   schema   Path to JSON schema file

Options: 
   --ptr-in-schema <ptrInSchema...>           JSON pointers to structure in root schema, default #
   --def-ptr <defPtr...>                      Definitions pointers to strip from symbol names, default #/definitions
   --patches <patches...>                     JSON patches to apply to schema file before processing, merge patches are also supported
   --ns <ns>                                  Namespace to use for generated classes, example \MyClasses
   --ns-path <nsPath>                         Path to store generated classes, example ./src/MyClasses
   --root-name <rootName>                     Go root struct name, default "Structure", only used for # pointer
   --setters                                  Build setters
   --getters                                  Build getters
   --no-enum-const                            Do not create constants for enum/const values
   --declare-property-defaults                Use default values to initialize properties
   --build-additional-properties-accessors    Build accessors for additionalProperties
```

Advanced example:

```
mkdir ./StreetLights

json-cli gen-php "https://raw.githubusercontent.com/asyncapi/asyncapi/2.0.0-rc1/examples/1.2.0/streetlights.yml" \
    --ptr-in-schema "#/components/messages/lightMeasured/payload" "#/components/messages/turnOnOff/payload" \
    --def-ptr "#/components/schemas" \
    --ns MyApp\\StreetLights \
    --ns-path ./StreetLights
    
cat ./StreetLights/*
```

```
Classes are generated in /path/to/StreetLights

<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace MyApp\StreetLights;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * Built from #/components/schemas/lightMeasuredPayload
 *  <- streetlights.yml#/components/messages/lightMeasured/payload
 */
class LightMeasuredPayload extends ClassStructure
{
    /** @var int Light intensity measured in lumens. */
    public $lumens;

    /** @var string Date and time when the message was sent. */
    public $sentAt;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->lumens = Schema::integer();
        $properties->lumens->description = "Light intensity measured in lumens.";
        $properties->lumens->minimum = 0;
        $properties->sentAt = Schema::string();
        $properties->sentAt->description = "Date and time when the message was sent.";
        $properties->sentAt->format = "date-time";
        $properties->sentAt->setFromRef('#/components/schemas/sentAt');
        $ownerSchema->type = 'object';
        $ownerSchema->components = (object)array(
            'schemas' =>
            (object)(array(
                 'sentAt' =>
                (object)(array(
                     'description' => 'Date and time when the message was sent.',
                     'type' => 'string',
                     'format' => 'date-time',
                )),
            )),
        );
        $ownerSchema->setFromRef('streetlights.yml#/components/messages/lightMeasured/payload');
    }
}<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace MyApp\StreetLights;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * Built from #/components/schemas/turnOnOffPayload
 *  <- streetlights.yml#/components/messages/turnOnOff/payload
 */
class TurnOnOffPayload extends ClassStructure
{
    const ON = 'on';

    const OFF = 'off';

    /** @var string Whether to turn on or off the light. */
    public $command;

    /** @var string Date and time when the message was sent. */
    public $sentAt;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        $properties->command = Schema::string();
        $properties->command->enum = array(
            self::ON,
            self::OFF,
        );
        $properties->command->description = "Whether to turn on or off the light.";
        $properties->sentAt = Schema::string();
        $properties->sentAt->description = "Date and time when the message was sent.";
        $properties->sentAt->format = "date-time";
        $properties->sentAt->setFromRef('#/components/schemas/sentAt');
        $ownerSchema->type = 'object';
        $ownerSchema->components = (object)array(
            'schemas' =>
            (object)(array(
                 'sentAt' =>
                (object)(array(
                     'description' => 'Date and time when the message was sent.',
                     'type' => 'string',
                     'format' => 'date-time',
                )),
            )),
        );
        $ownerSchema->setFromRef('streetlights.yml#/components/messages/turnOnOff/payload');
    }
}
```

#### <a name="genjsdoc"></a> Generate `JSDoc` type definitions from `JSON Schema`.

```
v1.8.4 json-cli gen-jsdoc
JSON CLI tool, https://github.com/swaggest/json-cli
Generate JSDoc code from JSON schema
Usage: 
   json-cli gen-jsdoc <schema>
   schema   Path to JSON schema file
   
Options: 
   --ptr-in-schema <ptrInSchema...>   JSON pointers to structure in root schema, default #                                 
   --def-ptr <defPtr...>              Definitions pointers to strip from symbol names, default #/definitions                  
   --patches <patches...>             JSON patches to apply to schema file before processing, merge patches are also supported
```

Example:

```
json-cli gen-jsdoc "https://raw.githubusercontent.com/asyncapi/asyncapi/2.0.0-rc1/examples/1.2.0/streetlights.yml" \
    --ptr-in-schema "#/components/messages/lightMeasured/payload" "#/components/messages/turnOnOff/payload" \
    --def-ptr "#/components/schemas"
```

```
/**
 * @typedef ComponentsMessagesLightMeasuredPayload
 * @type {object}
 * @property {number} lumens - Light intensity measured in lumens.
 * @property {string} sentAt - Date and time when the message was sent.
 */

/**
 * @typedef ComponentsMessagesTurnOnOffPayload
 * @type {object}
 * @property {string} command - Whether to turn on or off the light.
 * @property {string} sentAt - Date and time when the message was sent.
 */

```

#### <a name="genjson"></a> Generate `JSON` sample from `JSON Schema`.

```
v1.9.0 json-cli gen-json
JSON CLI tool, https://github.com/swaggest/json-cli
Generate JSON sample from JSON schema
Usage: 
   json-cli gen-json <schema>
   schema   Path to JSON schema file, use `-` for STDIN

Options: 
   --ptr-in-schema <ptrInSchema...>   JSON pointers to structure in root schema, default #
   --def-ptr <defPtr...>              Definitions pointers to strip from symbol names, default #/definitions
   --patches <patches...>             JSON patches to apply to schema file before processing, merge patches are also supported
   --max-nesting <maxNesting>         Max nesting level, default 10
   --default-additional-properties    Treat non-existent `additionalProperties` as `additionalProperties: true`
   --rand-seed <randSeed>             Integer random seed for deterministic output
   --pretty                           Pretty-print result JSON
   --output <output>                  Path to output result, default STDOUT
   --to-yaml                          Output in YAML format
   --to-serialized                    Output in PHP serialized format
```

```
echo '{
  "properties": {
    "foo": {
      "type": "string",
      "example": "abc"
    },
    "bar": {
      "enum": ["baz", "quux"]
    }
  }
}' | ./bin/json-cli gen-json - --rand-seed 10
```

```
{"foo":"abc","bar":"baz"}
```