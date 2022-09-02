<p align="center">Sistema para Comercio</p>

## About System
require php7.4-pgsql
## For PHP 7 in Ubuntu you can also do
sudo apt install php-pgsql

Banco de dados postgres;
Porta: 5432;

Api PHP;
Porta: 8080;

Front VueJs;


## start commands

Run Docker:
docker-compose build --force-rm
docker-compose up

## migrations
make db-reset;


## step two
php -S localhost:8080

## run tests
vendor/bin/phpunit --configuration phpunit.xml

