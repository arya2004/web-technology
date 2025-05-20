FROM php:8.1-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Enable mod_rewrite for pretty URLs (optional)
RUN a2enmod rewrite

# Copy custom Apache config
COPY apache.conf /etc/apache2/sites-available/000-default.conf
