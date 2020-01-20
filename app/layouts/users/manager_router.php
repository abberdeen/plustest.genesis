<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

$router->addRoutes(
    [


        [
            'method'=>  'GET',
            'route' =>  '/management/general',
            'target'=>  ['c' => 'management','a' => 'users/manager/access_control'],
            'name'  =>  'man_access',
            'type'  =>  'form',
        ],

        [
            'method'=>  'POST',
            'route' =>  '/management/general/response',
            'target'=>  ['c' => 'management','a' => 'users/manager/access_control/actions/check.php'],
            'name'  =>  'man_check_access',
            'type'  =>  'action',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/management/',
            'target'=>  ['c' => 'management','a' => 'man_home'],
            'name'  =>  'man_base',
            'type'  =>  'redirect',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/management',
            'target'=>  ['c' => 'management','a' => 'users/manager/home'],
            'name'  =>  'man_home',
            'type'  =>  'form',
        ],

        // assessments

        [
            'method'=>  'GET',
            'route' =>  '/management/events',
            'target'=>  ['c' => 'management','a' => 'users/manager/assessment/list'],
            'name'  =>  'man_assessment_items',
            'type'  =>  'form',
            'parent'=>  'man_home',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/management/events/new',
            'target'=>  ['c' => 'management','a' => 'users/manager/assessment/add_assessment'],
            'name'  =>  'man_new_assessment',
            'type'  =>  'form',
            'parent'=>  'man_assessment_items',
        ],


        [
            'method'=>  'POST',
            'route' =>  '/management/events/new/save',
            'target'=>  ['c' => 'management','a' => 'users/manager/assessment/add_assessment/actions/save.php'],
            'name'  =>  'man_save_new_assessment',
            'type'  =>  'action',
        ],


        [
            'method'=>  'GET',
            'route' =>  '/management/events/[i:item]/edit',
            'target'=>  ['c' => 'management','a' => 'users/manager/assessment/edit_assessment'],
            'name'  =>  'man_edit_assessment',
            'type'  =>  'form',
            'parent'=>  'man_assessment_items',
        ],

        // policy

        [
            'method'=>  'GET',
            'route' =>  '/management/policies',
            'target'=>  ['c' => 'management','a' => 'users/manager/policy/list'],
            'name'  =>  'man_policy_items',
            'type'  =>  'form',
            'parent'=>  'man_home',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/management/policies/add',
            'target'=>  ['c' => 'management','a' => 'users/manager/policy/add_policy'],
            'name'  =>  'man_policy_add',
            'type'  =>  'form',
            'parent'=>  'man_policy_items',

        ],

        [
            'method'=>  'GET',
            'route' =>  '/management/policies/[m:item]',
            'target'=>  ['c' => 'management','a' => 'users/manager/policy/view'],
            'name'  =>  'man_policy_item',
            'type'  =>  'form',
            'parent'=>  'man_policy_items',
        ],

        //control mechanism type

        [
            'method'=>  'GET',
            'route' =>  '/management/cm_types',
            'target'=>  ['c' => 'management','a' => 'users/manager/cm_type/list'],
            'name'  =>  'man_cm_type_items',
            'type'  =>  'form',
            'parent'=>  'man_home',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/management/cm_type/add',
            'target'=>  ['c' => 'management','a' => 'users/manager/cm_type/add_cm_type'],
            'name'  =>  'man_cm_type_add',
            'type'  =>  'form',
            'parent'=>  'man_cm_type_items',

        ],

        [
            'method'=>  'GET',
            'route' =>  '/management/cm_type/[m:item]',
            'target'=>  ['c' => 'management','a' => 'users/manager/cm_type/view'],
            'name'  =>  'man_cm_type_item',
            'type'  =>  'form',
            'parent'=>  'man_cm_type_items',
        ],

        //control mechanism conf

        [
            'method'=>  'GET',
            'route' =>  '/management/cm_conf',
            'target'=>  ['c' => 'management','a' => 'users/manager/cm_conf/list'],
            'name'  =>  'man_cm_conf_items',
            'type'  =>  'form',
            'parent'=>  'man_home',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/management/cm_conf/add',
            'target'=>  ['c' => 'management','a' => 'users/manager/cm_conf/add_cm_conf'],
            'name'  =>  'man_cm_conf_add',
            'type'  =>  'form',
            'parent'=>  'man_cm_conf_items',

        ],

        [
            'method'=>  'GET',
            'route' =>  '/management/cm_conf/[m:item]',
            'target'=>  ['c' => 'management','a' => 'users/manager/cm_conf/view'],
            'name'  =>  'man_cm_conf_item',
            'type'  =>  'form',
            'parent'=>  'man_cm_conf_items',
        ],

        //control mechanism rule

        [
            'method'=>  'GET',
            'route' =>  '/management/cm_conf/cm_rule/[i:cmrule_id]/edit',
            'target'=>  ['c' => 'management','a' => 'users/manager/cm_rule/edit'],
            'name'  =>  'man_cm_rule_item',
            'type'  =>  'form',
            'parent'=>  'man_cm_conf_item', // man_cm_conf_item
        ],

        [
            'method'=>  'POST',
            'route' =>  '/management/cm_conf/cm_rule/[i:cmrule_id]/edit/save',
            'target'=>  ['c' => 'management','a' => 'users/manager/cm_rule/edit/actions/save_edits.php'],
            'name'  =>  'man_cm_rule_save_edits',
            'type'  =>  'action',
            'parent'=>  '', // man_cm_conf_item
        ],

        //credit

        [
            'method'=>  'GET',
            'route' =>  '/management/credits/[m:item]',
            'target'=>  ['c' => 'management','a' => 'users/manager/credit/view'],
            'name'  =>  'man_credit_item',
            'type'  =>  'form',
            'parent'=>  'man_credit_items',
        ],

        //Form of test,  Task type
        [
            'method'=>  'GET',
            'route' =>  '/management/sd/task_types/[m:item]',
            'target'=>  ['c' => 'management','a' => 'users/manager/sd/task_type/view'],
            'name'  =>  'man_task_type_view',
            'type'  =>  'form',
            'parent'=>  'man_home',
        ],

        //user

        [
            'method'=>  'GET',
            'route' =>  '/management/users',
            'target'=>  ['c' => 'management','a' => 'users/manager/user/list'],
            'name'  =>  'man_users',
            'type'  =>  'form',
            'parent'=>  'man_home',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/management/users/[m:item]',
            'target'=>  ['c' => 'management','a' => 'users/manager/user/view'],
            'name'  =>  'man_user_view',
            'type'  =>  'form',
            'parent'=>  'man_users',
        ],

        //discipline
        [
            'method'=>  'GET',
            'route' =>  '/management/disciplines',
            'target'=>  ['c' => 'management','a' => 'users/manager/discipline/list'],
            'name'  =>  'man_disciplines',
            'type'  =>  'form',
            'parent'=>  'man_home',
        ],

        [
            'method'=>  'GET',
            'route' =>  '/management/disciplines/[m:item]',
            'target'=>  ['c' => 'management','a' => 'users/manager/discipline/view'],
            'name'  =>  'man_discipline_view',
            'type'  =>  'form',
            'parent'=>  'man_disciplines',
        ],

        //material
        [
            'method'=>  'GET',
            'route' =>  '/management/materials',
            'target'=>  ['c' => 'management','a' => 'users/manager/material/list'],
            'name'  =>  'man_materials',
            'type'  =>  'form',
            'parent'=>  'man_home',
        ],
        [
            'method'=>  'GET',
            'route' =>  '/management/material/[m:item]',
            'target'=>  ['c' => 'management','a' => 'users/manager/material/view'],
            'name'  =>  'man_material_view',
            'type'  =>  'form',
            'parent'=>  'man_materials',
        ],

        //Task
        [
            'method'=>  'GET',
            'route' =>  '/management/materials/[m:mat_name]/[m:task_id]',
            'target'=>  ['c' => 'management','a' => 'users/manager/material/task_view'],
            'name'  =>  'man_task_view',
            'type'  =>  'form',
            'parent'=>  'man_material_view',
        ],

        //tools
        [
            'method'=>  'GET',
            'route' =>  '/management/tools',
            'target'=>  ['c' => 'management','a' => 'users/manager/tools/list'],
            'name'  =>  'man_tools',
            'type'  =>  'form',
            'parent'=>  'man_home',
        ],

        // <!-- Static data


        //Static data-->





    ]
);





