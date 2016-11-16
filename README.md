# SLERP Core API

[![Build Status](https://travis-ci.org/SLERP-ERP/SLERP_Core.svg?branch=master)](https://travis-ci.org/SLERP-ERP/SLERP_Core)

## About

SLERP is a REST API designed to house ERP data and act as an intermediate between an existing ERP and an array of applications and scripts.

SLERP came about as a way to move away from flat file feeds that were sent from our existing ERP infrastructure to a wide spread array of different applications and scripts.

I
##### Advantages
 
* Near real time data propagation:
    * Depending on the existing ERP, data can be sent to SLERP's API on the fly as it receives new and updated data. From there any client applications that reefer to SLERP are up to date and any aggregates that need to be sent information are sent data through Redis Channels. 
* Control:
    * The API manager allows you to view API clients. In a large environment this has huge benefits, since it can be very hard to keep track of various flat file feeds.
* Development:
    * The API interface eases the development of home grown programs and applications.
* Security:
    * Fine grained access and permissions can be configured.
    * JWT authentication allows for easy and secure development.
* Feedback:
    * SLERP will provide API clients with detailed feedback which allows for error handling and error reporting on the client side as well as erros being log within SLERP itself.

##### Features

* REST API interface - `Implemented`
* API manager front end - `In Development`
* API Accounts for different applications - `Implemented`
* Account permissions and access control - `Implemented`
* JWT authentication - `Implemented`
* API rate limit/throttle - `Implemented`
* API event history - `In Development`
* Log viewer - `Implemented`
* Mobile Phone and Email verification - `In Development`
* API metrics and statistics - `In Development`
* API Event broadcast to event manager for 3rd party applications - `In Development`

## Documentation

* [API Documentation](https://demo-slerp.sage.edu/api/documentation)

## Requirements:

* php >= 5.6
* Redis
* MariaDB/MySQL (tested on MariaDB 10.1)
* [Yarn](https://yarnpkg.com/)
* [composer](https://getcomposer.org/)
* Nginx or Apache (tested on Nginx)

PHP Packages:

* php-redis
* php-pdo
* php-mysqlnd
* php-mcrypt
* php-mbstring
* php-gd
* php-xml
* php-fpm (Nginx only)

## Install

```shell
# Clone Repo
git clone https://github.com/SLERP-ERP/SLERP_Core.git; cd SLERP_Core;

# Check out to the latest tag
git checkout $(git describe --tags $(git rev-list --tags --max-count=1));

# Install composer dependancies
composer install --no-interaction;

# Install node dependancies
yarn install

# Create a new envorinment file
cp .env.example .env;
```

Open the `.env` file in your favorite editor and configure it.


```shell
# Generate a new application key
php artisan key:generate;

# Generate a new JWT key
bash generate_jwt_key.sh;

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

## Update

```shell
# Pull the latest code
git pull;

# Check out to the latest tag
git checkout $(git describe --tags $(git rev-list --tags --max-count=1));

# Update composer dependancies
composer update;

# Install/Update node dependancies
yarn install

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

