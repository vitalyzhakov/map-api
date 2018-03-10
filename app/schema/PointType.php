<?php

namespace app\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PointType extends ObjectType {

    public function __construct() {
        $config = [
            'fields' => function() {
                return [
                    'osmId' => [
                        'type' => Type::string(),
                        'description' => 'Идентификатор точки',
                    ],
                    'name' => [
                        'type' => Type::string(),
                        'description' => 'Название точки',
                    ],
                    'openingHours' => [
                        'type' => Type::string(),
                        'description' => 'Часы работы',
                    ],
                    'amenity' => [
                        'type' => Type::string(),
                    ],
                    'shop' => [
                        'type' => Type::string(),
                    ],
                    'craft' => [
                        'type' => Type::string(),
                    ],
                    'tourism' => [
                        'type' => Type::string(),
                    ],
                    'office' => [
                        'type' => Type::string(),
                    ],
                    'leisure' => [
                        'type' => Type::string(),
                    ],
                    'level' => [
                        'type' => Type::string(),
                    ],
                    'addrDoor' => [
                        'type' => Type::string(),
                    ],
                    'seasonal' => [
                        'type' => Type::string(),
                    ],
                    'phone' => [
                        'type' => Type::string(),
                    ],
                    'email' => [
                        'type' => Type::string(),
                    ],
                    'website' => [
                        'type' => Type::string(),
                    ],
                    'description' => [
                        'type' => Type::string(),
                    ],
                    'internetAccess' => [
                        'type' => Type::string(),
                    ],
                    'lat' => [
                        'type' => Type::float(),
                    ],
                    'long' => [
                        'type' => Type::float(),
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }

}
