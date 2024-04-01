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
export RPC_URL=$RPC_URL
export WALLET=$WALLET
export PRIVATE_KEY=$PRIVATE_KEY
export CONTRACT_ADDRESS=$CONTRACT_ADDRESS


echo "MAIL_USERNAME=$MAIL_USERNAME" >> /var/www/html/.env
echo "MAIL_PASSWORD=$MAIL_PASSWORD" >> /var/www/html/.env
echo "MAIL_FROM_ADDRESS=$MAIL_FROM_ADDRESS" >> /var/www/html/.env
echo "DB_CONNECTION=$DB_CONNECTION" >> /var/www/html/.env
echo "DB_HOST=$DB_HOST" >> /var/www/html/.env
echo "DB_PORT=$DB_PORT" >> /var/www/html/.env
echo "DB_DATABASE=$DB_DATABASE" >> /var/www/html/.env
echo "DB_USERNAME=$DB_USERNAME"  >> /var/www/html/.env
echo "DB_PASSWORD=$DB_PASSWORD" >> /var/www/html/.env 
echo "RPC_URL=$RPC_URL" >> /var/www/html/.env 
echo "WALLET=$WALLET" >> /var/www/html/.env 
echo "PRIVATE_KEY=$PRIVATE_KEY" >> /var/www/html/.env 
echo "CONTRACT_ADDRESS=$CONTRACT_ADDRESS" >> /var/www/html/.env 

composer install --ignore-platform-reqs

service redis-server start
php-fpm &
service nginx start
tail -f /dev/null