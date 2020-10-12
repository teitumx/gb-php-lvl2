<?php

use app\repositories\GoodRepository;

return [
    'projectName' => 'My Shop',
    'defaultController' => 'good',
    'components' => [
        'db' => [
            'class' => \app\services\DB::class,
            'config' => [
                'driver' => 'mysql',
                'host' => 'localhost:8889',
                'dbname' => 'gbphp',
                'charset' => 'UTF8',
                'login' => 'root',
                'password' => 'root'
            ]
        ],
        'renderer' => [
            'class' => \app\services\RenderTwigServices::class,
        ],
        'request' => [
            'class' => \app\services\Request::class,
        ],
        'goodRepository' => [
            'class' => \app\repositories\GoodRepository::class,
        ],
        'userRepository' => [
            'class' => \app\repositories\UserRepository::class,
        ],
        'cartServices' => [
            'class' => \app\services\CartServices::class,
        ],
        'authRepository' => [
            'class' => \app\repositories\AuthRepository::class,
        ],
        'userService' => [
            'class' => \app\services\UserService::class,
        ],

    ]
];
