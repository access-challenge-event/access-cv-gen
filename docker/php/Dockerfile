FROM php:8.2-apache

# Enable necessary Apache modules
RUN a2enmod rewrite

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY src/php/ .

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Bootstrap CDN Integration
# To use Bootstrap in your HTML templates, add these lines to your <head>:
# <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
# And before closing </body>:
# <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

# Expose port
EXPOSE 80

CMD ["apache2-foreground"]
