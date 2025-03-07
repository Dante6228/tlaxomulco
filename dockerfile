# Usamos la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalamos dependencias para PDO, MySQL y otras extensiones
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql mysqli

# Habilitamos la extensión zip
RUN docker-php-ext-enable zip

# Habilitamos mod_rewrite de Apache para URLs amigables
RUN a2enmod rewrite

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Copiamos el contenido de nuestro proyecto dentro del contenedor
COPY . /var/www/html

# Damos permisos a los archivos para evitar problemas de acceso
RUN chown -R www-data:www-data /var/www/html

# Exponemos el puerto 80 para acceder al servidor
EXPOSE 80
