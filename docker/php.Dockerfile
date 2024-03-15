
FROM php:fpm-alpine3.19
#FROM php:8.1-rc-fpm-alpine3.16
#FROM php:8.0.10-fpm-alpine3.13
#FROM php:7.4-fpm-alpine3.13

ADD ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
ADD ./docker/php/php.ini "$PHP_INI_DIR/php.ini"
#ADD ./docker/php/opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

RUN addgroup -g 1002 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel
RUN mkdir -p /var/www/html 
RUN chown laravel:laravel /var/www/html
RUN apk update && apk add libxml2-dev && apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg libjpeg-turbo-dev zlib php-soap php-gd php-pdo_mysql php-opcache
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install soap gd pdo_mysql opcache mysqli
#RUN apk add --no-cache php8-soap php8-gd php8-pdo_mysql php8-opcache

COPY src/laravel /etc/crontabs

COPY src/start.sh /var/www/html

RUN chmod +x /var/www/html/start.sh

# Copy composer.lock and composer.json
COPY src/composer.lock src/composer.json /var/www/

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

