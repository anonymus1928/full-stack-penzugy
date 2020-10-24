#!/bin/bash

touch database/database.sqlite
cp .env.heroku .env
php artisan key:generate --force
php artisan migrate --force
php artisan passport:install