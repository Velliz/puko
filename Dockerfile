# First-stage frontend minify.
FROM node:12-alpine as minify

# Create app directory.
RUN mkdir -p /var/www/html
WORKDIR /var/www/html
COPY . /var/www/html/

# node install.
RUN npm install --quiet

# npm minify.
RUN npm run minify

# Second-stage PHP buid container.
FROM alpine:3.12

# memcached configurations.
ENV MEMCACHED_MEMORY 128
ENV MEMCACHED_MAX_CONNECTIONS 1024
ENV MEMCACHED_MAX_ITEM_SIZE 4M

# install packages.
RUN apk --no-cache add php7 php7-common php7-fpm php7-json php7-openssl php7-mbstring php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-memcached \
    nginx supervisor curl git memcached musl zlib

# configure nginx.
COPY bootstrap/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM.
COPY bootstrap/fpm-pool.conf /etc/php7/php-fpm.d/zzz_custom.conf
COPY bootstrap/php.ini /etc/php7/conf.d/zzz_custom.ini

# Configure supervisord.
COPY bootstrap/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Add application.
RUN mkdir -p /var/www/html
WORKDIR /var/www/html

# retreive from first-stage build.
COPY --from=minify /var/www/html/ /var/www/html/

# Install Composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer install --no-dev --ignore-platform-reqs

# Expose memcached.
EXPOSE 11211

# Expose nginx.
EXPOSE 80 443

# run command from supervisord.
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
