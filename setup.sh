#!/usr/bin/env bash

docker-compose up -d --build --force-recreate
docker exec -ti dev_php composer install
docker exec -ti dev_php bin/console doctrine:database:drop -n --if-exists --force
docker-compose stop
