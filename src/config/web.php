<?php

$params = require(__DIR__ . '/params.php');
$modules = require(__DIR__ . '/modules.php');

$config = [
    'id' => 'app',
    'name' => 'Application',
    //'language' => 'uk-UA',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'bootstrap' => ['log'],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
                'baseUrl' => '@web',
                'basePath' => '@webroot',
                'path' => 'photos',
                'name' => 'Files'
            ],
        ]
    ],
    'components' => [

        'eauth' => [
            'class' => 'nodge\eauth\EAuth',
            'popup' => true,
            'cache' => false,
            'cacheExpire' => 0,
            'services' => [
                'google' => [
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'nodge\eauth\services\GoogleOAuth2Service',
                    'clientId' => '723383549848-a2988ciq9d1jsie29v79seui32trsbko.apps.googleusercontent.com',
                    'clientSecret' => 'm7HHgfCVZ9Uk1HYqUVv5Jog2',
                    'title' => 'Google (OAuth)',
                ],
                'facebook' => [
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'nodge\eauth\services\FacebookOAuth2Service',
                    'clientId' => '1838151016410078',
                    'clientSecret' => 'e25d510672c8a1acff94d42569f1ec5a',
                ],
                'twitter' => [
                    // register your app here: https://dev.twitter.com/apps/new
                    'class' => 'nodge\eauth\services\TwitterOAuth1Service',
                    'key' => 'tZ3MaR9dlwD4S8iXIrM7zdvtd',
                    'secret' => 'j6SK0NzqTvOjvlqTFtheIGDezsnJQY3xZu4nPOUASWCDnFGC0i',
                ]
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'wbraganca\fancytree\FancytreeAsset' => [
                    'skin' => 'dist/skin-bootstrap/ui.fancytree',
                ],
            ],
        ],
        'formatter' => [
            'class' => 'app\components\Formatter',
            'datetimeFormat' => 'd.M.Y H:m',
        ],
        'request' => [
            'cookieValidationKey' => 'RiAveGUdUACvWZppHVevMJRGd5Rij8uh',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => YII_ENV_DEV,
        ],
        'i18n' => [
            'translations' => [
                '*' => ['class' => 'yii\i18n\PhpMessageSource'],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'settings' => [
            'class' => 'pheme\settings\components\Settings'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login/<service:google|facebook|twitter>' => 'site/login',
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'cart' => [
            'class' => 'yz\shoppingcart\ShoppingCart',
            'cartId' => 'plush_cart',
        ]
    ],
    'modules' => $modules,
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
