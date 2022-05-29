##################
# Docker compose
##################

build:
	docker-compose -f ./docker/docker-compose.yml build

start:
	docker-compose -f ./docker/docker-compose.yml start

stop:
	docker-compose -f ./docker/docker-compose.yml stop

up:
	docker-compose -f ./docker/docker-compose.yml up -d --remove-orphans

ps:
	docker-compose -f ./docker/docker-compose.yml ps

logs:
	docker-compose -f ./docker/docker-compose.yml logs -f

down:
	docker-compose -f ./docker/docker-compose.yml down -v --rmi=all --remove-orphans


##################
# App
##################

bash:
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bash


##################
# Database
##################
db_create:
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bin/console doctrine:database:create

db_drop:
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bin/console doctrine:database:drop --force

db_migrate:
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bin/console doctrine:migrations:migrate --no-interaction
db_diff:
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bin/console doctrine:migrations:diff --no-interaction