#!/usr/bin/env bash

docker-compose up -d --force-recreate
docker exec -ti dev_php composer install
docker exec -ti dev_php bower install
docker exec -ti dev_php bin/console doctrine:database:drop -n --if-exists --force
docker-compose stop
