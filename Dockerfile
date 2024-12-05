# Use uma imagem oficial do PHP com extensões necessárias
FROM php:7.4-fpm

# Instalar extensões do PHP e dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar o Composer (diretamente no contêiner)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar o código do aplicativo Laravel para o contêiner
WORKDIR /var/www/html
COPY . .

# Instalar as dependências do Laravel com o Composer
RUN composer install --no-dev --optimize-autoloader

# Permissões corretas para as pastas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expor a porta para o Laravel
EXPOSE 8000

# Comando inicial para o Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
