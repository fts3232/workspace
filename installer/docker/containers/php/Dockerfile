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
FROM phpswoole/swoole

LABEL maintainer="tianshuo Feng <550610606@qq.com>"

USER root

# 替换国内源

RUN \
    pecl update-channels        \
    && pecl install redis
    && docker-php-ext-enable redis \
    && docker-php-ext-install pcntl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && pecl install xdebug-2.4.1 \
    && docker-php-ext-enable xdebug

RUN apt-get update && apt-get install -y \
libfreetype6-dev \
libjpeg62-turbo-dev \
libpng-dev \
libmcrypt-dev \
&& docker-php-ext-install -j$(nproc) iconv \
&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
&& docker-php-ext-install -j$(nproc) gd pdo_mysql mcrypt



# del install pack
RUN rm -rf /tmp/* /var/tmp/*

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

CMD ["php-fpm"]

EXPOSE 9000
