#!/usr/bin/env bash

docker-compose up -d --force-recreate
echo "Waiting for services ..."
sleep 10
docker exec -ti dev_php composer install
docker exec -ti dev_php bower install
docker exec -ti dev_php bin/console doctrine:database:drop -n --if-exists --force
docker-compose stop
