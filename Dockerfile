FROM php:cli

COPY ./json-cli /bin/json-cli

WORKDIR /code