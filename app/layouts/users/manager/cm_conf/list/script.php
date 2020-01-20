<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}



use System\Html\Views\TableView;
use System\Html\Views\ButtonView;


$table= new TableView('','','');
$table->columns=['ID','Name','Policy','Control mechanism','Creator'];
$table->rows=[];
$rows=$_connection->Query("SELECT
                              cmconf_id,
                              policy_name,
                              cm_name,
                              cmconf_name,
                              us_name
                            FROM
                              c_cm_conf
                              LEFT OUTER JOIN c_policy
                                ON cmconf_policy_id = policy_id
                              LEFT OUTER JOIN c_cm_type
                                ON cmconf_cm_id = cm_id
                              LEFT OUTER JOIN xd_users
                                ON cmconf_creator_us_id = us_id ");
foreach($rows as $row){
    $table->rows[]=[
        'list'=>[
            [
                'value'=>$row['cmconf_id'],
            ],
            [
                'value'=>'<a href="'.$router->generate('man_cm_conf_item',['item'=>$row['cmconf_name']]).'">'.$row['cmconf_name'].'</a>',
            ],
            [
                'value'=>'<a href="'.$router->generate('man_policy_item',['item'=>$row['policy_name']]).'">'.$row['policy_name'].'</a>',
            ],
            [
                'value'=>'<a href="'.$router->generate('man_cm_type_item',['item'=>$row['cm_name']]).'">'.$row['cm_name'].'</a>',
            ],
            [
                'value'=>'<a href="'.$router->generate('man_user_view',['item'=>$row['us_name']]).'">'.$row['us_name'].'</a>',
            ],

        ],
        'style'=>'',
    ];
}
$table->cellAlignment='center';
$table->headAlignment='center';

$btnAddItem=new ButtonView('','','');
$btnAddItem->setSize('small');
$btnAddItem->outline=false;
$btnAddItem->link=$router->generate('man_cm_conf_add');
$btnAddItem->setText('btnAddItem');


