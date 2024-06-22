# Utiliza una imagen base de PHP con FPM
FROM php:8.1-fpm

# Instala las dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# Instala las extensiones de PHP necesarias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos de la aplicación al contenedor
COPY . .

# Instala las dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Instala las dependencias de Node.js y construye los activos
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
    apt-get install -y nodejs && \
    npm install && \
    npm run build

# Copia la configuración de Nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Nginx y PHP-FPM
CMD service php8.1-fpm start && nginx -g 'daemon off;'
