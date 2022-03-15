<?php

return [

    'defaults' => [
        'guard' => 'usuarios',
        'passwords' => 'usuarios',
    ],

    'guards' => [

        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'usuarios',
            'hash' => false,
        ],

        'usuarios' => [
            'driver' => 'session',
            'provider' => 'usuarios',
        ],
    ],

    'providers' => 
    
    [          
          'usuarios' => [
            'driver' => 'eloquent',
            'model' => App\Models\UserCustomModel::class,
        ],

       
    ],


    'passwords' => [
        
        'usuarios' => [
            'provider' => 'usuarios',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    'password_timeout' => 10800,

];
