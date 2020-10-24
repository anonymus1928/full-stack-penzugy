#!/bin/bash

echo "### Run migration ###"
php artisan migrate:fresh --force
echo "### Generate Passport keys ###"
php artisan passport:keys
echo "### Encryption keyst to env variables"
php artisan vendor:publish --tag=passport-config