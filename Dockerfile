FROM php:8.1-fpm

# Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.* /var/www/smart_komunitas/

# Setel direktori kerja di dalam container
WORKDIR /var/www/smart_komunitas

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    build-essential \
    libmcrypt-dev \
    git \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libonig-dev \
    libxml2-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    zip \
    libzip-dev \
    curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP yang diperlukan
RUN docker-php-ext-install pdo pdo_mysql gd zip

# Copy file composer dan install dependencies aplikasi Laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN composer install --no-scripts --no-autoloader

# menambahkan user untuk set permission
# 100 adalah groupID (GID) atau userID (UID) bisa diganti sesukamu tapi harus unique
# zaki adalah nama group baru pada groupadd dan zakismac nama user baru pada useradd
RUN groupadd -g 1000 zaki
RUN useradd -u 1000 -ms /bin/bash -g zaki zakismac


# Copy seluruh aplikasi Laravel ke dalam container
COPY . .

COPY --chown=zakismac:zaki . .

# set permission cache
RUN chown -R zakismac:zaki /var/www/smart_komunitas/storage /var/www/smart_komunitas/bootstrap/cache

# Menjalankan perintah Composer
RUN composer dump-autoload --optimize

USER zakismac

# Expose port 80 untuk web server
EXPOSE 8081

# Perintah untuk menjalankan Apache
CMD ["php-fpm"]
