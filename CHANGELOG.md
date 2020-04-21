# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
