<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$cookie_validation_key = file_exists(__DIR__ . '/web_data.php') ? require __DIR__ . '/web_data.php' : 'sotsapi2019';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'permit' => [
            'class' => 'app\modules\db_rbac\Yii2DbRbac',
            'params' => [
                'userClass' => 'app\models\User',
                'accessRoles' => ['admin'],
            ]
            //'layout' => '//admin'
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $cookie_validation_key,
        ],
        'rbac' => [
            'class' => 'app\components\RbacComponent',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
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
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // правила для модулей
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        //создаем папку messages/ для папок языков
        // создаем папки языков ru-RU/ и т.д.
        //создаем в папке файл app.php и  храним переводы в файле
        // задается язык по умолчанию 'language' => 'ru-RU' см. выше
        'i18n' => [
            'translations' => [
                'class' => \yii\i18n\PhpMessageSource::class,
                'fileMap' => [
                    'app' => 'app.php',
                    'app/error' => 'error.php',
                ]
            ]

        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'], // ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],// ['127.0.0.1', '::1'],
    ];
}

return $config;
