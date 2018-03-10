<?php

namespace app\models;

use yii\db\Query;
use yii\helpers\BaseInflector;

abstract class PlanetOsmGeometry {

    /**
     *
     * @var string таблица с данными о сущности
     */
    protected static $table;
    
    /**
     *
     * @var array Поля с клиента в поля базы
     */
    protected static $fieldMap = [];

    /**
     * 
     * @param array $origin
     * @return array
     */
    public static function getDbFields(array $origin): array {
        $dbFields = [];
        foreach ($origin as $requestField => $value) {
            if (isset(static::$fieldMap[$requestField])) {
                $dbFields[] = static::$fieldMap[$requestField] . ' as ' . $requestField;
            } else {
                $dbFields[] = $requestField;
            }
        }

        return $dbFields;
    }
    
    public static function findAll($fields, $args) {
        $query = new \yii\db\Query();        
        $result = $query->select(
                    self::getDbFields($fields)
                )->from(static::$table)
                ->where($args)
                ->all();

        return $result;
    }

    /**
     * Поиск по тегам
     * @param array $tags
     * @deprecated since version 1.0
     * @return \self[]
     */
    public static function findByTags($tags) {
        $query = new Query();
        $query->select([
                    'osm_id',
                    'name',
                    'amenity',
                    'shop',
                    'craft',
                    'tourism',
                    'office',
                    'leisure',
                ])
                ->from(static::$table);

        $preparedFilter = ['or'];
        foreach ($tags as $tag) {
            $preparedFilter[] = [
                key($tag) => current($tag)
            ];
        }

        $query->andFilterWhere($preparedFilter);

        $result = $query->all();

        $points = [];

        foreach ($result as $element) {
            $point = new static;

            foreach ($element as $key => $value) {
                $camelized = BaseInflector::variablize($key);
                $point->{$camelized} = $value;
            }
            $points[] = $point;
        }
        return $points;
    }

}
