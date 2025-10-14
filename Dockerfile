# WordPress Dockerfile for Virical Project
FROM wordpress:6.4-php8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install additional PHP extensions and tools
RUN apt-get update && apt-get install -y \
    unzip \
    wget \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Copy WordPress files
COPY wordpress/ /var/www/html/

# Set proper permissions for WordPress
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN chmod 644 wp-config.php

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

