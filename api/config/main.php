<?php

/**
 * Declares API application configuration.
 */

return [

    // General settings
    'id' => 'kodi-api',
    'name' => getenv('KODI_MODULE_API_NAME'),
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'kodi\api\controllers',

    // Application bootstrap
    'bootstrap' => [
        // Logger component
        'log',

        // Content negotiator
        'contentNegotiator' => [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
                'application/xml' => \yii\web\Response::FORMAT_XML,
                //'text/html' => \yii\web\Response::FORMAT_HTML,
            ],
        ],
    ],

    // Application components
    'components' => [

        // Request handler
        'request' => [
            'class' => \yii\web\Request::class,
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
                //'multipart/form-data' => \yii\web\MultipartFormDataParser::class,
            ]
        ],

        // Response handler
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                }
            },
        ],

        // Web users
        'user' => [
            'identityClass' => \kodi\common\models\user\User::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
        ],

        // URL manager
        'urlManager' => [
            'class' => \yii\web\UrlManager::class,
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['site'],
                    'only' => ['get'],
                    'patterns' => [
                        'POST' => 'waiting-list',
                    ],
                ],
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => 'auth',
                    'pluralize' => false,
                ],
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => 'promo-code',
                    'pluralize' => false,
                    'tokens' => ['{id}' => '<id:\\d+>'],
                    'patterns' => [
                        'GET verify/{id}' => 'verify',
                    ],
                ],
            ],
        ],
    ],

    // Custom params
    'params' => require(__DIR__ . '/params.php'),
];