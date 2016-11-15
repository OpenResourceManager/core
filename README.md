# SLERP Core API

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
chown -R nginx:nginx .;
```
