
# make is a program which build other programs
# primarily intended to help build C/C++ programs, it was adopted
# by backend developers as an easy an portable way to share common commands
# usually no need to learn this syntax, you write it once and then use it

backend-init:
	- cp --no-clobber .env.example .env
	- cp --no-clobber backend/.env.example backend/.env
	docker run --rm \
		-u "$$(id -u):$$(id -g)" \
		-v "$$(pwd)/backend:/app" \
		-w /app \
		laravelsail/php81-composer:latest \
		composer install --ignore-platform-reqs

backend-run: | backend-init
	docker-compose up -d backend

migrate:
	docker-compose exec backend php artisan migrate

migrate-fresh:
	docker-compose exec backend php artisan migrate:fresh

migrate-seed:
	docker-compose exec backend php artisan migrate:fresh --seed

test:
	docker-compose exec backend php artisan test

key-generate:
	docker-compose exec backend php artisan key:generate

tinker:
	docker-compose exec backend php artisan tinker
