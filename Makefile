ifneq (,$(wildcard .env))
include .env
export
endif

.DEFAULT_GOAL := help
.PHONY: help init build up down clean ps logs composer sh psql migrate key-generate encrypt decrypt

help:
	@echo "make init              — create .env from .env.example"
	@echo "make build             — build images"
	@echo "make up                — up containers"
	@echo "make down              — stop and delete containers"
	@echo "make clean             — stop and delete containers with volumes"
	@echo "make ps                — containers status"
	@echo "make logs              — logs from all services"
	@echo "make psql              — psql to postgres"
	@echo "make sh                — php shell"
	@echo "make composer          — install composer dependencies"
	@echo "make migrate           — run database migrations"
	@echo "make key-generate      — generate APP_KEY"
	@echo "make encrypt VALUE=... — encrypt a config parameter"
	@echo "make decrypt VALUE=... — decrypt a config parameter"

init:
	@if [ -f .env ]; then \
		echo ".env already exists, skip..."; \
	else \
		cp .env.example .env; \
		CURRENT_UID=$$(id -u); \
		CURRENT_GID=$$(id -g); \
		sed -i.bak "s/^UID=.*/UID=$$CURRENT_UID/" .env; \
		sed -i.bak "s/^GID=.*/GID=$$CURRENT_GID/" .env; \
		rm -f .env.bak; \
		echo ".env created (UID=$$CURRENT_UID, GID=$$CURRENT_GID)"; \
	fi

build:
	@docker compose build

up:
	@docker compose up -d

down:
	@docker compose down

clean:
	@docker compose down -v

ps:
	@docker compose ps

logs:
	@docker compose logs -f

psql:
	@docker compose exec postgres psql -U $(POSTGRES_USER) -d $(POSTGRES_DB)

sh:
	@docker compose exec php sh

composer:
	@docker compose exec -u www-data -e COMPOSER_CACHE_DIR=/tmp/composer-cache php composer install

migrate:
	@docker compose exec -u www-data php php bin/migrate.php

key-generate:
	@docker compose exec php php bin/config.php key:generate

encrypt:
	@docker compose exec php php bin/config.php encrypt "$(VALUE)"

decrypt:
	@docker compose exec php php bin/config.php decrypt "$(VALUE)"
