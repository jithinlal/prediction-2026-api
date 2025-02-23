up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

restart:
	make down
	make up

migrate-fresh: # clear all tables afresh and run a migration
	./vendor/bin/sail artisan migrate:fresh

migrate-seed: # migrate with seeds
	./vendor/bin/sail artisan migrate --seed

fresh-seed:
	make migrate-fresh
	make migrate-seed

clear:
	./vendor/bin/sail artisan config:clear
	./vendor/bin/sail artisan config:cache
	./vendor/bin/sail artisan cache:clear

.PHONY: up down migrate-fresh migrate-seed fresh-seed clear
