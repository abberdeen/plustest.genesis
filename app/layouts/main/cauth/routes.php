<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

/**
 * Auth
 */
$router->addRoutes(
    [
        //REDIRECTS TO auth_login=>/cauth/login

        [
            'method'=>  'GET',
            'route' =>  '/cauth',
            'target'=>  ['c' => 'auth','a' => 'auth_login'],
            'name'  =>  'r_cauth',
            'type'  =>  'redirect',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/cauth/',
            'target'=>  ['c' => 'auth','a' => 'auth_login'],
            'name'  =>  'r_cauth2',
            'type'  =>  'redirect',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/login',
            'target'=>  ['c' => 'auth','a' => 'auth_login'],
            'name'  =>  'r_cauth3',
            'type'  =>  'redirect',
        ],
        ///> END OF REDIRECT TO auth_login=>/cauth/login

        [
            'method'=>  'GET',
            'route' =>  '/cauth/login',
            'target'=>  ['c' => 'auth','a' => 'main/cauth/login'],
            'name'  =>  'auth_login',
            'type'  =>  'form',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/cauth/login?fail',
            'target'=>  ['c' => 'auth','a' => 'main/cauth/login'],
            'name'  =>  'auth_login_fail',
            'type'  =>  'form',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/cauth/login/banned',
            'target'=>  ['c' => 'auth','a' => 'main/cauth/login_ban'],
            'name'  =>  'auth_login_ban',
            'type'  =>  'form',
        ],


        [
            'method'=>  'POST',
            'route' =>  '/cauth/login/check',
            'target'=>  ['c' => 'auth','a' => 'main/cauth/actions/check.php'],
            'name'  =>  'auth_check',
            'type'  =>  'action',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/cauth/saygoodbye',
            'target'=>  ['c' => 'auth','a' => 'main/cauth/actions/exit.php'],
            'name'  =>  'auth_exit',
            'type'  =>  'action',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/bye',
            'target'=>  ['c' => 'auth','a' => 'main/cauth/login'],
            'name'  =>  'goodbye',
            'type'  =>  'form',
        ],

    ]

);



