<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 


$router->addRoutes(
    [

        [
            'method'=>  'GET',
            'route' =>  '/user/',
            'target'=>  ['c' => 'user','a' => 'user_home'],
            'name'  =>  'user_base',
            'type'  =>  'redirect',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/user/home',
            'target'=>  ['c' => 'user','a' => 'users/user/home'],
            'name'  =>  'user_home',
            'type'  =>  'form',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/user/events',
            'target'=>  ['c' => 'user','a' => 'users/user/events'],
            'name'  =>  'user_events',
            'type'  =>  'form',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/user/draft',
            'target'=>  ['c' => 'user','a' => 'users/user/draft'],
            'name'  =>  'user_draft',
            'type'  =>  'form',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/user/appeal',
            'target'=>  ['c' => 'user','a' => 'users/user/appeal'],
            'name'  =>  'user_appeal',
            'type'  =>  'form',
        ],

    ]
);



