<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

use System\Html\Views\SidebarView;
use System\Html\Views\FormViewStyle;

$sidebarItems=[
    [
        'text' => 'Саҳифаи асосӣ',
        'link'=>$router->generate('man_home'),
        'active'=>false,
        'subitems' =>
            [

            ]
    ],
    [
        'text' => 'Имтиҳонот',
        'link'=>$router->generate('man_assessment_items'),
        'active'=>false,
        'subitems' =>
            [

            ]
    ],
    [
        'text' => app::icon('icon8/Finance/purchase_order-48.png').'Сиёсати имтиҳонот',
        'link'=>$router->generate('man_policy_items'),
        'active'=>false,
        'subitems' =>
            [
                [
                    'text' =>app::icon('icon8/Very_Basic/settings-48.png').'Механизми идора',
                    'link' => $router->generate('man_cm_type_items'),
                    'active'=>false
                ],

                [
                    'text' =>app::icon('icon8/User_Interface/horizontal_settings_mixer-48.png').'Конфигурацияҳо',
                    'link' => $router->generate('man_cm_conf_items'),
                    'active'=>false
                ]
            ]
    ],
    [
        'text' => app::icon('icon8/Business/graduation_cap-48.png').'Фанҳо',
        'link'=>$router->generate('man_disciplines'),
        'active'=>false,
        'subitems' =>
            [
                [
                    'text' => app::icon('icon8/Science/courses-48.png').'Маводҳо',
                    'link' => $router->generate('man_materials'),
                    'active'=>false
                ],
            ]
    ],

    [
        'text' => app::icon(' ').'Корбарон',
        'link' => $router->generate('man_users'),
        'active'=>false,
        'subitems' =>
            [
            ]
    ],

    [
        'text' => app::icon('icon8/Programming/administrative_tools-48.png').'Administrative Tools',
        'link'=>$router->generate('man_tools'),
        'active'=>false,
        'subitems' =>
            [

            ]
    ],
];


$sidebar = new SidebarView('igxSidebar','',0,[]);
$sidebar->setItems($sidebarItems);
$sidebar->setViewStyle(FormViewStyle::SIDEBAR_LIST_GROUP);
$sidebar->link=$router->generate($match['name']);
echo $sidebar->render();





