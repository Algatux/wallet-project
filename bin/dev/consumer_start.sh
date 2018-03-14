#!/usr/bin/env bash

COMMAND="bin/console amqp:message:broker -v"
CONFIGURATION="app/config/vendors/amqp/consumer-dev.conf"

bin/rabbitmq-cli-consumer -i -o -V -e $COMMAND -c $CONFIGURATION