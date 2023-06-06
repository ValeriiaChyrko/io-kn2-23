FROM nginx:1.23.1-alpine

RUN apk update && apk upgrade

RUN sed -i "s/user  nginx/user root/g" /etc/nginx/nginx.conf

ADD ./nginx/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/io
