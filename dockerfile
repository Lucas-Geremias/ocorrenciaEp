FROM php:8.1-apache

# Copia os arquivos do projeto para o Apache
COPY . /var/www/html/

# Dá permissão
RUN chown -R www-data:www-data /var/www/html