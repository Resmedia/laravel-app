# Docker Laravel 

## This is docker environment with laravel in it 

### Inside: 

Image name | Version
------------ | -------------
Nginx | nginx:stable-alpine:latest
PHP-FPM | bitnami/php-fpm:latest
MySql | mysql:5.7.22
Redis | bitnami/redis:latest
PhpMyAdmin | phpmyadmin/phpmyadmin

--------------------------------------------

### RESUME

If you work with Apache on local machine without docker

You need:

PHP 7.3>

MySQL 5.7>

And run

```bash
cp .env.local .env
```

### 1 Go to directory where your sites

RUN
```bash
git git@github.com:Resmedia/laravel-app.git
```

### 2 Add project folder to file sharing of Docker settings 

![img](https://image.prntscr.com/image/C5r_SEtQS5_XaMBe6tDtyQ.png)

### 3 Look to host file and add:

```bash
127.0.0.1 laravel.docker
```


### 4 Start

```bash
cd laravel

cp .env.example .env

# Look for settings in .env
composer update

docker-compose up     // Start with log

# OR
docker-compose up -d  // Start without log

docker-compose down   // Stop all containers
```

### 5 MySqlAdmin

```bash
http://laravel.docker:8080
Login: root
Pass: toor
```
### 6 Migration

```bash
# go in container php
docker exec -it laravel_php /bin/bash

# run migration
php artisan migrate

# if yo need to seed tables
php artisan db:seed
```

### 7 After success install run

```bash
npm install && npm run dev
```

### 8 for view images run in /laravel folder 
```bash
sudo ln -s "$(pwd)/storage/app" public/uploads

# for file manager run

sudo ln -s  "$(pwd)/storage" "$(pwd)/public/storage" 
```

### 9 to make test
```bash
php artisan dusk --verbose

./vendor/bin/phpunit # in folder laravel
```
