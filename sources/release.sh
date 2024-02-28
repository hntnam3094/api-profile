#!/bin/sh

cp .env.production .env
php artisan config:cache

composer install --no-interaction &&
php artisan config:cache &&
php artisan route:cache &&
php artisan view:cache &&
php artisan storage:link &&
npm install &&
php artisan migrate &&
php artisan db:seed &&
npm install -q &&
npm run build
