# Readme

An updated boilerplates based on rosengate/sigil

## setup
- clone this project
- delete .git folder
- clone .env.example into .env

## running server

```
cd main
composer install
php artisan key:generate
php artisan config:cache
php artisan serve
```

## after that
rename `main` or `vue-project` however you wish