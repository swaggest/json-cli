# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

[1.6.3]: https://github.com/swaggest/json-cli/compare/v1.6.2...v1.6.3
[1.6.2]: https://github.com/swaggest/json-cli/compare/v1.6.1...v1.6.2
