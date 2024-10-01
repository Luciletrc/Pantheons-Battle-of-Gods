# Utilise une image PHP 8.2 avec Apache
FROM php:8.2-apache

# Installe les extensions PHP requises par Symfony
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    git \
    unzip \
    && docker-php-ext-install intl opcache pdo pdo_mysql pdo_pgsql

# Active le module Apache rewrite pour gérer les routes Symfony
RUN a2enmod rewrite

# Ajoutez une configuration Apache pour Symfony
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Copie uniquement le répertoire public vers la racine Apache
COPY ./public /var/www/html

# Copie tout le projet dans le conteneur pour accéder aux fichiers de configuration
COPY . /var/www/symfony

# Définit le répertoire de travail dans le projet Symfony
WORKDIR /var/www/symfony

# Installe Composer
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# Crée manuellement le dossier vendor si nécessaire
RUN mkdir -p /var/www/symfony/vendor

# Installe les dépendances PHP avec Composer
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --optimize-autoloader --no-dev

# Crée le répertoire var/cache et var/logs si nécessaire
RUN mkdir -p /var/www/symfony/var/cache /var/www/symfony/var/log

# Définit les permissions pour le dossier cache, logs et vendor
RUN chown -R www-data:www-data /var/www/symfony/var /var/www/symfony/vendor
RUN chmod -R 775 /var/www/symfony/var /var/www/symfony/vendor

# Expose le port 80 pour Apache
EXPOSE 80

# Lancement du serveur Apache
CMD ["apache2-foreground"]