#!/usr/bin/env bash

BROKER_CMD="bin/console amqp:message:broker -v --env=prod"
CONSUMER_CONF="app/config/vendors/amqp/consumer-prod.conf"

bin/rabbitmq-cli-consumer -i -o -V -e "${BROKER_CMD}" -c "${CONSUMER_CONF}"