
ENV_PATH=./.env
ifneq ("$(wildcard $(ENV_PATH))","")
	 include $(ENV_PATH)
endif

DOCKER_FILE=docker-compose.yml
cnn="$(CONTAINER_PREFIX)_app" # Container name


prepare-env:
	cp -n .env.example .env || true
	php artisan key:generate

install:
	composer install
	npm i
	npm run build


# Docker _____________
up:
	docker compose --file $(DOCKER_FILE) up -d
	docker exec -it $(cnn) chown -R www-data:www-data /var/www

dw:
	docker compose --file $(DOCKER_FILE) down

in:
	docker exec -it $(cnn) bash

b:
	docker-compose --file $(DOCKER_FILE) build

bs:
	docker-compose --file $(DOCKER_FILE) build $(sn)


# DB _____________
mig:
	docker exec $(cnn) php artisan migrate --force

migr:
	docker exec $(cnn) php artisan migrate:rollback

seed:
	docker exec $(cnn) php artisan db:seed --class=$(c)

migrf:
	docker exec $(cnn) php artisan migrate:refresh


clr: # Clear all laravel cashes
	docker exec $(cnn) php artisan cache:clear
	docker exec $(cnn) php artisan config:clear
	docker exec $(cnn) php artisan view:clear
	docker exec $(cnn) php artisan route:clear

run:
	docker exec $(cnn) php artisan $(cmd)
