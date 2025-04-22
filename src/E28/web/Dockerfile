FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo-mysql

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80