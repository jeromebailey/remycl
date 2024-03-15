FROM nginx:stable-alpine

ADD ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
ADD ./docker/nginx/*.key /etc/ssl/certs/
ADD ./docker/nginx/*.crt /etc/ssl/certs/

RUN mkdir -p /var/www/html
RUN addgroup -g 1002 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel
RUN chown laravel:laravel /var/www/html
