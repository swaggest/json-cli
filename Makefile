phar:
	composer install --no-dev;rm -rf vendor/salsify/json-streaming-parser/tests;rm -f vendor/salsify/json-streaming-parser/phpunit;rm -rf tests/;rm ./json-cli;rm ./json-cli.tar.gz;phar-composer build;mv ./json-cli.phar ./json-cli;tar -zcvf ./json-cli.tar.gz ./json-cli;git reset --hard;composer install

lint:
	@test -f $$HOME/.cache/composer/phpstan-0.11.8.phar || (mkdir -p $$HOME/.cache/composer/ && wget https://github.com/phpstan/phpstan/releases/download/0.11.8/phpstan.phar -O $$HOME/.cache/composer/phpstan-0.11.8.phar)
	@php $$HOME/.cache/composer/phpstan-0.11.8.phar analyze -l 7 -c phpstan.neon ./src

docker-lint:
	@docker run -v $$PWD:/app --rm phpstan/phpstan analyze -l 7 -c phpstan.neon ./src

test:
	@php -derror_reporting="E_ALL & ~E_DEPRECATED" vendor/bin/phpunit

test-coverage:
	@php -derror_reporting="E_ALL & ~E_DEPRECATED" -dzend_extension=xdebug.so vendor/bin/phpunit --coverage-text
