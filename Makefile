.PHONY: install backend frontend migrate seed refresh-db test lint js-dev js-build

install: backend frontend

backend:
	composer install

frontend:
	npm install

migrate:
	php artisan migrate

seed:
	php artisan db:seed

refresh-db:
	php artisan migrate:fresh --seed

# Kevin: je garde une commande unique pour lancer les tests et rappeler qu'il faut les dependances installees avant.
test:
	php artisan test

lint:
	npm run lint

js-dev:
	npm run dev

js-build:
	npm run build
