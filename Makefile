PHPSTAN_VERSION ?= 0.12.60

phar:
	@test -f $$HOME/.cache/composer/phar-composer.phar || (mkdir -p $$HOME/.cache/composer/ && wget https://github.com/clue/phar-composer/releases/download/v1.2.0/phar-composer-1.2.0.phar -O $$HOME/.cache/composer/phar-composer.phar)
	@composer install --no-dev;rm -rf vendor/salsify/json-streaming-parser/tests;rm -f vendor/salsify/json-streaming-parser/phpunit;rm -rf tests/;rm ./json-cli;rm ./json-cli.tar.gz;php -d phar.readonly=off $$HOME/.cache/composer/phar-composer.phar build;mv ./json-cli.phar ./json-cli;chmod +x ./json-cli;tar -zcvf ./json-cli.tar.gz ./json-cli;git reset --hard;composer install

docker-build-push:
	@docker buildx build --push --platform linux/amd64,linux/arm64/v8 . -t swaggest/json-cli:latest
	@docker buildx build --push --platform linux/amd64,linux/arm64/v8 . -t swaggest/json-cli:$(shell git describe --abbrev=0 --tags)

lint:
	@test -f ${HOME}/.cache/composer/phpstan-${PHPSTAN_VERSION}.phar || (mkdir -p ${HOME}/.cache/composer/ && wget https://github.com/phpstan/phpstan/releases/download/${PHPSTAN_VERSION}/phpstan.phar -O ${HOME}/.cache/composer/phpstan-${PHPSTAN_VERSION}.phar)
	@php $$HOME/.cache/composer/phpstan-${PHPSTAN_VERSION}.phar analyze -l 7 -c phpstan.neon ./src

docker-lint:
	@docker run -v $$PWD:/app --rm phpstan/phpstan analyze -l 7 -c phpstan.neon ./src

test:
	@php -derror_reporting="E_ALL & ~E_DEPRECATED" vendor/bin/phpunit

test-coverage:
	@php -derror_reporting="E_ALL & ~E_DEPRECATED" -dzend_extension=xdebug.so -dxdebug.mode=coverage vendor/bin/phpunit --coverage-text

build-go:
	@cd tests/assets/go/ && go build ./...