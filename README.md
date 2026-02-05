📦 Quotes Laravel Package

A reusable Laravel package that provides a Quotes UI, designed to be installed into a fresh Laravel 12 application.

🧰 Requirements

Ubuntu 24.10
PHP 8.3
Composer
Node.js & npm
SQLite
Laravel 12.x

🖥️ Local Installation (Manual Setup)
1. Fix Ubuntu 24.10 apt update Issue

Ubuntu 24.10 repositories may move to old releases. Fix it with:

sudo sed -i -re 's/([a-z]{2}\.)?archive.ubuntu.com|security.ubuntu.com/old-releases.ubuntu.com/g' /etc/apt/sources.list{,.d/ubuntu.sources}
sudo apt clean
sudo rm -rf /var/lib/apt/lists/*
sudo apt update

2. Install Apache & PHP 8.3
sudo apt install apache2 -y
sudo systemctl enable apache2
sudo systemctl start apache2

sudo apt install php libapache2-mod-php \
php-mbstring php-xmlrpc php-soap php-gd php-xml \
php-cli php-zip php-bcmath php-tokenizer php-json php-pear -y

sudo apt install php8.3-sqlite3 -y

3. Install Composer
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
sudo php -r "unlink('composer-setup.php');"

4. Install Node.js & npm
sudo apt install nodejs npm -y

5. Create a Fresh Laravel Application
composer create-project laravel/laravel quotes-app
cd quotes-app

php artisan config:clear
php artisan migrate

6. Add the Quotes Package (Path Repository)

- Create the following directory structure:

mkdir -p packages/MyVendor

Copy the package into:

quotes-app/packages/MyVendor/Quotes

- Update the composer.json file of the quotes-app and added the following configuration:
  
"minimum-stability": "dev",
"prefer-stable": true,
"repositories": [
    {
        "type": "path",
        "url": "./packages/MyVendor/Quotes"
    }
],
"require": {
    "my-vendor/quotes": "*"
}

Then run:

composer update

7. Build Package Frontend Assets
cd packages/MyVendor/Quotes
npm install
npm run build

8. Publish Package Assets & Config
php artisan vendor:publish --provider="MyVendor\Quotes\QuotesServiceProvider" --tag=config --force
php artisan vendor:publish --provider="MyVendor\Quotes\QuotesServiceProvider" --tag=assets --force


Clear caches:

php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear

9. Run the Application
php artisan serve


Visit:

http://localhost:8000/quotes-ui


🎉 You should now see the Quotes UI test page.
