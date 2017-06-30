<?php
$config = [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    // Path aliases
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    // Application components
    'components' => [
        // Database connection
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => strtr('mysql:host={host};port={port};dbname={database}', [
                '{host}' => getenv('KODI_DB_MYSQL_HOSTNAME'),
                '{port}' => getenv('KODI_DB_MYSQL_PORT'),
                '{database}' => getenv('KODI_DB_MYSQL_DATABASE'),
            ]),
            'username' => getenv('KODI_DB_MYSQL_USERNAME'),
            'password' => getenv('KODI_DB_MYSQL_PASSWORD'),
            'charset' => getenv('KODI_DB_MYSQL_CHARSET'),
            'enableSchemaCache' => !YII_DEBUG,
        ],

        // Caching
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],

        // Internationalization
        'i18n' => [
            'class' => \yii\i18n\I18N::class,
            'translations' => [
                'kodi/common' => [
                    'class' => \yii\i18n\GettextMessageSource::class,
                    'basePath' => '@common/messages',
                    'catalog' => 'common',
                ],
                'kodi/console' => [
                    'class' => \yii\i18n\GettextMessageSource::class,
                    'basePath' => '@common/messages',
                    'catalog' => 'console',
                ],
                'kodi/frontend' => [
                    'class' => \yii\i18n\GettextMessageSource::class,
                    'basePath' => '@common/messages',
                    'catalog' => 'frontend',
                ],
                'kodi/backend' => [
                    'class' => \yii\i18n\GettextMessageSource::class,
                    'basePath' => '@common/messages',
                    'catalog' => 'backend',
                ],
                'kodi/api' => [
                    'class' => \yii\i18n\GettextMessageSource::class,
                    'basePath' => '@common/messages',
                    'catalog' => 'api',
                ],
            ]
        ],
    ],

    // Custom params
    'params' => require(__DIR__ . '/params.php'),
];

// Configuration adjustments for 'local' environment
if (YII_ENV_LOCAL) {
    // Enable Gii code generator
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        'allowedIPs' => ['*']
    ];

    // Local mode logging
    $config['components']['log']['targets'][] = [
        'class' => \yii\log\FileTarget::class,
        'levels' => ['warning', 'error'],
        'except' => ['yii\web\HttpException'],
        'logVars' => ['_GET', '_POST']
    ];
}

return $config;
