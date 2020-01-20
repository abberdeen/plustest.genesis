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
$table->columns=['ID','Name','Description','Creation datetime','Creator'];
$table->rows=[];
$rows=$_connection->Query("SELECT
                              dcp_id,
                              dcp_name,
                              dcp_description,
                              dcp_creation_datetime,
                              us_name
                            FROM
                              m_discipline
                              LEFT OUTER JOIN xd_users
                                ON dcp_creator_us_id = us_id
                            WHERE dcp_name LIKE '%".$filter."%'
                            ORDER BY dcp_name
                            LIMIT ".$start.",".$itemPerPage.";");
foreach($rows as $row){
    $table->rows[]=[
        'list'=>[
            [
                'value'=>$row['dcp_id'],
            ],
            [
                'value'=>'<a href="'.$router->generate('man_discipline_view',['item'=>$row['dcp_name']]).'">'.$row['dcp_name'].'</a>',
            ],
            [
                'value'=>$row['dcp_description'],
            ],
            [
                'value'=>$row['dcp_creation_datetime'],
            ],
            [
                'value'=>'<a href="'.$router->generate('man_user_view',['item'=>$row['us_name']]).'">'.$row['us_name'].'</a>',
            ],

        ],
        'style'=>'',
    ];
}
$table->cellAlignment='left';
$table->headAlignment='left';
