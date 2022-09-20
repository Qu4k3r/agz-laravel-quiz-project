build-and-serve:
	@eval $(ssh-agent); docker run --rm --interactive --tty \
		--volume ${PWD}:/app \
  		--volume ${SSH_AUTH_SOCK}:/ssh-auth.sock \
  		--env SSH_AUTH_SOCK=/ssh-auth.sock \
  		composer:2.3.10 composer install --ignore-platform-reqs --no-scripts && \
	cp .env.example .env && \
  	docker-compose -f ./docker-compose.yaml up --build --remove-orphans

serve:
	@docker-compose -f ./docker-compose.yaml up

run:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "/var/www/artisan $(filter-out $@, $(MAKECMDGOALS))"

help:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "/var/www/artisan doctrine:generate:proxies && composer dump-autoload && chmod -R 777 storage/proxies"

shell:
	@docker-compose -f ./docker-compose.yaml exec api bash

migrations-diff:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "/var/www/artisan doctrine:migrations:diff"

migrate:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "/var/www/artisan doctrine:migrations:migrate"

schema-update:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "/var/www/artisan doctrine:schema:update"

drop-db:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "/var/www/artisan doctrine:schema:drop --force"

all-tests:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "./vendor/bin/phpunit -d memory_limit=-1"

key-generate:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "php artisan key:generate"

composer-install:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "composer install"

composer-update:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "composer update"

composer-dump-autoload:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "composer dump-autoload"

composer-require:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "composer require $(filter-out $@, $(MAKECMDGOALS))"

fix-migration-permissions:
	@docker-compose -f ./docker-compose.yaml exec -T api sh -c "chown -R 1000:1000 database/migrations"
