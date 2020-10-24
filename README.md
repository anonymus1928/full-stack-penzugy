# Pénzügy [![Build Status](https://travis-ci.org/anonymus1928/full-stack-penzugy.svg?branch=master)](https://travis-ci.org/anonymus1928/full-stack-penzugy)

**Dokumentáció: https://github.com/anonymus1928/full-stack-penzugy/wiki**

**Deploy: https://fullstack-penzugy.herokuapp.com/**

## Telepítés (lokális futtatáshoz)

1. ```git clone https://github.com/anonymus1928/fullstack-penzugy```
2. ```composer install```
3. ```cp .env.example .env```
4. ```touch database/database.sqlite```
5. ```php artisan generate:key```
6. ```php artisan passport:install```
7. ```php artisan passport:keys```
8. ```php artisan serve```

TODO: telepítő script készítés...