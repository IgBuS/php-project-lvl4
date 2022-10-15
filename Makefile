console:
	./vendor/bin/psysh

start:
	php artisan serve

lint:
	composer exec phpcs -- --standard=PSR12 app tests database routes resources
	
lint-fix:
	composer exec phpcbf -- --standard=PSR12 app tests database routes resources

build:
	npm run build
	php artisan optimize
	php artisan migrate --force
	php artisan serve