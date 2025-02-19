FROM php:8.3-fpm

ARG USER=laravel
ARG UID=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    zip \
    unzip \
    supervisor \
    cron \
    && rm -rf /var/lib/apt/lists/*

# Configure and install GD properly
RUN docker-php-ext-configure gd \
    --with-jpeg \
    --with-freetype \
    --with-webp

# Install Node.js LTS and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    opcache

# Install additional extensions
RUN pecl install redis && \
    pecl install xdebug && \
    docker-php-ext-enable \
    redis \
    xdebug \
    opcache

# Configure opcache
RUN docker-php-ext-enable opcache \
    && echo 'opcache.memory_consumption=128' >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo 'opcache.interned_strings_buffer=8' >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo 'opcache.max_accelerated_files=4000' >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo 'opcache.revalidate_freq=2' >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo 'opcache.fast_shutdown=1' >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user
RUN useradd -m -G www-data,root -u ${UID} -d /home/${USER} ${USER} && \
    mkdir -p /home/${USER}/.composer && \
    mkdir -p /home/${USER}/.npm && \
    chown -R ${USER}:${USER} /home/${USER}

# Set working directory
WORKDIR /var/www

# Copy PHP configuration
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

USER ${USER}
