vnytve.ru on yii2
===================================

Установка
---------------
* Создать БД `vndb`
* `psql -d vndb -c 'CREATE EXTENSION postgis; CREATE EXTENSION hstore;'`

# Запуск для разработки
```
docker-compose up --build
```
* Порт 9000 - web API
* Порт 9001 - postgres
* Порт 9002 - PGadmin

cron-задания
---------------
Раз в сутки обновлять базу
```
./app/osm/import.sh
```