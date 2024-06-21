# Usa una imagen base de PHP con las extensiones necesarias
FROM php:8.0-cli

# Instala Node.js y npm
RUN apt-get update && \
    apt-get install -y curl gnupg && \
    curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
    apt-get install -y nodejs

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configura el directorio de trabajo
WORKDIR /app

# Copia el contenido del proyecto al contenedor
COPY . .

# Instala las dependencias de PHP y Node.js
RUN composer install --ignore-platform-reqs && \
    npm install && \
    npm run build

# Configura los permisos y los enlaces simbólicos
RUN chmod 777 -R storage/ bootstrap/cache && \
    php artisan storage:link

# Expone el puerto 8000
EXPOSE 8000

# Comando para iniciar la aplicación
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
