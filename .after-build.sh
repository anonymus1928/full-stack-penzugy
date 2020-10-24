#!/bin/bash

echo "### Create database ###"
touch database/database.sqlite
echo "### .env.heroku => .env ###"
cp .env.heroku .env
echo "### Generate application key ###"
php artisan key:generate --force
echo "### Run migration ###"
php artisan migrate --force
echo "### Generate Passport client ###"
php artisan passport:install