#!/bin/bash
set -e

echo "Installing fresh Laravel..."

composer create-project laravel/laravel laravel-app --no-interaction

cd laravel-app

echo "Copying Quotes package..."
mkdir -p packages/MyVendor/Quotes
cp -R /package/* packages/MyVendor/Quotes/

echo "Registering Composer path repository..."

composer config repositories.quotes path packages/MyVendor/Quotes

composer require my-vendor/quotes:"*" --no-interaction

echo "Installing Node dependencies for package..."
cd packages/MyVendor/Quotes
npm install
npm run build
cd ../../../

echo "Publishing package assets..."
php artisan vendor:publish --provider="MyVendor\Quotes\QuotesServiceProvider" --tag=config --force
php artisan vendor:publish --provider="MyVendor\Quotes\QuotesServiceProvider" --tag=assets --force

echo "Migrating database..."
php artisan migrate --force

echo "Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=8000
