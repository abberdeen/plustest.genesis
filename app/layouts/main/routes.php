<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

require_once APP_LAYOUT_PATH.'/main/cauth/routes.php';
require_once APP_LAYOUT_PATH.'/main/letter/routes.php';

$router->addRoutes(
    [
        [
            'method'=>  'GET',
            'route' =>  '/',
            'target'=>  ['c' => 'app','a' => 'main/welcome'],
            'name'  =>  'app_welcome',
            'type'  =>  'form',
        ],

        [
            'method'=>  'POST',
            'route' =>  '/app/lang',
            'target'=>  ['c' => 'app','a' => 'main/actions/post_lang.php'],
            'name'  =>  'app_lang',
            'type'  =>  'action',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/app/lang/[a:item]',
            'target'=>  ['c' => 'app','a' => 'main/actions/set_lang.php'],
            'name'  =>  'app_lang_set',
            'type'  =>  'action',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/app/redirect/[*:url]',
            'target'=>  ['c' => 'app','a' => 'main/actions/redirect.php'],
            'name'  =>  'app_redirect',
            'type'  =>  'action',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/app/resources/pg_request_lib.js',
            'target'=>  ['c' => 'app','a' => 'main/actions/pg_request_lib.php'],
            'name'  =>  'app_igx_request_lib',
            'type'  =>  'action',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/app/test',
            'target'=>  ['c' => 'app','a' => 'main/test'],
            'name'  =>  'test',
            'type'  =>  'form',
        ],

    ]
);



