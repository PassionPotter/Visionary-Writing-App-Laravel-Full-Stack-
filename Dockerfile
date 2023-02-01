FROM php:7.2-fpm

RUN apt-get update \
    && apt-get install -y \
      git \
      zip \
      curl \
      sudo \
      unzip \
      libicu-dev \
      libbz2-dev \
      libpng-dev \
      libjpeg-dev \
      libmcrypt-dev \
      libreadline-dev \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      g++ \
    && docker-php-ext-install \
      bz2 \
      intl \
      iconv \
      bcmath \
      opcache \
      calendar \
      mbstring \
      pdo_mysql \
      zip  \
      mysqli \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/freetype2 \
      --with-jpeg-dir=/usr/include \
      --with-png-dir=/usr/include \
    && docker-php-ext-install -j$(nproc) gd \
    && apt-get install vim -y \
    && apt-get install supervisor -y \
    && apt-get install -y nginx \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html
WORKDIR /var/www/html

RUN rm /etc/nginx/sites-enabled/default

COPY deploy.conf /etc/nginx/conf.d/default.conf

RUN mv /usr/local/etc/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf.backup
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

RUN usermod -a -G www-data root


RUN chown -R "www-data:www-data" .
RUN chmod -R 0755 .
RUN chmod -R 0777 storage

RUN sed -i 's/128M/-1/g' /usr/local/etc/php/php.ini-production \
    && sed -i 's/128M/-1/g' /usr/local/etc/php/php.ini-development \
    && cp -r /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

COPY php.ini /usr/local/etc/php/conf.d/cpane.ini
COPY run run

RUN chmod +x run

ENTRYPOINT ["./run"]

EXPOSE 80
