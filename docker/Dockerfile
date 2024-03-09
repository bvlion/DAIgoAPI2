FROM php:8.2-apache

RUN apt-get update && apt-get install -y libzip-dev libmecab-dev mecab mecab-ipadic-utf8

COPY php-base.ini $PHP_INI_DIR/conf.d/

COPY httpd-base.conf /etc/apache2/sites-available/slim.conf
RUN a2dissite 000-default.conf && a2ensite slim.conf && a2enmod rewrite