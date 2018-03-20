phar:
	composer install --no-dev;rm -rf vendor/salsify/json-streaming-parser/tests;rm -f vendor/salsify/json-streaming-parser/phpunit;rm -rf tests/;rm ./json-cli;rm ./json-cli.tar.gz;phar-composer build;mv ./json-cli.phar ./json-cli;tar -zcvf ./json-cli.tar.gz ./json-cli;git reset --hard;composer install
