# TolifyHub — Railway PHP hosting
# Apache + PHP 8.2 serves index.php (user panel) and admin.php (admin panel).
# No composer, no build step, no extra dependencies.
FROM php:8.2-apache
COPY . /var/www/html/
EXPOSE 80
