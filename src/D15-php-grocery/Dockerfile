FROM php:8.1-apache

# Install PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite for pretty URLs (if needed)
RUN a2enmod rewrite

# Copy custom Apache config
COPY apache.conf /etc/apache2/sites-available/000-default.conf
