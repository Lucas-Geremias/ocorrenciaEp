FROM php:8.2-apache

# Instalar extensões do PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Ativar mod_rewrite se precisar
RUN a2enmod rewrite

# Copiar seus arquivos para o container
COPY . /var/www/html/

EXPOSE 80
