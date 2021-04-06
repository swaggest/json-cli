FROM php:cli-alpine

COPY ./json-cli /bin/json-cli

WORKDIR /code