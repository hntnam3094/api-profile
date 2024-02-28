#!/bin/sh

# Kiểm tra và sao chép .env.production
if [ -f .env.production ]; then
    cp .env.production .env
else
    echo "File .env.production không tồn tại."
    exit 1
fi

# Cache cấu hình Laravel
php artisan config:cache

# Cài đặt composer dependencies
composer install --no-interaction

# Cache lại cấu hình, route và view
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Tạo symbolic link cho storage
php artisan storage:link

# Cài đặt npm dependencies và chạy build
npm install -q
npm run build

# Migrate database và seeding
php artisan migrate --force
php artisan db:seed --force
