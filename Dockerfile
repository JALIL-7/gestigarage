FROM php:8.2-apache

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl

# Installer Node.js et NPM (requis pour Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Activer le module Apache mod_rewrite
RUN a2enmod rewrite

# Definir la racine d'Apache sur le dossier public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installer les extensions PHP (y compris pdo_pgsql pour Supabase)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql pdo_pgsql zip gd bcmath

# Obtenir Composer (le gestionnaire de paquet PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier tout le code du projet dans le conteneur
COPY . .

# Installer les dépendances PHP
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader

# Installer les dépendances JS et construire les assets Vite
RUN npm install
RUN npm run build

# Ajuster les permissions pour que Laravel puisse écrire dans ses dossiers
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ajouter un script de démarrage personnalisé
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Définir la commande de lancement (qui configurera le port injecté par Render)
CMD ["/usr/local/bin/start.sh"]
