FROM php:7.3-fpm

ARG WEB_USER
ARG WEB_GROUP
ARG WEB_ROOT_DIR

RUN apt-get update -y
RUN apt-get install -y libmemcached11 libmemcachedutil2 build-essential libmemcached-dev libz-dev libpng-dev
RUN apt-get install -y libgmp-dev libmagickwand-dev --no-install-recommends

RUN pecl install memcached-3.1.5
RUN pecl install imagick
RUN pecl install redis
RUN echo 'extension=memcached.so' >> ${WEB_ROOT_DIR}/conf.d/memcached.ini
RUN echo 'extension=imagick.so' >> ${WEB_ROOT_DIR}/conf.d/imagick.ini
RUN echo 'extension=redis.so' >> ${WEB_ROOT_DIR}/conf.d/redis.ini

RUN docker-php-ext-configure gd --with-png-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-freetype-dir=/usr/include/
RUN docker-php-ext-install calendar bcmath exif gd gettext
RUN docker-php-ext-install mysqli pdo pdo_mysql soap
