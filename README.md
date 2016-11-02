# Universal User Data Api

## Built with security in mind:

The UUD API is built around a model that requires applications to have a API access key, before they can access any data.

The API key also has a boolean value that determines if the application can write data to the API, otherwise it will have read only access.

## API Docs

Check out the [API documentation](https://databridge.sage.edu/docs/).

## Install

```
composer install;
php artisan key:generate
php artisan jwt:generate
```

## Updating

```
git pull;
git checkout $(git describe --tags $(git rev-list --tags --max-count=1));
composer install;
composer update;
composer dump-autoload -o;
php artisan migrate --force;
chown -R nginx:nginx .;
```
