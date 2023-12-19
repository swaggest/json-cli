# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.11.2] - 2023-12-19

### Added
- Dependencies updated.

## [1.11.1] - 2022-11-14

### Fixed
- Handling of `*Of` in PHP generation.

## [1.11.0] - 2022-09-18

### Added
- Configurable schema url resolver

## [1.10.0] - 2022-09-16

### Added
- Dependencies updated.
- Generate Markdown from JSON Schema.
- Options for Go generator with JSON file.

## [1.9.1] - 2022-04-21

### Added
- Dependencies updated.

### Fixed
- Compatibility with PHP 8.1.

## [1.9.0] - 2021-10-28

### Added
- Dependencies updated.
- Command `gen-json` to generate sample JSON value from JSON Schema.
- Support for STDIN via `-` file path.

### Changed
- Terminal output now has trailing line break.

### Fixed
- Disabled preloaded standard schemas.

## [1.8.8] - 2021-09-26

### Added
- Dependencies updated.

## [1.8.7] - 2021-04-20

### Fixed
- Out of memory error with infinite recursion in some JSON Schema references.

## [1.8.6] - 2021-04-20

### Added
- Dependencies updated.

## [1.8.5] - 2021-04-20

### Added
- Dependencies updated.

## [1.8.4] - 2021-04-07

### Added
- Generation of JSDoc type definitions from JSON Schema with `gen-jsdoc`.

## [1.8.3] - 2020-12-14

### Fixed
- Stale app version

## [1.8.2] - 2020-12-13

### Changed
- Internal refactoring of CLI options.

## [1.8.1] - 2020-12-13

### Added
- Dependencies updated.

## [1.8.0] - 2020-09-30

### Added
- Dependencies updated.
- Added schema patches to `gen-go` and `gen-php`.
- Added property name fields controls in `gen-go`.

## [1.7.13] - 2020-09-26

### Added
- Dependency `swaggest/json-diff` updated.

## [1.7.12] - 2020-09-25

### Added
- Dependency `swaggest/json-diff` updated.

## [1.7.11] - 2020-09-22

### Added
- Dependencies updated.

