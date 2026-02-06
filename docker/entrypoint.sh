#!/bin/bash
set -e

echo "Creating fresh Laravel project..."
composer create-project laravel/laravel quotes-app --no-interaction

cd quotes-app

echo "Allowing dev stability for local package..."
composer config minimum-stability dev
composer config prefer-stable true

echo "Copying Quotes package..."
mkdir -p packages/MyVendor/Quotes
cp -R /package/* packages/MyVendor/Quotes/
echo "Copying Quote blades page..."
cp -R /package/resources/views/* resources/views/

echo "Registering package path repository..."
composer config repositories.quotes path packages/MyVendor/Quotes

echo "Installing Quotes package..."
composer require my-vendor/quotes:"*" --no-interaction
composer update

echo "Building package frontend assets..."
cd packages/MyVendor/Quotes
npm install
npm run build

#echo "Test using PestPHP..."
#vendor/bin/pest
cd ../../../

echo "Publishing package config & assets..."
php artisan vendor:publish --provider="MyVendor\Quotes\QuotesServiceProvider" --tag=config --force
php artisan vendor:publish --provider="MyVendor\Quotes\QuotesServiceProvider" --tag=assets --force

echo "Running migrations..."
php artisan migrate --force

echo "Clearing caches..."
php artisan optimize:clear

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=8000
