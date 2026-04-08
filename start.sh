#!/bin/bash

# Remplacer le port 80 d'Apache par la variable $PORT injectée par Render
sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Révéler les packages Laravel (ignoré lors de l'installation Docker)
php artisan package:discover --ansi

# Nettoyer et mettre en cache la configuration pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Lancer la commande de base d'Apache en avant-plan
apache2-foreground
