# ORM Core API

[![Build Status](https://travis-ci.org/OpenResourceManager/Core.svg?branch=master)](https://travis-ci.org/OpenResourceManager/Core)

## About

ORM Core is a REST API designed to house institutional data and act as an intermediate between an existing ERP and an array of applications and systems.

##### Advantages
 
* Near real time data propagation:
    * Depending on the existing ERP, data can be sent to the core API on the fly as it receives new and updated data. From there any client applications that reefer to ORM are up to date and any aggregates that need to be sent information are sent data through Redis Channels. 
* Control:
    * The API manager allows you to view API clients. In a large environment this has huge benefits, since it can be very hard to keep track of various flat file feeds.
* Development:
    * The API interface eases the development of home grown programs and applications.
* Security:
    * Fine grained access and permissions can be configured.
    * JWT authentication allows for easy and secure development.
* Feedback:
    * API clients will be provided with detailed feedback which allows for error handling and error reporting on the client side as well as errors being log within ORM itself.

##### Features

* REST API interface - `Implemented`
* API manager front end - `Implemented`
* API manager admin back end - `Implemented`
* API Accounts for different applications - `Implemented`
* Account permissions and access control - `Implemented`
* JWT authentication - `Implemented`
* API rate limit/throttle - `Implemented`
* API event history - `Implemented`
* Log viewer - `Implemented`
* Mobile Phone and Email verification - `Implemented`
* API metrics and statistics - `Implemented`
* API Event broadcast to event manager for 3rd party applications - `Implemented`
* Interactive documentation using OpenAPI fka(Swagger) - `Implemented`

## Documentation

* [API Documentation](https://demo-orm.sage.edu/api/documentation)

## Requirements:

* php >= 5.6
* Redis
* MariaDB/MySQL (tested on MariaDB 10.1)
* [Yarn](https://yarnpkg.com/)
* [composer](https://getcomposer.org/)
* Nginx or Apache (tested on Nginx)

PHP Packages:

* php-pecl-redis
* php-pdo
* php-mysqlnd
* php-mcrypt
* php-mbstring
* php-gd
* php-xml
* php-fpm (Nginx only)

## Install

* Step 1: [Install NGINX](https://github.com/MelonSmasher/NginxInstaller)

* Step 2: Install MariaDB

* Step 3: Install Redis

* Step 4: Install NPM

* Step 5: Install Yarn

```
npm -g install yarn
```

* Step 6: Install PHP and extensions

* Step 7: Initialize the DB

```mysql
create database orm;
CREATE USER 'orm'@'localhost' IDENTIFIED BY 'SOMESTRONGPASSWORD';
GRANT ALL PRIVILEGES ON orm.* To 'orm'@'localhost';
FLUSH PRIVILEGES;
```

* Step 8: Initialize ORM

```shell
# change dir the NGINX web root
cd /usr/share/nginx/html/

# Create a vendor dir
mkdir OpenResourceManager/; cd OpenResourceManager;

# Clone Repo
git clone https://github.com/OpenResourceManager/Core.git; cd Core;

# Check out to the latest tag
git checkout $(git describe --tags $(git rev-list --tags --max-count=1));

# Create a new envorinment file
cp .env.example .env;

# Install composer dependancies
composer install --no-interaction --no-scripts --no-dev;

# Install node dependancies
yarn install --prod;

# Generate optimaized class loader
composer dump-autoload -o;

# Generate a new application key
php artisan key:generate;

# Generate a boradcast key
php artisan orm:bckey;

# Generate a new JWT key
bash generate_jwt_key.sh;

# Run DB Migrations
php artisan migrate --force;

# Seed DB With Default Assets
php artisan db:seed --force;

# Clear any compiled assets
php artisan clear-compiled;

# Compile and optomize
php artisan optimize;

# Cache normal routes
php artisan route:cache;

# Cache API routes
php artisan api:cache;
```

* Step 9: Open the `.env` file in your favorite editor and configure it.

 ---
 
## Update

```shell
# Pull the latest code
git pull;

# Check out to the latest tag
git checkout $(git describe --tags $(git rev-list --tags --max-count=1));

# Update composer dependancies
composer update;

# Install/Update node dependancies
yarn install --prod;

# Run DB Migrations
php artisan migrate --force;

# Clear any compiled assets
php artisan clear-compiled;

# Compile and optomize
php artisan optimize;

# Cache normal routes
php artisan route:cache;

# Cache API routes
php artisan api:cache;
```

# Related Software

Some cool projects that this software relies on.

* [Laravel](https://laravel.com)
* [rappasoft/laravel-5-boilerplate](https://github.com/rappasoft/laravel-5-boilerplate)
* [dingo/api](https://github.com/dingo/api)
* [tymon/jwt-auth](https://github.com/tymon/jwt-auth)
* [simplesoftwareio/simple-sms](https://github.com/simplesoftwareio/simple-sms)
* [snowfire/beautymail](https://github.com/snowfire/beautymail)
* [edvinaskrucas/settings](https://github.com/edvinaskrucas/settings)