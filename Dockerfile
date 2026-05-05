FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    curl git unzip libcurl4-openssl-dev

RUN docker-php-ext-install pdo pdo_mysql mysqli curl

RUN a2enmod rewrite

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY ./src /var/www/html

RUN chown -R www-data:www-data /var/www/html