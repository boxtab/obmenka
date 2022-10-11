#!/bin/sh

set -e

. ./.env

echo ">>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>>"

# composer install --no-interaction       # --quiet
composer update --no-interaction        # --quiet
composer dump-autoload --no-interaction # --quiet

php artisan optimize:clear
# php artisan optimize

if [ -z "$APP_KEY" ]; then
    echo ">> Your app key is missing, generation..."
    php artisan key:generate
fi

echo ">> Waiting for $DB_CONNECTION to start"
while ! nc -z $DB_HOST $DB_PORT; do
    echo ">> Waiting a second until the database is receiving connections..."
    sleep 1
done
echo ">> $DB_CONNECTION has started"

php artisan config:cache

echo ">> Migrations in progress..."
php artisan migrate
echo ">> Seeds in progress..."
php artisan db:seed

echo ">>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>> >>>>>>>>>>"

exec "$@"
