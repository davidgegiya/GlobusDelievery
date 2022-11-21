FROM php:8.1.0-apache
RUN docker-php-ext-install mysqli pdo_mysql
RUN apt-get update && apt-get install -y libpng-dev
RUN pecl install redis-5.3.7 \
	&& pecl install xdebug-3.1.5 \
	&& docker-php-ext-install gd \
	&& docker-php-ext-enable redis xdebug gd
ADD ./apache_conf/apache2.conf /etc/apache2/sites-available/000-default.conf
ADD ./apache_conf/global.conf /etc/apache2/apache2.conf
ADD ./apache_conf/php.ini /usr/local/etc/php/php.ini-development
ADD ./apache_conf/php.ini /usr/local/etc/php/php.ini-production