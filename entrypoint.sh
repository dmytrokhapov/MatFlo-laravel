#!/bin/bash

export MAIL_USERNAME=$MAIL_USERNAME
export MAIL_PASSWORD=$MAIL_PASSWORD
export MAIL_FROM_ADDRESS=$MAIL_FROM_ADDRESS
export DB_CONNECTION=$DB_CONNECTION
export DB_HOST=$DB_HOST
export DB_PORT=$DB_PORT
export DB_DATABASE=$DB_DATABASE
export DB_USERNAME=$DB_USERNAME
export DB_PASSWORD=$DB_PASSWORD

service redis-server start
php-fpm &
service nginx start
tail -f /dev/null
