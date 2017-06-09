# ORM Core Install

### Requirements:

- php >= 7.0.0
- Redis
- MariaDB/MySQL (tested on MariaDB 10.1)
- [Yarn](https://yarnpkg.com/) -- For development*
- [composer](https://getcomposer.org/)
- NGINX or Apache (tested on NGINX)

PHP Packages:

- php-pecl-redis
- php-pdo
- php-mysqlnd
- php-mcrypt
- php-mbstring
- php-gd
- php-xml
- php-fpm (NGINX only)

### Install:

* Step 1: [Install NGINX](https://github.com/MelonSmasher/NginxInstaller)

* Step 2: Install MariaDB

* Step 3: Install Redis

* Step 4: Install PHP and extensions

* Step 5: Initialize the DB

```mysql
create database orm;
CREATE USER 'orm'@'localhost' IDENTIFIED BY 'SOMESTRONGPASSWORD';
GRANT ALL PRIVILEGES ON orm.* To 'orm'@'localhost';
FLUSH PRIVILEGES;
```

* Step 6: Initialize ORM

```bash
# Create a vendor dir
sudo mkdir /home/nginx; sudo mkdir /usr/share/nginx/html/OpenResourceManager; cd /usr/share/nginx/html/OpenResourceManager;

# Set the right permissions
sudo chown -R nginx:nginx /usr/share/nginx/html/OpenResourceManager; sudo chown -R nginx:nginx /home/nginx;

# Clone Repo
sudo -u nginx git clone https://github.com/OpenResourceManager/Core.git; cd Core;

# Check out to the latest tag
sudo -u nginx git checkout $(git describe --tags $(git rev-list --tags --max-count=1));

# Create a new envorinment file
sudo -u nginx cp .env.example .env;

# Install composer dependancies
sudo -u nginx composer install --no-dev;

# Generate optimaized class loader
sudo -u nginx composer dump-autoload -o;

# Generate a new application key
sudo -u nginx php artisan key:generate;

# Generate a boradcast key
sudo -u nginx php artisan orm:bckey;

# Generate a new JWT key
sudo -u nginx bash generate_jwt_key.sh;

# Run DB Migrations
sudo -u nginx php artisan migrate --force;

# Seed DB With Default Assets
sudo -u nginx php artisan db:seed --force;

# Compile and optomize
sudo -u nginx php artisan optimize;

# Cache normal routes
sudo -u nginx php artisan route:cache;

# Cache API routes
sudo -u nginx php artisan api:cache;
```

* Step 7: Open the `.env` file in your favorite editor and configure it.

```bash
sudo -u nginx vi .env;
```
