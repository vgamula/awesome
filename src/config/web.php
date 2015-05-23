<?php

$params = require(__DIR__ . '/params.php');
$modules = require(__DIR__ . '/modules.php');

$config = [
    'id' => 'app',
    'name' => 'Application',
    'language' => 'uk-UA',
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
                'google_oauth' => [
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'nodge\eauth\services\GoogleOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                    'title' => 'Google (OAuth)',
                ],
                'facebook' => [
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'nodge\eauth\services\FacebookOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
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
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
