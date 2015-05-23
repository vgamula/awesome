<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$modules = require(__DIR__ . '/modules.php');

$modules = array_merge($modules, [
    'gii' => 'yii\gii\Module',
]);
return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => $modules,
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
