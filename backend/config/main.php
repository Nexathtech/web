<?php

/**
 * Declares backend application configuration.
 */

$config = [
    'id' => 'kodi-backend',
    'name' => 'KODI',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'kodi\backend\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => '/dashboard/index',
    'modules' => [],
    'components' => [
        // Request handler
        'request' => [
            'class' => \yii\web\Request::class,
            'cookieValidationKey' => getenv('KODI_MODULE_BACKEND_COOKIE_VALIDATION_KEY'),
            'parsers' => [
                // Parse all application/json requests
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => kodi\common\models\user\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['/auth/sign-in'],
            //'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'timeout' => 60 * 60 * 2, // 2 hours
        ],

        // Asset manager
        'assetManager' => [
            'class' => \yii\web\AssetManager::class,
            'linkAssets' => true,
            'bundles' => [
                \yii\bootstrap\BootstrapAsset::class => false,
                \yii\bootstrap\BootstrapPluginAsset::class => false,
            ],
        ],

        // View renderer
        'view' => [
            'class' => \yii\web\View::class,
            'theme' => [
                'class' => \yii\base\Theme::class,
                'basePath' => '@app/themes/admire',
                'baseUrl' => '@web/themes/admire',
                'pathMap' => [
                    '@app/views' => '@app/themes/admire/views',
                    '@app/modules' => '@app/themes/admire/modules',
                ],
            ],
        ],

        // Error handler
        'errorHandler' => [
            'errorAction' => 'dashboard/error',
        ],

        // URL manager
        'urlManager' => [
            'class' => \yii\web\UrlManager::class,
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [],
        ],
    ],

    // Custom params
    'params' => require(__DIR__ . '/params.php'),
];

// Configuration adjustments for 'debug' mode
if (YII_DEBUG) {

    // Enable Debug toolbar
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
        'allowedIPs' => ['*']
    ];
}

return $config;