### Fixed
- Removing empty destination directory when generating PHP classes, [#19](https://github.com/swaggest/json-cli/issues/19).

## [1.7.10] - 2020-05-20

### Added
- Dependencies updated.

## [1.7.9] - 2020-04-29

### Added
- Dependencies updated.

## [1.7.8] - 2020-04-28

### Changed
- Hardcoded time limit for 60 seconds removed.

### Added
- Option `--validate-required` to validate required properties during unmarshal in `gen-go`.
- Dependencies updated.

## [1.7.7] - 2020-04-21

### Added
- Dependencies updated.

## [1.7.6] - 2020-04-04

### Added
- Option `--require-xgenerate` to generate properties with `x-generate: true` only in `gen-go`.

### Fixed
- Handling of malformed JSONL in `build-schema`, invalid lines are skipped.

## [1.7.5] - 2020-03-30

### Added
- Option to add multiple data samples in `build-schema`.
- Option to add new line in `minify`.

### Fixed
- Generated tests do not honor `--enable-default-additional-properties`.

## [1.7.4] - 2020-03-17

### Added
- Option to rename generated symbols in `gen-go`.

## [1.7.3] - 2020-03-10

### Added
- Dependencies updated.
- Tests generator in `gen-go`.
- Example collector in `build-schema`.

## [1.7.2] - 2020-02-25

### Added
- Dependencies updated.
- Backwards compatibility option `--ignore-required` in `gen-go` to ignore if property is required when deciding on pointer type or omitempty.

## [1.7.1] - 2020-02-02

### Added
- Dependencies updated.

## [1.7.0] - 2020-01-26

### Added
- Command to build JSON Schema from instance value(s).
- Dependencies updated.

## [1.6.8] - 2020-01-24

### Added
- Option to build accessors for additional properties in generated `PHP` classes.
- Option to declare default values for properties in generated `PHP` classes.
- Option to create and apply JSON Merge Patches (RFC 7386).

## [1.6.7] - 2020-01-04

### Added
- Option to build fluent setters in generated `Go` structures.

## [1.6.6] - 2019-12-03

### Added
- Dependencies updated to fix issues in `swaggest/php-code-builder` and `swaggest/php-json-schema`.

## [1.6.5] - 2019-11-18

### Added
- Updated `swaggest/go-code-builder` to improve memory efficiency of generated `Go` structures.

## [1.6.4] - 2019-10-27

### Added
- Dependencies updated.

## [1.6.3] - 2019-10-15

### Added
- Option to disable null `additionalProperties` (`--enable-default-additional-properties`) rendering in `gen-go`.
- Option to ignore [`x-go-type`](https://github.com/swaggest/go-code-builder#x-go-type) (`--ignore-xgo-type`) in `gen-go`.
- Option to add `omitempty` on nullable types (`--ignore-nullable`) in `gen-go`.
- Option to use pointer types to distinguish zero from unset (`--with-zero-values`) in `gen-go`.
- Option to inherit nullability from [`x-nullable`/`nullable`](https://github.com/swaggest/go-code-builder#x-nullable-nullable) vendor extensions (`--enable-xnullable`) in `gen-go`.
- Version of `json-cli` to head comment of `gen-go` output.

## [1.6.2] - 2019-09-22

### Added
- Docker image.
- Dependencies updated.

### Fixed
- Local file resolver in references.

[1.11.2]: https://github.com/swaggest/json-cli/compare/v1.11.1...v1.11.2
[1.11.1]: https://github.com/swaggest/json-cli/compare/v1.10.1...v1.11.1
[1.11.0]: https://github.com/swaggest/json-cli/compare/v1.10.0...v1.11.0
[1.10.0]: https://github.com/swaggest/json-cli/compare/v1.9.1...v1.10.0
[1.9.1]: https://github.com/swaggest/json-cli/compare/v1.9.0...v1.9.1
[1.9.0]: https://github.com/swaggest/json-cli/compare/v1.8.8...v1.9.0
[1.8.8]: https://github.com/swaggest/json-cli/compare/v1.8.7...v1.8.8
[1.8.7]: https://github.com/swaggest/json-cli/compare/v1.8.6...v1.8.7
[1.8.6]: https://github.com/swaggest/json-cli/compare/v1.8.5...v1.8.6
[1.8.5]: https://github.com/swaggest/json-cli/compare/v1.8.4...v1.8.5
[1.8.4]: https://github.com/swaggest/json-cli/compare/v1.8.3...v1.8.4
[1.8.3]: https://github.com/swaggest/json-cli/compare/v1.8.2...v1.8.3
[1.8.2]: https://github.com/swaggest/json-cli/compare/v1.8.1...v1.8.2
[1.8.1]: https://github.com/swaggest/json-cli/compare/v1.8.0...v1.8.1
[1.8.0]: https://github.com/swaggest/json-cli/compare/v1.7.13...v1.8.0
[1.7.13]: https://github.com/swaggest/json-cli/compare/v1.7.12...v1.7.13
[1.7.12]: https://github.com/swaggest/json-cli/compare/v1.7.11...v1.7.12
[1.7.11]: https://github.com/swaggest/json-cli/compare/v1.7.10...v1.7.11
[1.7.10]: https://github.com/swaggest/json-cli/compare/v1.7.9...v1.7.10
[1.7.9]: https://github.com/swaggest/json-cli/compare/v1.7.8...v1.7.9
[1.7.8]: https://github.com/swaggest/json-cli/compare/v1.7.7...v1.7.8
[1.7.7]: https://github.com/swaggest/json-cli/compare/v1.7.6...v1.7.7
[1.7.6]: https://github.com/swaggest/json-cli/compare/v1.7.5...v1.7.6
[1.7.5]: https://github.com/swaggest/json-cli/compare/v1.7.4...v1.7.5
[1.7.4]: https://github.com/swaggest/json-cli/compare/v1.7.3...v1.7.4
[1.7.3]: https://github.com/swaggest/json-cli/compare/v1.7.2...v1.7.3
[1.7.2]: https://github.com/swaggest/json-cli/compare/v1.7.1...v1.7.2
[1.7.1]: https://github.com/swaggest/json-cli/compare/v1.7.0...v1.7.1
[1.7.0]: https://github.com/swaggest/json-cli/compare/v1.6.8...v1.7.0
[1.6.8]: https://github.com/swaggest/json-cli/compare/v1.6.7...v1.6.8
[1.6.7]: https://github.com/swaggest/json-cli/compare/v1.6.6...v1.6.7
[1.6.6]: https://github.com/swaggest/json-cli/compare/v1.6.5...v1.6.6
[1.6.5]: https://github.com/swaggest/json-cli/compare/v1.6.4...v1.6.5
[1.6.4]: https://github.com/swaggest/json-cli/compare/v1.6.3...v1.6.4
[1.6.3]: https://github.com/swaggest/json-cli/compare/v1.6.2...v1.6.3
[1.6.2]: https://github.com/swaggest/json-cli/compare/v1.6.1...v1.6.2
