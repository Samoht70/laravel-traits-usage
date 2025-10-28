FROM dunglas/frankenphp

# Installation des extensions PHP nécessaires pour Laravel
RUN install-php-extensions \
	pdo_mysql \
	gd \
	intl \
	zip \
	opcache

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration du répertoire de travail
WORKDIR /app

# Copie des fichiers de dépendances
COPY composer.json composer.lock ./

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copie de l'application
COPY . .

# Permissions pour le stockage et le cache
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Configuration FrankenPHP
ENV SERVER_NAME=:90

EXPOSE 90 443
