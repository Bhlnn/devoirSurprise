
# Utiliser une image légère de Nginx
FROM nginx:alpine

# Copier la page HTML dans le dossier public de Nginx
COPY index.html /usr/share/nginx/html/index.html

# Autoriser Nginx à lire le fichier
RUN chmod 644 /usr/share/nginx/html/index.html

# Exposer le port HTTP
EXPOSE 80
