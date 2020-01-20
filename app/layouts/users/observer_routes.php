<?php

$router->addRoutes(
    [

        [
            'method'=>  'GET',
            'route' =>  '/observe/',
            'target'=>  ['c' => 'observer','a' => 'ob_home'],
            'name'  =>  'ob_base',
            'type'  =>  'redirect',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/observe',
            'target'=>  ['c' => 'observer','a' => 'users/observer/home'],
            'name'  =>  'ob_home',
            'type'  =>  'form',
        ],
    ]
);