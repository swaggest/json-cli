# JSON diff and rearrange tool for PHP

A CLI for finding unordered diff between two `JSON` documents (based on [`swaggest/json-cli`](https://github.com/swaggest/json-cli)).

[![Build Status](https://travis-ci.org/swaggest/json-cli-cli.svg?branch=master)](https://travis-ci.org/swaggest/json-cli-cli)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/swaggest/json-cli-cli/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/swaggest/json-cli-cli/?branch=master)
[![Code Climate](https://codeclimate.com/github/swaggest/json-cli-cli/badges/gpa.svg)](https://codeclimate.com/github/swaggest/json-cli-cli)
[![Code Coverage](https://scrutinizer-ci.com/g/swaggest/json-cli-cli/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/swaggest/json-cli-cli/code-structure/master/code-coverage)

## Purpose

 * To simplify changes review between two `JSON` files you can use a standard `diff` tool on rearranged pretty-printed `JSON`.
 * To detect breaking changes by analyzing removals and changes from original `JSON`.
 * To keep original order of object sets (for example `swagger.json` [parameters](https://swagger.io/docs/specification/describing-parameters/) list).
 * To make and apply JSON Patches, specified in [RFC 6902](http://tools.ietf.org/html/rfc6902) from the IETF.

## Installation

### Composer

[Install PHP Composer](https://getcomposer.org/doc/00-intro.md)

```bash
composer require swaggest/json-cli-cli
```

## CLI tool

### Usage

```
json-cli --help
v1.0.0 json-cli
JSON diff and apply tool for PHP, https://github.com/swaggest/json-cli-cli
Usage: 
   json-cli <action>
   action   Action name
            Allowed values: diff, apply, rearrange, info, pretty-print
```

```
json-cli diff --help
v1.0.0 json-cli diff
JSON diff and apply tool for PHP, https://github.com/swaggest/json-cli
Make patch from two json documents, output to STDOUT
Usage:
   json-cli diff <originalPath> <newPath>
   originalPath   Path to old (original) json file
   newPath        Path to new json file

Options:
   --pretty              Pretty-print result JSON
   --rearrange-arrays    Rearrange arrays to match original
```

```
json-cli apply --help
v1.0.0 json-cli apply
JSON diff and apply tool for PHP, https://github.com/swaggest/json-cli-cli
Apply patch to base json document, output to STDOUT
Usage:
   json-cli apply [patchPath] [basePath]
   patchPath   Path to JSON patch file
   basePath    Path to JSON base file

Options:
   --pretty              Pretty-print result JSON
   --rearrange-arrays    Rearrange arrays to match original
```

```
json-cli rearrange --help
v1.0.0 json-cli rearrange
JSON diff and apply tool for PHP, https://github.com/swaggest/json-cli-cli
Rearrange json document in the order of another (original) json document
Usage:
   json-cli rearrange <originalPath> <newPath>
   originalPath   Path to old (original) json file
   newPath        Path to new json file

Options:
   --pretty              Pretty-print result JSON
   --rearrange-arrays    Rearrange arrays to match original
```

```
json-cli info --help
v1.0.0 json-cli info
JSON diff and apply tool for PHP, https://github.com/swaggest/json-cli-cli
Show diff info for two JSON documents
Usage:
   json-cli info <originalPath> <newPath>
   originalPath   Path to old (original) json file
   newPath        Path to new json file

Options:
   --pretty              Pretty-print result JSON
   --rearrange-arrays    Rearrange arrays to match original
   --with-contents       Add content to output
   --with-paths          Add paths to output
```

### Examples

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

Showing differences in `JSON` mode

```
json-cli info tests/assets/original.json tests/assets/new.json --with-paths --pretty
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
