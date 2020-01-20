<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

use System\Html\Views\TableView;

//Define current page
$page=1;
$itemPerPage=50;
if(isset($_GET['p'])){
    $page=intval($_GET['p']);
    if($page==0) $page=1;
}
$start=($page-1)*$itemPerPage;
//Get filter key
$filter=app::GET('f');


$table= new TableView('','','');
$table->columns=['ID','Name','Active','Task type','Desc','Creation datetime'];
$table->rows=[];
$rows=$_connection->Query("SELECT
                              mat_id,
                              mat_name,
                              mat_active,
                              ttp_name,
                              mat_description,
                              mat_creation_datetime
                            FROM
                              m_material
                              LEFT OUTER JOIN sd_task_type
                                ON mat_ttp_id = ttp_id
                            WHERE mat_name LIKE '%$filter%'
                            ORDER BY mat_name
                            LIMIT $start, $itemPerPage ;");
foreach($rows as $row){
    $table->rows[]=[
        'list'=>[
            [
                'value'=>$row['mat_id'],
            ],
            [
                'value'=>'<a href="'.$router->generate('man_material_view',['item'=>$row['mat_name']]).'">'.$row['mat_name'].'</a>',
            ],
            [
                'value'=>$row['mat_active']?'yes':'no',
            ],
            [
                'value'=>'<a href="'.$router->generate('man_task_type_view',['item'=>$row['ttp_name']]).'">'.$row['ttp_name'].'</a>',
            ],
            [
                'value'=>$row['mat_description'],
            ],
            [
                'value'=>$row['mat_creation_datetime'],
            ],
        ],
        'style'=>'',
    ];
}
$table->cellAlignment='left';
$table->headAlignment='left';




