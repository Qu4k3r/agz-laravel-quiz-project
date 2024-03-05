build-and-serve:
	@docker run --rm --interactive --tty \
		--volume ${PWD}/src:/app \
	composer:2.3.10 composer install --ignore-platform-reqs --no-scripts; \
	docker-compose up --build  --remove-orphans

serve:
	@docker-compose up

shell:
	@docker-compose exec app sh

shell-nginx:
	@docker-compose exec nginx sh

composer-install:
	@docker-compose exec -T app sh -c "composer install; cp .env.example .env"