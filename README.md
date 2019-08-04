# JSON CLI tool

A CLI for finding unordered diff between two `JSON` documents (based on [`swaggest/json-diff`](https://github.com/swaggest/json-diff)), pretty print, minify, yaml convert, etc....

[![Build Status](https://travis-ci.org/swaggest/json-cli.svg?branch=master)](https://travis-ci.org/swaggest/json-cli)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/swaggest/json-cli/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/swaggest/json-cli/?branch=master)
[![Code Climate](https://codeclimate.com/github/swaggest/json-cli/badges/gpa.svg)](https://codeclimate.com/github/swaggest/json-cli)
[![Code Coverage](https://scrutinizer-ci.com/g/swaggest/json-cli/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/swaggest/json-cli/code-structure/master/code-coverage)

## Purpose

 * To simplify changes review between two `JSON` files you can use a standard `diff` tool on rearranged pretty-printed `JSON`.
 * To detect breaking changes by analyzing removals and changes from original `JSON`.
 * To keep original order of object sets (for example `swagger.json` [parameters](https://swagger.io/docs/specification/describing-parameters/) list).
 * To make and apply JSON Patches, specified in [RFC 6902](http://tools.ietf.org/html/rfc6902) from the IETF.
 * To convert between YAML/JSON/PHP serialization.
 * To resolve `JSON Pointer` to data.
 * To resolve `JSON Pointer` to file position.
 * To validate JSON data against [`JSON Schema`](http://json-schema.org/).
 * To [render](#gengo) `JSON Schema` as [`Go`](http://golang.org/) structure.
 * To [render](#genphp) `JSON Schema` as `PHP` classes.

## Installation

### Composer

[Install PHP Composer](https://getcomposer.org/doc/00-intro.md)

```bash
composer require swaggest/json-cli
```

## CLI tool

### Usage

```
v1.3.0 json-cli
JSON CLI tool, https://github.com/swaggest/json-cli
Usage:
   json-cli <action>
   action   Action name
            Allowed values: diff, apply, rearrange, diff-info, pretty-print, minify, replace, resolve,
            resolve-pos
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
v1.3.0 json-cli minify
JSON CLI tool, https://github.com/swaggest/json-cli
Minify JSON document
Usage:
   json-cli minify <path>
   path   Path to JSON/YAML file

Options:
   --output <output>   Path to output result, default STDOUT
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

#### <a name="gengo"></a> Generate [`Go`](http://golang.org/) structure from `JSON Schema`.

`Go` code is built using [`swaggest/go-code-builder`](http://github.com/swaggest/go-code-builder).

```
json-cli gen-go --help
v1.5.0 json-cli gen-go
JSON CLI tool, https://github.com/swaggest/json-cli
Generate Go code from JSON schema
Usage: 
   json-cli gen-go <schema>
   schema   Path to JSON schema file
   
Options: 
   --output <output>                  Path to output .go file, STDOUT is used by default                    
   --ptr-in-schema <ptrInSchema...>   JSON pointers to structure in in root schema, default #               
   --package-name <packageName>       Go package name, default "entities"                                   
   --root-name <rootName>             Go root struct name, default "Structure", only used for # pointer     
   --def-ptr <defPtr...>              Definitions pointers to strip from symbol names, default #/definitions
   --show-const-properties            Show properties with constant values, hidden by default               
   --keep-parent-in-property-names    Keep parent prefix in property name, removed by default               
```

Example:

```
json-cli gen-go http://json-schema.org/learn/examples/address.schema.json
```
```
// Code generated by github.com/swaggest/json-cli, DO NOT EDIT.

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
// Code generated by github.com/swaggest/json-cli, DO NOT EDIT.

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
json-cli gen-php --help
v1.6.0 json-cli gen-php
JSON CLI tool, https://github.com/swaggest/json-cli
Generate PHP code from JSON schema
Usage: 
   json-cli gen-php <schema> --ns <ns> --ns-path <nsPath>
   schema   Path to JSON schema file

Options: 
   --ns <ns>                          Namespace to use for generated classes, example \MyClasses
   --ns-path <nsPath>                 Path to store generated classes, example ./src/MyClasses
   --ptr-in-schema <ptrInSchema...>   JSON pointers to structure in in root schema, default #
   --root-name <rootName>             Go root struct name, default "Structure", only used for # pointer
   --def-ptr <defPtr...>              Definitions pointers to strip from symbol names, default #/definitions
   --setters                          Build setters
   --getters                          Build getters
   --no-enum-const                    Do not create constants for enum/const values

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