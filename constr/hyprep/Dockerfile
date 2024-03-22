FROM phpdockerio/php:8.2-fpm

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    php8.2-ctype \
    php8.2-curl \
    php8.2-dom \
    php8.2-fileinfo \
    ### https://php.ru/manual/filter.installation.html
    ### https://www.php.net/manual/ru/hash.installation.php
    php8.2-mbstring \
    ### https://www.php.net/manual/ru/openssl.installation.php
    ### https://www.php.net/manual/ru/pcre.installation.php
    php8.2-pdo \
    php8.2-pgsql \
    php8.2-redis \
    php8.2-tokenizer \
    php8.2-xml \
	php8.2-xdebug\
    php-pear \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY 20-xdebug.ini /etc/php/8.2/fpm/conf.d/20-xdebug.ini
## ADD xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

## RUN pecl install xdebug \
##     && docker-php-ext-enable xdebug

## RUN pecl install xdebug-3.1.2
## RUN docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data

## RUN addgroup -g 1000 -S www && \
##     adduser -u 1000 -S www -G www

## USER www

## COPY --chown=www-data:www-data . /var/www

WORKDIR /var/www

EXPOSE 9000
