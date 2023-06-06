FROM php:7.4.32-fpm-alpine

RUN apk --update --no-cache add \
    icu-dev \
    gettext \
    gettext-dev \
    git && apk upgrade

RUN mkdir -p /var/www/io

WORKDIR /var/www/io

RUN sed -i "s/user = www-data/user = root/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = root/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

#RUN docker-php-ext-install pdo pdo_mysql intl
RUN docker-php-ext-install  gettext
RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gettext \
    && docker-php-ext-install \
    pdo  \
    pdo_mysql \
    intl \
    gettext \
    bcmath

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.10

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
