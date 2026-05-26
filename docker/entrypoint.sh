#!/bin/sh
set -e

if [ ! -d "vendor" ]; then
    composer install --no-interaction --prefer-dist
fi

mkdir -p templates_c uploads public/assets/css
chown -R www-data:www-data /var/www/html
chmod -R 777 public/ templates_c/

echo "Ожидание запуска MySQL..."
while ! nc -z db 3306; do echo "База данных еще не готова, ждем 2 секунды..."; sleep 2; done
echo "MySQL успешно запущен!"

if [ -f "database/seeder.php" ]; then
    echo "Запуск сидинга базы данных..."
    php database/seeder.php
fi

exec "$@"
