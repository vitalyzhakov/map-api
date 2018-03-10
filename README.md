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

cron-задания
---------------
Раз в сутки обновлять базу
```
./app/osm/import.sh
```