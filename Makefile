console:
	./vendor/bin/psysh

install:
	composer install

start:
	php artisan serve --host 0.0.0.0 --port 3000
	
lint:
	composer exec --verbose phpcs -- --standard=PSR12 app database config resources routes tests
	composer exec --verbose phpstan -- --level=8 analyse app database config resources routes tests
	
lint-fix:
	composer exec phpcbf -- --standard=PSR12 app database config resources routes tests

build:
	npm run build
	php artisan optimize
	php artisan migrate --force

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
