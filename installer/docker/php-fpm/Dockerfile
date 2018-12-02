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
FROM php:5.6-fpm

LABEL maintainer="tianshuo Feng <550610606@qq.com>"

USER root

# 替换国内源
RUN sed -i 's/deb.debian.org/mirrors.ustc.edu.cn/g' /etc/apt/sources.list

RUN apt-get update

RUN apt-get update && apt-get install -y \
libfreetype6-dev \
libjpeg62-turbo-dev \
libpng-dev \
libmcrypt-dev \
&& docker-php-ext-install -j$(nproc) iconv \
&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
&& docker-php-ext-install -j$(nproc) gd pdo_mysql mcrypt

# mongodb
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# redis
RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/3.1.3.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv phpredis-3.1.3 /usr/src/php/ext/redis \
    && docker-php-ext-install redis

# xdebug
RUN pecl install xdebug-2.4.1 \
    && docker-php-ext-enable xdebug

# del install pack
RUN rm -rf /tmp/* /var/tmp/*

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

CMD ["php-fpm"]

EXPOSE 9000
