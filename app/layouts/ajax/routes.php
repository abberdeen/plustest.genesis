<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

$routePrefix='/'.AJAX_DIR_NAME.'/[a:key]';

//key:key; mod:module; fx:function; args: arguments;
$routeSuffix='[a:fx]';

/**
 * Ajax
 */
$router->addRoutes(
    [
        [
            'method'=>  'POST',
            'route' =>  $routePrefix.'/'.$routeSuffix,
            'target'=>  ['c' => 'ajax','a' => ''],//ajax/constructor.php
            'name'  =>  'ajax_post',
            'type'  =>  'ajax',
        ],

        //X-START
        //checking all requests to $routePrefix if not match route ajax_get and ajax_set.
        [
            'method'=>  'POST|GET',
            'route' =>  '/'.AJAX_DIR_NAME,
            'target'=>  ['c' => 'ajax','a' => ''],//ajax/constructor.php
            'name'  =>  'ajax_x1',
            'type'  =>  'ajax',
        ],

        [
            'method'=>  'POST|GET',
            'route' =>  '/'.AJAX_DIR_NAME.'/',
            'target'=>  ['c' => 'ajax','a' => ''],//ajax/constructor.php
            'name'  =>  'ajax_x2',
            'type'  =>  'ajax',
        ],

        [
            'method'=>  'POST|GET',
            'route' =>  '/'.AJAX_DIR_NAME.'/[*:x]',
            'target'=>  ['c' => 'ajax','a' => ''],//ajax/constructor.php
            'name'  =>  'ajax_x3',
            'type'  =>  'ajax',
        ]
        //X-END
    ]
);



