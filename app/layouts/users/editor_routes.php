<?php

$router->addRoutes(
    [

        [
            'method'=>  'GET',
            'route' =>  '/editor/',
            'target'=>  ['c' => 'editor','a' => 'editor_home'],
            'name'  =>  'editor_base',
            'type'  =>  'redirect',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/editor',
            'target'=>  ['c' => 'editor','a' => 'users/editor/home'],
            'name'  =>  'editor_home',
            'type'  =>  'form',
        ],
    ]
);