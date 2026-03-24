<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',

            // tempo que o link funciona (em minutos)
            'expire' => 60,

            // tempo entre tentativas de envio
            'throttle' => 60,
        ],
    ],

    // tempo de confirmação de senha (não interfere no reset)
    'password_timeout' => 10800,

];