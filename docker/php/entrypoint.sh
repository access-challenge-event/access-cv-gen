#!/bin/bash
set -e

# Install Composer dependencies if autoload is missing (handles volume mount and partial installs)
if [ ! -f /var/www/html/vendor/autoload.php ]; then
    composer install --no-dev --no-interaction --optimize-autoloader --working-dir=/var/www/html
fi

exec "$@"
