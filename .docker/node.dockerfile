FROM node:15.14-alpine

RUN apk update && apk add g++ make py3-pip && apk upgrade

RUN mkdir -p /var/www/io

WORKDIR /var/www/io
