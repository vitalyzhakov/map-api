<?php

namespace app\models;

use \yii\helpers\BaseInflector;

class PlanetOsmPoint extends PlanetOsmGeometry {

    use traits\OpeningHours;
    use traits\Seasonal;

    public static $table = 'planet_osm_point';

    public static $fieldMap = [
        'osmId' => 'osm_id',
        'long' => 'ST_X(ST_TRANSFORM(way, 4674))',
        'lat' => 'ST_Y(ST_TRANSFORM(way, 4674))',
    ];

    /**
     *
     * @var int Идентификатор точки
     */
    public $osmId;

    /**
     *
     * @var string заголовок точки
     */
    public $name;

    /**
     *
     * @var string часы работы
     */
    public $openingHours;
    public $amenity;
    public $shop;
    public $craft;
    public $tourism;
    public $office;
    public $leisure;

    /**
     *
     * @var string этаж
     */
    public $level;

    /**
     *
     * @var string номер офиса
     */
    public $addrDoor;

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
                    'level',
                    'addr:door',
                    'seasonal',
                    'phone',
                    'email',
                    'website',
                    'description',
                    'internet_access',
                    'ST_X(ST_TRANSFORM(way, 4674)) as long',
                    'ST_Y(ST_TRANSFORM(way, 4674)) as lat',
                ])->from(self::$table)
                ->where($conditions)
                ->one();

        if ($result === false) {
            throw new \yii\web\NotFoundHttpException('Страница не найдена');
        }

        $point = new PlanetOsmPoint();
        $result['lat'] = number_format($result['lat'], 6);
        $result['long'] = number_format($result['long'], 6);

        foreach ($result as $key => $value) {
            $camelized = BaseInflector::variablize($key);
            $point->{$camelized} = $value;
        }

        return $point;
    }

    /**
     *
     * @param int $polygonId
     * @return \app\models\PlanetOsmPoint[]
     */
    public static function findByPolygonId(int $polygonId) {
        $query = new \yii\db\Query();
        $result = $query->select([
                    'planet_osm_point.osm_id as osm_id',
                    'planet_osm_point.name as name',
                    'planet_osm_point.opening_hours',
                    'planet_osm_point.amenity',
                    'planet_osm_point.shop',
                    'planet_osm_point.craft',
                    'planet_osm_point.tourism',
                    'planet_osm_point.office',
                    'planet_osm_point.leisure',
                    'planet_osm_point.level',
                    'planet_osm_point.addr:door',
                    'planet_osm_point.seasonal',
                    'planet_osm_point.phone',
                    'planet_osm_point.email',
                    'planet_osm_point.website',
                    'planet_osm_point.description',
                    'planet_osm_point.internet_access',
                ])->from([self::$table, PlanetOsmPolygon::$table])
                ->where('planet_osm_polygon.osm_id = :osm_id ' .
                        ' AND ST_Contains (planet_osm_polygon.way, planet_osm_point.way)', [
                    'osm_id' => $polygonId,
                ])
                ->all();

        $points = [];

        foreach ($result as $element) {
            $point = new PlanetOsmPoint();

            foreach ($element as $key => $value) {
                $camelized = BaseInflector::variablize($key);
                $point->{$camelized} = $value;
            }
            $points[] = $point;
        }
        return $points;
    }

    public function getBreadCrumbs() {
        $tags = [
            'amenity',
            'shop',
            'craft',
            'tourism',
            'office',
            'leisure',
        ];

        foreach ($tags as $tag) {

            $value = $this->{$tag};
            if ($value) {
                $bk = Catalog::findBreadcrumbs([$tag => $value]);
                if ($bk) {
                    $title = \Yii::t('osm/' . $tag, $value);
                    $link = '/tag/' . join('/', [$tag, $value]);
                    $bk[$link] = $title;
                    return $bk;
                }
            }
        }
    }

    public function addrSuffix() {
        $suffix = '';
        if ($this->level) {
            $suffix .= $this->level . ' этаж';
        }
        if ($this->addrDoor) {
            $suffix .= ', офис ' . $this->addrDoor;
        }

        return $suffix;
    }

}
