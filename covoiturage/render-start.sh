#!/bin/bash

# Lancer les migrations de la base de données (vers Supabase)
echo "Exécution des migrations vers Supabase..."
php artisan migrate --force

# Démarrer le serveur Apache au premier plan
echo "Démarrage du serveur Web..."
apache2-foreground
