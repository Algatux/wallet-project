#!/usr/bin/env bash

BROKER_CMD="bin/console amqp:message:broker -v"
CONSUMER_CONF="app/config/vendors/amqp/consumer-dev.conf"

bin/rabbitmq-cli-consumer -i -o -V -e "${BROKER_CMD}" -c "${CONSUMER_CONF}"