<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

$router->addRoutes(
    [
        //Article
        [
            'method'=>  'GET',
            'route' =>  '/kb/[a:lang]/',
            'target'=>  ['c' => 'article','a' => 'accessories/knowledge/article/list'],
            'name'  =>  'art_list',
            'type'  =>  'form',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/kb/[a:lang]/[m_space:title]',
            'target'=>  ['c' => 'article','a' => 'accessories/knowledge/article/view'],
            'name'  =>  'art_view',
            'type'  =>  'form',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/kb/[a:lang]/category/[m_space:title]',
            'target'=>  ['c' => 'category','a' => 'accessories/knowledge/article/view'],
            'name'  =>  'cat_view',
            'type'  =>  'form',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/kb/[a:lang]/news/[m_space:title]',
            'target'=>  ['c' => 'news','a' => 'accessories/knowledge/article/view'],
            'name'  =>  'new_view',
            'type'  =>  'form',
        ],
    ]
);



