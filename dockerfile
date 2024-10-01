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
# Copie le code source de l'application Symfony
COPY . /var/www/html
# Définit le répertoire de travail
WORKDIR /var/www/html
# Installe Composer
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer
# Installe les dépendances PHP avec Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev
# Définit les permissions pour le dossier cache et log
RUN chown -R www-data:www-data /var/www/html/var
# Expose le port 80 pour Apache
EXPOSE 80
# Lancement du serveur Apache
CMD ["apache2-foreground"]