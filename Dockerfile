FROM moodlehq/moodle-php-apache:8.2


RUN apt-get update && apt-get install -y \
        cron \
        git \
        unzip

# # Enable Apache rewrite (required by Moodle)
# RUN a2enmod rewrite

# Copy Moodle source into container
COPY ./moodle/ /var/www/html/

# Fix file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Add Moodle cron job (runs every minute)
RUN echo "*/1 * * * * www-data /usr/local/bin/php /var/www/html/admin/cli/cron.php > /dev/null 2>&1" \
        > /etc/cron.d/moodle-cron \
    && chmod 0644 /etc/cron.d/moodle-cron \
    && crontab /etc/cron.d/moodle-cron

# Expose Apache port
EXPOSE 80

# Start cron + Apache
CMD ["/bin/sh", "-c", "service cron start && apache2-foreground"]
