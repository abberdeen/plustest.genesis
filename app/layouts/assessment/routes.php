<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

$router->addRoutes(
    [

        [
            'method'=>  'GET',
            'route' =>  '/assessment/load',
            'target'=>  ['c' => 'assessment','a' =>'assessment/actions/load.php'],
            'name'  =>  'assessment_load',
            'type'  =>  'action',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/assessment',
            'target'=>  ['c' => 'assessment','a' =>'assessment/view'],
            'name'  =>  'assessment_view',
            'type'  =>  'form',
        ],

        [
            'method'=>  'POST',
            'route' =>  '/assessment/action',
            'target'=>  ['c' => 'assessment','a' =>'assessment/view/actions/action.php'],
            'name'  =>  'assessment_action',
            'type'  =>  'action',
        ],

    ]

);



