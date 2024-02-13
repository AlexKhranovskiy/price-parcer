FROM php:8.1.2-apache

COPY ./ /var/www/html
COPY ./.docker/php-apache/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update

RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite

RUN apt-get update && apt-get -y --no-install-recommends install git \
    ssmtp
RUN curl -sS https://getcomposer.org/installer | \
php -- --install-dir=/usr/local/bin --filename=composer

COPY ./.docker/ssmtp/ssmtp.conf /etc/ssmtp/ssmtp.conf
COPY ./.docker/ssmtp/revaliases /etc/ssmtp/revaliases

COPY ./.docker/scheduler/entrypoint.sh /opt/bin/entrypoint.sh
RUN chmod +x /opt/bin/entrypoint.sh
CMD ["/opt/bin/entrypoint.sh"]