FROM php:8.1-fpm

WORKDIR /var/www/html

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

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && mv composer.phar /usr/local/bin/composer

RUN composer install --ignore-platform-reqs

RUN apt install redis-server -y

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 public storage

RUN echo '#!/bin/bash \n\
service redis-server start \n\
php-fpm & \n\
service nginx start \n\
tail -f /dev/null' > /entrypoint.sh

EXPOSE 80

RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
