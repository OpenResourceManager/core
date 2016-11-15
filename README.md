# SLERP Core API

[![Build Status](https://travis-ci.org/SLERP-ERP/SLERP_Core.svg?branch=master)](https://travis-ci.org/SLERP-ERP/SLERP_Core)

## Requirements:

* php >= 5.6
* Redis

## Install

```
composer install --no-interaction;
cp .env.example .env;
php artisan key:generate;
bash generate_jwt_key.sh;
php artisan migrate --force;
```

## Updating

```
git pull;
git checkout $(git describe --tags $(git rev-list --tags --max-count=1));
composer install;
composer update;
composer dump-autoload -o;
php artisan migrate --force;
```

## Documentation

* [API Documentation](https://demo-slerp.sage.edu/api/documentation)

