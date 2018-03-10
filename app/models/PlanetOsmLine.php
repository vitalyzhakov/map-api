<?php

namespace app\models;

class PlanetOsmLine extends PlanetOsmGeometry {
    
    public static $fieldMap = [
        'osmId' => 'osm_id',
        'way' => 'ST_AsGeoJSON(way)',
    ];

    public static $table = 'planet_osm_line';    
}
