<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}



use System\Html\Views\PaginationView;
use System\Html\Views\TableView;
use Adapter\AdapterGen;
use Adapter\Task\TaskFactory;


$materialName=$match['params']['item'];
$material=AdapterGen::getMaterialByName($_connection,$materialName);

//Define current page
$itemPerPage=app::GET('limit');
if($itemPerPage<=0) $itemPerPage=20;
//
$page=app::GET('page');
if($page==0) $page=1;
$start=($page-1)*$itemPerPage;
//Get filter key
$filter=app::GET('filter');
//
$cols = $material->getSourceFormatQuery()->getColsByTaskType($material->getTaskType());
$rows=$_connection->Query("SELECT COUNT(1) `c` FROM " . $material->getSource()->getPath() . " WHERE `".  $cols->text ."` LIKE '%". $filter ."%'");
$taskCount=$rows[0]["c"];
//
$pageCount=ceil($taskCount/$itemPerPage);
$pagination=(new PaginationView($page,$filter,$pageCount,$itemPerPage))->render();
//List of task
$conditions=$material->getSource()->conditions;

$q="SELECT " . $cols->id . " task_id,
           IFNULL(".$material->getSource()->colRank.", -1) rank,
           IFNULL(".$material->getSource()->colFrequency.", 0) frequency,
           `" . $cols->theme . "` theme,
           `" . $cols->level . "` `level`,
           `".  $cols->text ."` `text`
    FROM " . $material->getSource()->getPath() . " mat
    WHERE `".  $cols->text ."` LIKE '%". $filter ."%' ".(trim($conditions)==''?"":" AND ".$conditions). "
    ORDER BY theme,level,frequency
    LIMIT $start,$itemPerPage";

$rows=$_connection->Query($q);

$table= new TableView('','','');
$table->columns=['ID','Text','Rank','Frequency','Theme','Level'];
$table->rows=[];

foreach($rows as $row){
    $task=TaskFactory::createTaskById($_connection,$material->getId(),$row['task_id']);
    $table->rows[]=[
        'list'=>[
            [
                'value'=>'<a href="'.$router->generate('man_task_view',['mat_name'=>$materialName,'task_id'=>$row['task_id']]).'">'.$row['task_id'].'</a>',
            ],
            [
                'value'=>$task->getText(),
            ],
            [
                'value'=>$row['rank'],
            ],
            [
                'value'=>$row['frequency'],
            ],
            [
                'value'=>$row['theme'],
            ],
            [
                'value'=>$row['level'],
            ],
        ],
        'style'=>'',
    ];
}

