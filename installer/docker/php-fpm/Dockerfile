#
#--------------------------------------------------------------------------
# Image Setup
#--------------------------------------------------------------------------
#
# To edit the 'php-fpm' base Image, visit its repository on Github
#    https://github.com/Laradock/php-fpm
#
# To change its version, see the available Tags on the Docker Hub:
#    https://hub.docker.com/r/laradock/php-fpm/tags/
#
# Note: Base Image name format {image-tag}-{php-version}
#

FROM php:5.6-fpm-alpine

LABEL maintainer="Mahmoud Zalt <mahmoud@zalt.me>"

USER root

RUN echo "https://mirror.tuna.tsinghua.edu.cn/alpine/v3.8/main" >> /etc/apk/repositories

RUN echo "https://mirror.tuna.tsinghua.edu.cn/alpine/v3.8/community" >> /etc/apk/repositories

RUN apk add --no-cache coreutils libpng-dev zlib-dev autoconf gcc make g++ openssl openssl-dev
RUN docker-php-ext-install -j$(nproc) gd

#RUN apk update
# mongodb
RUN pecl install mongodb \
    && ./configure \
    && docker-php-ext-enable mongodb

# redis
RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/3.1.3.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv phpredis-3.1.3 /usr/src/php/ext/redis \
    && docker-php-ext-install redis

# del
RUN apk del coreutils libpng-dev zlib-dev autoconf gcc make g++

CMD ["php-fpm"]

EXPOSE 9000
