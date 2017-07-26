#!/usr/bin/env bash

docker-compose up -d
docker exec -ti dev_php bin/console doctrine:database:drop -n --if-exists --force
docker exec -ti dev_php bin/console doctrine:database:create -n
docker exec -ti dev_php bin/console doctrine:schema:create
docker exec -ti dev_php bin/console doctrine:fixtures:load -n
