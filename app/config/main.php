<?php

$config = [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'bootstrap' => [],
    'controllerNamespace' => 'app\controllers',
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => FALSE,
            'enablePrettyUrl' => TRUE,
        ],
        'i18n' => [
            'translations' => [
                'osm*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'osm/amenity' => 'osm/amenity.php',
                        'osm/shop' => 'osm/shop.php',
                        'osm/catalog' => 'osm/catalog.php',
                        'osm/tourism' => 'osm/tourism.php',
                        'osm/office' => 'osm/office.php',
                        'osm/leisure' => 'osm/leisure.php',
                        'osm/building' => 'osm/building.php',
                        'osm/internet_access' => 'osm/internet_access.php',
                    ],
                ],
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app/view' => 'app/view.php',
                    ]
                ]
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . getenv('POSTGRES_ADDRESS') . ';dbname=' . getenv('POSTGRES_DB'),
            'username' => getenv('POSTGRES_USER'),
            'password' => getenv('POSTGRES_PASSWORD'),
            'charset' => 'utf8',
            'schemaMap' => [
                'pgsql' => [
                    'class' => 'yii\db\pgsql\Schema',
                    'defaultSchema' => 'public', //specify your schema here
                ]
            ],
            'attributes' => [
                PDO::ATTR_PERSISTENT => true,
            ]
        ],
        'request' => [
            'cookieValidationKey' => 'sdfwefsd',
        ],
    ],
];

if (YII_ENV_DEV && !YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*']
    ];
}

if (!YII_ENV_DEV && !YII_ENV_TEST) {
    $config['bootstrap'][] = 'log';
    $config['bootstrap'][] = 'raven';
    $config['components']['log'] = [
        'targets' => [
            [
                'class' => 'e96\sentry\Target',
                'levels' => ['error', 'warning'],
                'dsn' => getenv('SENTRY_DSN'), // Sentry DSN                
            ]
        ],
    ];
    $config['components']['raven'] = [
        'class' => 'e96\sentry\ErrorHandler',
        'dsn' => getenv('SENTRY_DSN'), // Sentry DSN
    ];
}

return $config;
