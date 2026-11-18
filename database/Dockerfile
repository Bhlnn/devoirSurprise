FROM mysql:8.4

COPY init.sql /docker-entrypoint-initdb.d/

# Autoriser MySQL à lire le script d'initialisation
RUN chmod 644 /docker-entrypoint-initdb.d/init.sql