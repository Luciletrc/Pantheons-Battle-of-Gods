# Utilise une image PHP 8.2 avec Apache
FROM php:8.2-apache

# Installe les extensions PHP requises par Symfony
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    git \
    unzip \
    ca-certificates \
    && docker-php-ext-install intl opcache pdo pdo_mysql pdo_pgsql

# Télécharge le certificat SSL de Render
RUN curl -o /usr/local/share/ca-certificates/render-ca.crt https://www.render.com/docs/databases/ssl

# Met à jour les certificats CA dans le conteneur
RUN update-ca-certificates

# Active le module Apache rewrite pour gérer les routes Symfony
RUN a2enmod rewrite

# Ajoutez une configuration Apache pour Symfony
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Copie tout le projet dans le répertoire de travail du conteneur
COPY . /var/www/symfony

# Définit le DocumentRoot d'Apache vers le répertoire public de Symfony
RUN sed -i 's|/var/www/html|/var/www/symfony/public|g' /etc/apache2/sites-available/000-default.conf

# Crée les répertoires var dans /var/www/symfony (si nécessaire)
RUN mkdir -p /var/www/symfony/var/cache /var/www/symfony/var/log

# Définit les permissions pour le dossier cache, logs, vendor, et templates
RUN chown -R www-data:www-data /var/www/symfony/var /var/www/symfony/vendor /var/www/symfony/templates
RUN chmod -R 775 /var/www/symfony/var /var/www/symfony/vendor /var/www/symfony/templates

# Expose le port 80 pour Apache
EXPOSE 80

# Lancement du serveur Apache
CMD ["apache2-foreground"]
