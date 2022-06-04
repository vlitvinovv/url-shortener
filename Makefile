##################
# Docker compose
##################
CONTAINER=php-fpm
CONSOLE=bin/console
DC=docker-compose -f ./docker/docker-compose.yml
EXEC=$(DC) exec --user=www-data $(CONTAINER)

build:
	$(DC) build

start:
	$(DC) start

stop:
	$(DC) stop

up:
	$(DC) up -d --remove-orphans

ps:
	$(DC) ps

logs:
	$(DC) logs -f

down:
	$(DC) down -v --rmi=all --remove-orphans


##################
# App
##################

bash:
	$(EXEC) bash


##################
# Database
##################
db_create:
	$(EXEC) $(CONSOLE) doctrine:database:create

db_drop:
	$(EXEC) $(CONSOLE) doctrine:database:drop --force

db_migrate:
	$(EXEC) $(CONSOLE) doctrine:migrations:migrate --no-interaction
db_diff:
	$(EXEC) $(CONSOLE) doctrine:migrations:diff --no-interaction


##################
# Cash
##################
cc:
	$(EXEC) rm -rf var/cache