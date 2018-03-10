<?php

namespace app\models;

use yii\db\Query;

class Catalog extends PlanetOsmGeometry {

    public static $hierarchy = [
        'shop' => [
            ['amenity' => 'marketplace'],
            ['shop' => 'supermarket'],
            ['shop' => 'mall'],
            ['shop' => 'bathroom_furnishing'],
            ['shop' => 'florist'],
            ['shop' => 'carpet'],
            ['shop' => 'furniture'],
            ['shop' => 'computer'],
            ['shop' => 'electronics'],
            ['shop' => 'mobile_phone'],
            ['shop' => 'fishing'],
            ['shop' => 'outdoor'],
            ['shop' => 'convenience'],
            ['shop' => 'jewelry'],
            ['shop' => 'toys'],
            ['shop' => 'clothes'],
            ['shop' => 'mall'],
            ['shop' => 'department_store'],
            ['shop' => 'herbalist'],
            ['shop' => 'wine'],
            ['shop' => 'fabric'],
            ['shop' => 'medical_supply'],
            ['shop' => 'bag'],
            ['shop' => 'doityourself'],
            ['shop' => 'hardware'],
            ['shop' => 'alcohol'],
            ['shop' => 'butcher'],
            ['shop' => 'seafood'],
        ],
        'entertainment' => [
            ['leisure' => 'sports_centre'],
            ['leisure' => 'ice_rink'],
            ['tourism' => 'theme_park'],
            ['shop' => 'toys'],
            ['amenity' => 'nightclub'],
        ],
        'service' => [
            ['amenity' => 'post_office'],
            ['shop' => 'hairdresser'],
            ['shop' => 'car_repair'],
            ['shop' => 'dry_cleaning'],
            ['shop' => 'laundry'],
            ['craft' => 'electrician'],
            ['craft' => 'shoemaker'],
            ['tourism' => 'hotel'],
            ['craft' => 'jeweller'],
            ['office' => 'utility'],
            ['office' => 'estate_agent'],
            ['office' => 'insurance'],
            ['office' => 'telecommunication'],
            ['shop' => 'funeral_directors'],
            ['amenity' => 'taxi'],
            ['office' => 'architect'],            
        ],
        'food' => [
            ['amenity' => 'bar'],
            ['amenity' => 'cafe'],
            ['amenity' => 'fast_food'],
            ['amenity' => 'restaurant'],
        ],
        'education' => [
            ['amenity' => 'school'],
            ['amenity' => 'library'],
            ['amenity' => 'college'],
            ['amenity' => 'kindergarten'],
            ['amenity' => 'community_centre'],
            ['amenity' => 'driving_school'],
        ],
        'auto' => [
            ['amenity' => 'fuel'],
            ['amenity' => 'car_wash'],
            ['amenity' => 'bus_station'],
            ['shop' => 'car_parts'],
            ['shop' => 'car_repair']
        ],
        'finance' => [
            ['amenity' => 'atm'],
            ['amenity' => 'bank']
        ],
        'health' => [
            ['amenity' => 'dentist'],
            ['amenity' => 'doctors'],
            ['amenity' => 'hospital'],
            ['amenity' => 'pharmacy'],
            ['amenity' => 'veterinary'],
            ['amenity' => 'clinic'],
            ['shop' => 'beauty']
        ],
        'social' => [
            ['amenity' => 'studio'],
            ['tourism' => 'museum'],
            ['amenity' => 'police'],
            ['amenity' => 'courthouse'],
            ['office' => 'administrative'],
            ['office' => 'government']
        ]
    ];

    public static function findBreadcrumbs($filter) {
        $breadCrumbs = [];
        foreach (self::$hierarchy as $hKey => $hItem) {
            if (array_search($filter, $hItem) !== false) {
                $breadCrumbs['/catalog/' . $hKey] = \Yii::t('osm/catalog', $hKey);
            }
        }
        return $breadCrumbs;
    }
    
    private static function addCatalogConditions($query) {
        $conditions = [];
        foreach (self::$hierarchy as $category) {
            foreach ($category as $row) {
                $key = key($row);
                $value = current($row);
                if (isset($conditions[$key])) {
                    $conditions[$key][] = $value;
                } else {
                    $conditions[$key] = [$value];
                }
            }
        }
        
        foreach ($conditions as $cKey => $cValues) {
            $query->orWhere(['in', $cKey, $cValues]);
        }
        
        return $query;
    }

    public static function xmlMapPoints() {
        $query = new Query();
        $query->select(['osm_id'])
                ->from(PlanetOsmPoint::$table)
                ->where(['<>', 'name', '']);

        self::addCatalogConditions($query);

        return $query->all();
    }

    /**
     * @return array
     */
    public static function xmlMapPolygons() {
        $query = new Query();
        $query->select([
                    'osm_id',
                ])
                ->from(PlanetOsmPolygon::$table)
                ->where(['<>', 'name', '']);

        self::addCatalogConditions($query);

        return $query->all();
    }

}
