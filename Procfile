web: vendor/bin/heroku-php-apache2 public/
release: php artisan migrate:fresh --seed
release: php artisan generate:employees
worker: php artisan queue:restart && php artisan queue:work database --tries=3