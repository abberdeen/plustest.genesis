<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}


use System\Html\Views\ButtonView;
use System\Html\Views\FormMsgStyle;
use System\Html\Views\CheckView;
use System\Html\Views\FormViewStyle;
use System\Html\Views\TableView;
use System\Html\Views\ToggleButtonView;


$btn1=new ButtonView('','','');
$btn1->setSize('small');
$btn1->setMessageStyle(FormMsgStyle::WARNING);
$btn1->outline=true;
$btn1->link=$router->generate('man_edit_assessment',['item'=>'123']);
$btn1->setText('3');



$checkBox=new CheckView('checkAll','','');
$checkBox->setViewStyle(FormViewStyle::CHECKBOX_CLASSIC);
$checkBox->setValue('all');

$table= new TableView('','','');
$table->columns=[$checkBox->render(),'ID','Name','Policy','Date','Time','Enabled'];
$table->rows=[];
$rows=$_connection->Query("SELECT
                              ev_id,
                              policy_name,
                              ev_name,
                              ev_description,
                              ev_date,
                              ev_time,
                              ev_enabled,
                              ev_visible
                            FROM
                              `event`
                              LEFT OUTER JOIN c_policy
                                ON ev_pl_id = policy_id ");
foreach($rows as $row){
    $checkBox->setId('');
    $checkBox->setValue($row['ev_id']);
    $checkBox->setClass('checkItem');
    $table->rows[]=[
        'list'=>[
            [
                'value'=>$checkBox->render(),
            ],
            [
                'value'=>$row['ev_id'],
            ],
            [
                'value'=>'<a href="#">'.$row['ev_name'].'</a>',
            ],
            [
                'value'=>'<a href="'.$router->generate('man_policy_item',['item'=>$row['policy_name']]).'">'.$row['policy_name'].'</a>',
            ],
            [
                'value'=>$row['ev_date'],
            ],
            [
                'value'=>$row['ev_time'],
            ],
            [
                'value'=>'<span class="text-'.(($row['ev_enabled']==1)?'primary">Yes':'default">No').'</span>',
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
$btnAddItem->link=$router->generate('man_new_assessment');
$btnAddItem->setText('btnAddItem');

$toggleEnable=new ToggleButtonView();


