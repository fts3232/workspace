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

ARG LARADOCK_PHP_VERSION

FROM php:5.6.37-fpm-alpine3.7

LABEL maintainer="Mahmoud Zalt <mahmoud@zalt.me>"

RUN sudo pecl install mongo

RUN sudo pecl install mongo

CMD ["php-fpm"]

EXPOSE 9000
