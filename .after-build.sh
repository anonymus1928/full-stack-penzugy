#!/bin/bash

echo "### Run migration ###"
php artisan migrate:fresh --force
echo "### Generate Passport client ###"
php artisan passport:install