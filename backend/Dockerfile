
FROM php:8.3-apache

# Installer l'extension PHP nécessaire pour MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activer les modules Apache utiles
RUN a2enmod rewrite

# Définir le dossier de travail
WORKDIR /var/www/html

# Exposer le port Apache
EXPOSE 80
