Miss Piggy HR - API
==============
System do obsługi rekrutacji w KISS digital - backend.

## Requirements ##

## How to install ##
From command line run:

```composer install
cp .env.example .env
php artisan migrate
php artisan key:generate
php artisan passport:keys
php artisan passport:client --password
php artisan tenants:migrate
```

## Scripts / helpers

## Running tests ##

## Files structure ##

## Most vital files ##

## Links ##

## API ##

## Test data ##
You can seed database with test recruitments and candiates using `php artisan tenant:seedtestdata` command.

## Tips and tricks ##


## Contributors ##
adam.kubiczek@kissdigital.com
