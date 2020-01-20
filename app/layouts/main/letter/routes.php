<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

$router->addRoutes(
    [
        [
            'method'=>  'GET',
            'route' =>  '/letter/shared',
            'target'=>  ['c' => 'letter','a' => 'main/letter/shared'],
            'name'  =>  'cpl_shared',
            'type'  =>  'form',
        ],

        [
            'method'=>  'POST',
            'route' =>  '/letter/shared/submit',
            'target'=>  ['c' => 'letter','a' => 'main/letter/shared/submit'],
            'name'  =>  'cpl_shared_submit',
            'type'  =>  'form',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/letter/[a:hash]',
            'target'=>  ['c' => 'letter','a' => 'main/letter/view'],
            'name'  =>  'cpl_letter_view',
            'type'  =>  'form',
        ],
    ]
);



