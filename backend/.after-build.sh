#!/bin/bash

echo "### Run migration ###"
php artisan migrate:fresh --force
echo "### Generate Passport client key ###"
php artisan passport:install
echo "### Generate Passport keys ###"
php artisan passport:keys