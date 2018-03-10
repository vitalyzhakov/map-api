<?php

namespace app\models;

use \yii\helpers\BaseInflector;

class PlanetOsmPolygon extends PlanetOsmGeometry {
    
    use traits\OpeningHours;
    use traits\Seasonal;

    public static $table = 'planet_osm_polygon';

    public $osmId;
    public $name;
    public $addrStreet;
    public $addrHousenumber;

    public static function findOne($conditions) {
        $query = new \yii\db\Query();
        $result = $query->select([
                    'osm_id',
                    'name',
                    'opening_hours',
                    'amenity',
                    'shop',
                    'craft',
                    'tourism',
                    'office',
                    'leisure',
                    'addr:street',
                    'addr:housenumber',
                    'building:levels',
                    'seasonal',
                    'phone',
                    'email',
                    'website',
                    'description',
                    'internet_access',
                    'ST_X(ST_TRANSFORM(ST_Centroid(way), 4674)) as long',
                    'ST_Y(ST_TRANSFORM(ST_Centroid(way), 4674)) as lat',
                ])->from(self::$table)
                ->where($conditions)
                ->one();

        if ($result === false) {
            throw new \yii\web\NotFoundHttpException('Страница не найдена');
        }

        $point = new PlanetOsmPolygon();
        $result['lat'] = number_format($result['lat'], 6);
        $result['long'] = number_format($result['long'], 6);

        foreach ($result as $key => $value) {
            $camelized = BaseInflector::variablize($key);
            $point->{$camelized} = $value;
        }

        return $point;
    }

    public static function findByPointId($pointId) {

        $query = new \yii\db\Query();
        $result = $query->select([
                    'osm_id',
                    'name',
                    'addr:street',
                    'addr:housenumber',
                    'shop',
                    'building',
                    'building:levels',
                ])->from(self::$table)
                ->where('ST_contains(way, (SELECT way FROM planet_osm_point WHERE osm_id = :osm_id))', [
                    'osm_id' => $pointId,
                ])
                ->orderBy('building')
                ->one();

        if (!$result) {
            throw new \yii\web\NotFoundHttpException('Точка не найдена');
        }

        $polygon = new PlanetOsmPolygon;

        foreach ($result as $key => $value) {
            $camelized = BaseInflector::variablize($key);
            $polygon->{$camelized} = $value;
        }

        return $polygon;
    }

    /**
     * Поиск полигона по координатам входящей в него точки
     * @param float $lng
     * @param float $lat
     * @return PlanetOsmPolygon
     * @throws \yii\web\NotFoundHttpException
     */
    public static function findByCoordinates($lng, $lat) {

        $query = new \yii\db\Query();
        $result = $query->select([
                    'osm_id',
                    'addr:street',
                    'addr:housenumber',
                    'shop',
                    'building',
                    'building:levels',
                ])->from(PlanetOsmPolygon::$table)
                ->where('ST_contains(
                                way,
                                ST_Transform(
                                    ST_SetSRID(
                                        ST_Point(:lng , :lat), 4326' .
                        '), 900913
                                )
                        ) AND (building:part <> \'\' OR building <> \'\')', [
                    'lng' => $lng,
                    'lat' => $lat,
                ])
                ->orderBy('building')
                ->one();


        if (!$result) {
            throw new \yii\web\NotFoundHttpException;
        }

        $polygon = new PlanetOsmPolygon;

        foreach ($result as $key => $value) {
            $camelized = BaseInflector::variablize($key);
            $polygon->{$camelized} = $value;
        }

        return $polygon;
    }

    public function getAddress() {
        if ($this->addrHousenumber) {
            return $this->addrStreet . ', ' . $this->addrHousenumber;
        } else {
            return $this->addrStreet;
        }

    }
    
    public function getTitle() {
        $title = $this->name;
        if ($this->shop === 'mall') {
            $title = \Yii::t('osm/shop', $this->shop) . ' "' .  $title . '"';
        }
        return $title;
    }

}
