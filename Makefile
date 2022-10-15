console:
	./vendor/bin/psysh

start:
	php artisan serve --host=0.0.0.0 --port=8080

lint:
	composer exec phpcs -- --standard=PSR12 app tests database routes resources
	
lint-fix:
	composer exec phpcbf -- --standard=PSR12 app tests database routes resources

build:
	npm run build
	php artisan optimize
	php artisan migrate --force
	