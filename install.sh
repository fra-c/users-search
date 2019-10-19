#!/usr/bin/env bash

cp .env.example .env

docker run -it --rm -v $(pwd):/app composer install

docker-compose up -d

echo "Waiting for mysql service to start before running migrations.."
sleep 30

docker-compose run --rm php vendor/bin/doctrine-migrations migrations:migrate --no-interaction
