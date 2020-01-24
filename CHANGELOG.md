# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

[1.6.8]: https://github.com/swaggest/json-cli/compare/v1.6.7...v1.6.8
[1.6.7]: https://github.com/swaggest/json-cli/compare/v1.6.6...v1.6.7
[1.6.6]: https://github.com/swaggest/json-cli/compare/v1.6.5...v1.6.6
[1.6.5]: https://github.com/swaggest/json-cli/compare/v1.6.4...v1.6.5
[1.6.4]: https://github.com/swaggest/json-cli/compare/v1.6.3...v1.6.4
[1.6.3]: https://github.com/swaggest/json-cli/compare/v1.6.2...v1.6.3
[1.6.2]: https://github.com/swaggest/json-cli/compare/v1.6.1...v1.6.2
