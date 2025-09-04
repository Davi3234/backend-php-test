FROM --platform=$BUILDPLATFORM php:8.4-apache AS builder

RUN apt-get update && apt-get install -y --no-install-recommends \
  git \
  unzip \
  libpq-dev \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_pgsql

WORKDIR /var/www/html
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
  && rm composer-setup.php

COPY composer.json composer.lock* ./

RUN composer install --no-scripts --no-interaction --prefer-dist

COPY . .

RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
  && a2enconf servername

RUN useradd -s /bin/bash -m vscode \
  && groupadd docker \
  && usermod -aG docker vscode

RUN a2enmod rewrite

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]