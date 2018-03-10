<?php

namespace app\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class RouteType extends ObjectType {

    public function __construct() {
        $config = [
            'fields' => function() {
                return [
                    'osmId' => [
                        'type' => Type::string(),
                        'description' => 'Идентификатор маршрута',
                    ],
                    'name' => [
                        'type' => Type::string(),
                        'description' => 'Название маршрута',
                    ],
                    'ref' => [
                        'type' => Type::string(),
                        'description' => 'Номер маршрута',
                    ],
                    'way' => [
                        'type' => Type::string(),
                        'description' => 'GeoJSON представление линии',
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }

}
