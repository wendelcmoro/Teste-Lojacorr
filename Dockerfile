FROM php:8.2.0

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Install composer && run composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents

COPY . /var/www


# Copy existing application directory permissions
ARG HOST_USER
RUN chown -R ${HOST_USER}:${HOST_USER} /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Change current user to host user
USER ${HOST_USER}

# Expose port 8000
EXPOSE 8000

# Start PHP-FPM server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
