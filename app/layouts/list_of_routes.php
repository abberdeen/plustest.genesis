<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

require_once APP_LAYOUT_PATH.'/ajax/routes.php';
require_once APP_LAYOUT_PATH.'/main/routes.php';
require_once APP_LAYOUT_PATH.'/users/routes.php';
require_once APP_LAYOUT_PATH.'/assessment/routes.php';
require_once APP_LAYOUT_PATH.'/accessories/knowledge/routes.php';
/**
 * App
 */
$router->addRoutes(
    [

        [
            'method'=>  'GET',
            'route' =>  '/'.APP_PATH.'/',
            'target'=>  ['c' => 'default','a' =>$router->generate('art_view',['lang'=>'tg','title'=>'Project_IGX'])],
            'name'  =>  'appinfo',
            'type'  =>  'redirect_link',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/igx/',
            'target'=>  ['c' => 'default','a' =>$router->generate('art_view',['lang'=>'tg','title'=>'Project_IGX'])],
            'name'  =>  'appinfo2',
            'type'  =>  'redirect_link',
        ],

    ]

);





