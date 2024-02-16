# Sử dụng hình ảnh PHP với FPM
FROM php:8.1-fpm-alpine

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Cài đặt dependencies cần thiết
RUN apk --no-cache add \
        libzip-dev \
        libpng \
        libpng-dev \
        libjpeg-turbo \
        libjpeg-turbo-dev \
        freetype \
        freetype-dev \
        libwebp \
        libwebp-dev \
        zlib \
        zlib-dev \
        libxpm \
        libxpm-dev \
        icu-dev \
        nodejs \
        npm \
        mysql-client

# Cài đặt và cấu hình các extension PHP
RUN docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ \
        --with-webp=/usr/include/ \
    && docker-php-ext-install -j$(nproc) \
        zip \
        gd \
        intl \
        mysqli \
        pdo_mysql

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Sao chép các file ứng dụng
COPY . .
