FROM php:8.3-fpm

RUN apt-get update && apt-get install -y zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev libpq-dev g++ git libicu-dev zip libzip-dev npm zip \
    && docker-php-ext-install intl opcache pdo pdo_pgsql pgsql pdo_mysql \
    && docker-php-ext-configure zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
           && docker-php-ext-install gd

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/php.ini-development
RUN ln -s /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
