<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}
use System\Html\Views\SidebarView;
use System\Html\Views\FormViewStyle;

$sidebarItems=[
    [
        'text' => 'Getting started',
        'link'=>'xxx',
        'active'=>false,
        'subitems' =>
            [
                [
                    'text' =>'Introduction',
                    'link' => 'www',
                    'active'=>false],
                [
                    'text' =>'Download',
                    'link' => 'www',
                    'active'=>false],
                [
                    'text' =>'Contents',
                    'link' => 'www',
                    'active'=>false]
            ]
    ],
    [
        'text' => 'Getting started',
        'link'=>'xxx',
        'active'=>false,
        'subitems' =>
            [
                [
                    'text' =>'Introduction',
                    'link' => 'www',
                    'active'=>false],
                [
                    'text' =>'Download',
                    'link' => 'www',
                    'active'=>false],
                [
                    'text' =>'Contents',
                    'link' => 'www',
                    'active'=>false]
            ]
    ],
];
$sidebar = new SidebarView('igxSidebar','',0,[]);
$sidebar->setItems($sidebarItems);
$sidebar->setViewStyle(FormViewStyle::SIDEBAR_LIST_GROUP);

//echo $sidebar->render();

UIControls::tokenBox();





