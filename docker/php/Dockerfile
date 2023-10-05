FROM php:8.2-fpm

ARG NEWRELIC_KEY
ARG NEWRELIC_APP_NAME

# Update and install dependencies
RUN apt-get update \
	&& apt-get install -y apt-utils wget git curl libicu-dev zlib1g-dev libonig-dev libzip-dev gnupg2 \
	&& docker-php-ext-install intl mbstring zip \
	&& apt-get clean

# Install New Relic
RUN wget -O - https://download.newrelic.com/548C16BF.gpg | apt-key add - \
	&& sh -c 'echo "deb http://apt.newrelic.com/debian/ newrelic non-free" > /etc/apt/sources.list.d/newrelic.list' \
	&& apt-get update && apt-get install -y newrelic-php5 newrelic-daemon

# Modify user
RUN usermod -u 1000 www-data

# Add configuration files
ADD docker/php/conf.d/newrelic.ini /usr/local/etc/php/conf.d/
ADD docker/php/conf.d/60-user.ini /usr/local/etc/php/conf.d/

# Modify New Relic configuration
RUN sed -i \
	-e 's/"REPLACE_WITH_REAL_KEY"/'"$NEWRELIC_KEY"'/' \
	-e 's/newrelic.appname = "PHP Application"/newrelic.appname = '"$NEWRELIC_APP_NAME"'/' \
	-e 's/;newrelic.daemon.app_connect_timeout =.*/newrelic.daemon.app_connect_timeout=20s/' \
	-e 's/;newrelic.daemon.start_timeout =.*/newrelic.daemon.start_timeout=20s/' \
	/usr/local/etc/php/conf.d/newrelic.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/symfony

# Install Symfony dependencies (assuming composer.json and composer.lock are present in the context)
COPY ../../composer.json /var/www/symfony/
RUN composer install --no-scripts --no-autoloader --no-dev

# Optimize Composer autoloader
RUN composer dump-autoload --optimize

# Set the working directory for the CMD
WORKDIR /var/www/symfony/public

# Expose port
EXPOSE 9000

# Command to run
CMD ["php-fpm", "-F"]
