# Variables
DOCKER_COMPOSE = docker compose
APP_CONTAINER = app

# 🐳 Démarrer les conteneurs
up:
	$(DOCKER_COMPOSE) up -d

# 🧱 Stopper les conteneurs
down:
	$(DOCKER_COMPOSE) down

# 🔄 Rebuild complet
build:
	$(DOCKER_COMPOSE) up -d --build

# 🧰 Installer les dépendances Composer
install:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) composer install

# 🔑 Générer la clé Laravel
key:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan key:generate

# 🗃️ Lancer les migrations
migrate:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan migrate

# 🧹 Nettoyer le cache de Laravel
cache-clear:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan optimize:clear

# 🧪 Lancer les tests
test:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan test

# 🧑‍💻 Ouvrir un shell bash dans le conteneur app
shell:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) bash

# 🪄 Lancer les logs Laravel en direct
logs:
	$(DOCKER_COMPOSE) logs -f $(APP_CONTAINER)
