<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'                  => 'app-api',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'api\controllers',
    'modules'             => [],
    'components'          => [
        'request'    => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user'       => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession'   => false,
        ],
        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules'               => [
                'auth'                      => 'site/login',
                'registration'              => 'site/registration',
                'verify-email'              => 'site/verify-email',
                'reset-password'            => 'site/reset-password',
                'resend-verification-email' => 'site/resend-verification-email',
                'request-password-reset'    => 'site/request-password-reset',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'post',
                ],
            ],
        ]

    ],
    'params'              => $params,
];
