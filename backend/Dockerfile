
# Utiliser PHP avec Apache
FROM php:8.3-apache

# Installer les extensions nécessaires pour MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activer le module rewrite
RUN a2enmod rewrite

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier les fichiers PHP dans le conteneur
COPY . /var/www/html/

# Donner les permissions de lecture à Apache
RUN chmod -R 755 /var/www/html

# Exposer le port HTTP
EXPOSE 80
