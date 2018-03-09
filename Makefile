phar:
	composer install --no-dev;rm -rf tests/;rm ./json-cli;rm ./json-cli.tar.gz;phar-composer build;mv ./json-cli.phar ./json-cli;tar -zcvf ./json-cli.tar.gz ./json-cli;git reset --hard;composer install
