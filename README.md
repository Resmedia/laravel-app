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

docker build . -f ./laravel/Dockerfile 

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
```