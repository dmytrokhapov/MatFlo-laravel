FROM php:8.1-fpm

WORKDIR /var/www/html

ARG MAIL_USERNAME
ARG MAIL_PASSWORD
ARG MAIL_FROM_ADDRESS
ARG DB_CONNECTION
ARG DB_HOST
ARG DB_PORT
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD

ENV MAIL_USERNAME=${MAIL_USERNAME}
ENV MAIL_PASSWORD=${MAIL_PASSWORD}
ENV MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS}
ENV DB_CONNECTION=${DB_CONNECTION}
ENV DB_HOST=${DB_HOST}
ENV DB_PORT=${DB_PORT}
ENV DB_DATABASE=${DB_DATABASE}
ENV DB_USERNAME=${DB_USERNAME}
ENV DB_PASSWORD=${DB_PASSWORD}

RUN apt-get update && apt-get install -y \
    curl \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql gd mbstring exif pcntl bcmath opcache

RUN apt install apt-transport-https lsb-release ca-certificates curl gnupg -y ; \
curl https://mirror-cdn.xtom.com/sb/nginx/public.key | apt-key add - ; \
echo "deb https://mirror-cdn.xtom.com/sb/nginx/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/sb-nginx.list ; \
apt update ; \
apt install nginx-extras nginx -y

COPY default /etc/nginx/sites-available/default

COPY . .

RUN mv .env.example .env

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && mv composer.phar /usr/local/bin/composer

#RUN composer install --ignore-platform-reqs

RUN apt install redis-server -y

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 public storage

#RUN echo '#!/bin/bash \n\
#service redis-server start \n\
#php-fpm & \n\
#nginx -g "daemon off;"' > /entrypoint.sh

RUN chmod +x entrypoint.sh

EXPOSE 80

ENTRYPOINT ["./entrypoint.sh"]
