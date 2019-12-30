## Install

composer install
cp .env.example .env
php artisan migrate
php artisan key:generate
php artisan passport:keys
php artisan passport:client --password
