
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/akubiczek/applicake-backend/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/akubiczek/applicake-backend/?branch=develop)
[![Style CI](https://styleci.io/repos/253221576/shield)](https://styleci.io/repos/253221576)

## About Applicake
Applicake is an Applicant Tracking System software written in Laravel and React. It supports multi tenancy and job apply form customization for tenants.

> **Note:** This repository contains API backend of the Applicake. To run the whole system you need to install [panel frontend application](https://github.com/akubiczek/miss-piggy-front)
> and [applying form frontend](https://github.com/akubiczek/i.applicake.to).

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

## Artisan commands
```
php artisan tenant:create         #creates new tenant and its database
php artisan tenant:migrate        #runs migrations for provided tenant or all registered tenants
php artisan tenant:seeddemodata   #seeds tenant's database with demo data
php artisan user:create           #creates new admin user for provided tenant
```

## Test data ##
You can seed database with test recruitments and candidates by running `php artisan tenant:seeddemodata` command.

## License
The Applicake is open-sourced software licensed under the MIT license.

