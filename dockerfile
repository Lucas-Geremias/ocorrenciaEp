FROM php:8.1-apache

# Instalar a extensão mysqli
RUN docker-php-ext-install mysqli

# Copiar arquivos do projeto para o Apache
COPY . /var/www/html/

# Definir permissões
RUN chown -R www-data:www-data /var/www/html

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite