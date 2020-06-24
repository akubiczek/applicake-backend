Miss Piggy HR - API
==============
System do obsługi rekrutacji w KISS digital - backend.

## Requirements ##
```
imagick ext
ghostscript (gs command)
```


## How to install ##
From command line run:

```
composer install
cp .env.example .env
php artisan migrate
php artisan key:generate
php artisan passport:keys
php artisan passport:client --password
```

## Scripts / helpers

`php artisan tenant:create` - creates new tenant and its database
`php artisan tenant:migrate` - runs migrations for provided tenant or all registered tenants
`php artisan tenant:seeddemodata` - seeds tenant's database with demo data
`php artisan user:create` - creates new admin user for provided tenant

## Running tests ##

## Files structure ##

## Most vital files ##

## Links ##

## API ##

## Test data ##
You can seed database with test recruitments and candidates using `php artisan tenant:seeddemodata` command.

## Tips and tricks ##


## Contributors ##
adam.kubiczek@kissdigital.com
