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

# Copie tout le projet dans le répertoire de travail du conteneur
COPY . /var/www/symfony

# Copie uniquement le contenu du répertoire public vers la racine du serveur Apache
RUN cp -r /var/www/symfony/public/* /var/www/html

# Copie le dossier config directement dans /var/www pour que le chemin soit correct
RUN cp -r /var/www/symfony/config /var/www/config

# Crée les répertoires var dans /var/www/symfony et /var/www/html (si nécessaire)
RUN mkdir -p /var/www/symfony/var /var/www/html/var /var/www/src

# Définit le répertoire de travail dans le projet Symfony
WORKDIR /var/www/symfony

# Installe Composer
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# Installe les dépendances PHP avec Composer
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --optimize-autoloader --no-dev

# Crée les sous-répertoires cache et log dans var si nécessaire
RUN mkdir -p /var/www/symfony/var/cache /var/www/symfony/var/log /var/www/html/var

# Définit les permissions pour le dossier cache, logs, vendor, templates, et var
RUN chown -R www-data:www-data /var/www/symfony/var /var/www/symfony/vendor /var/www/symfony/templates /var/www/html/var /var/www/config /var/www/src
RUN chmod -R 775 /var/www/symfony/var /var/www/symfony/vendor /var/www/symfony/templates /var/www/html/var /var/www/config /var/www/src

# Expose le port 80 pour Apache
EXPOSE 80

# Lancement du serveur Apache
CMD ["apache2-foreground"]
