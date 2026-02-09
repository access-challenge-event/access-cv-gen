FROM php:8.2-apache

# Enable necessary Apache modules
RUN a2enmod rewrite
<<<<<<< HEAD
# Allow .htaccess overrides for routing
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
=======
<<<<<<< HEAD
<<<<<<< HEAD
# Allow .htaccess overrides for routing
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
=======
>>>>>>> 2374125 (feat: oauth semi working)
=======
# Allow .htaccess overrides for routing
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
>>>>>>> fe6f1b2 (refactor: routing, autoloading and added basic MVC architecture)
>>>>>>> f22e0eb (refactor: routing, autoloading and added basic MVC architecture)

# Install system dependencies needed by Composer and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY src/php/ .

# Install Composer dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Copy entrypoint script (re-runs composer install when volume mount hides build artifacts)
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

# Expose port
EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
