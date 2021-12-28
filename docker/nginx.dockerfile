#EXAMPLE 2
FROM nginx:stable-alpine

ENV USER=laravel
ENV GROUP=laravel

RUN mkdir -p /var/www/html/public

ADD docker/nginx/default.conf /etc/nginx/conf.d/default.conf
RUN sed -i "s/user www-data/user ${USER}/g" /etc/nginx/nginx.conf
RUN adduser -g ${GROUP} -s /bin/sh -D ${USER}