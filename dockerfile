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

# Active le module Apache rewrite
RUN a2enmod rewrite

# Copie uniquement le répertoire public vers la racine Apache
COPY ./public /var/www/html

# Copie tout le projet dans le conteneur pour pouvoir accéder aux fichiers de configuration
COPY . /var/www/symfony

# Définit le répertoire de travail dans le projet Symfony
WORKDIR /var/www/symfony

# Installe Composer
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# Installe les dépendances PHP avec Composer en tant que superutilisateur
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --optimize-autoloader --no-dev

# Définit les permissions pour le dossier cache et log
RUN chown -R www-data:www-data /var/www/symfony/var
RUN chown -R www-data:www-data /var/www/symfony/vendor
RUN chmod -R 775 /var/www/symfony/var

# Expose le port 80 pour Apache
EXPOSE 80

# Lancement du serveur Apache
CMD ["apache2-foreground"]