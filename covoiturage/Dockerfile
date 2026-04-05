FROM php:8.2-apache

# Installer les dépendances système, Node.js et PostgreSQL (pour Supabase)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
 && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd \
 && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get install -y nodejs \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurer Apache (pointer vers le dossier public de Laravel)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Activer le module de réécriture d'Apache
RUN a2enmod rewrite

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier tous les fichiers du projet
COPY . .

# Installer les dépendances PHP & Node, puis générer les assets
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs
RUN npm install
RUN npm run build

# Donner les bons droits aux dossiers de stockage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port par défaut (Render configure $PORT automatiquement, mais 80 est standard pour apache)
EXPOSE 80

# Script de démarrage pour exécuter les migrations automatiquement
COPY render-start.sh /usr/local/bin/render-start.sh
RUN chmod +x /usr/local/bin/render-start.sh

CMD ["/usr/local/bin/render-start.sh"]
