# Usar una imagen base oficial de PHP con PHP-FPM
FROM php:8.1-fpm

# Establecer el directorio de trabajo
WORKDIR /var/www

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Limpiar el caché de apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar el archivo de configuración de Nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Copiar los archivos de la aplicación al contenedor
COPY . /var/www

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www

# Exponer el puerto 80
EXPOSE 80

# Comando por defecto para iniciar PHP-FPM
CMD ["php-fpm"]
