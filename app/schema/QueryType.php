<?php

namespace app\schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use app\models\PlanetOsmPoint;
use app\models\PlanetOsmLine;
use GraphQL\Type\Definition\ResolveInfo;

class QueryType extends ObjectType {

    public function __construct() {
        $config = [
            'fields' => function() {
                return [
                    'point' => [
                        'type' => Types::listOf(Types::point()),
                        // добавим сюда аргументов, дабы
                        // выбрать необходимого нам юзера
                        'args' => [
                            // чтобы агрумент сделать обязательным
                            // применим модификатор Type::nonNull()
                            'name' => Type::string(),
                            'leisure' => Type::string(),
                        ],
                        'resolve' => function($value, $args, $context, ResolveInfo $info) {
                            $fields = $info->getFieldSelection();
                            return PlanetOsmPoint::findAll($fields, $args);
                        }
                    ],
                    'route' => [
                        'type' => Types::listOf(Types::route()),
                        // добавим сюда аргументов, дабы
                        // выбрать необходимого нам юзера
                        'args' => [
                            // чтобы аргумент сделать обязательным
                            // применим модификатор Type::nonNull()
                            'name' => Type::string(),
                            'ref' => Type::int(),
                        ],
                        'resolve' => function($value, $args, $context, ResolveInfo $info) {
                            $fields = $info->getFieldSelection();
                            return PlanetOsmLine::findAll($fields, $args);
                        }
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }

}
