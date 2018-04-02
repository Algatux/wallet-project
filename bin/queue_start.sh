#!/usr/bin/env bash

bin/rabbitmq-cli-consumer -c app/config/vendors/amqp/consumer-dev.conf -o -V -i -q wallet -e "bin/console amqp:message:broker"