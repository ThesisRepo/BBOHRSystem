web: vendor/bin/heroku-php-apache2 public/
release: php artisan migrate:fresh --seed
worker: php artisan queue:restart && php artisan queue:work database --tries=3
release: php artisan generate:employees
