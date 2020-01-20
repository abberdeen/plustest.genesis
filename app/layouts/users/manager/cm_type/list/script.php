<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}




use System\Html\Views\TableView;
use System\Html\Views\ButtonView;

$table= new TableView('','','');
$table->columns=['ID','Name','Datetime','Creator'];
$table->rows=[];
$rows=$_connection->Query("SELECT
                              cm_id,
                              cm_name,
                              cm_creation_datetime,
                              us_name
                            FROM
                              c_cm_type
                              LEFT OUTER JOIN xd_users
                                ON cm_creator_us_id = us_id;");
foreach($rows as $row){
    $table->rows[]=[
        'list'=>[
            [
                'value'=>$row['cm_id'],
            ],
            [
                'value'=>'<a href="'.$router->generate('man_cm_type_item',['item'=>$row['cm_name']]).'">'.$row['cm_name'].'</a>',
            ],
            [
                'value'=>$row['cm_creation_datetime'],
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
$btnAddItem->link=$router->generate('man_cm_type_add');
$btnAddItem->setText('btnAddItem');


