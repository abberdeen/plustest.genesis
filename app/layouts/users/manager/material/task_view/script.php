<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

$materialName=$match['params']['mat_name'];
$material=AdapterGen::getMaterialByName($_connection,$materialName);

$taskId=$match['params']['task_id'];
$task=TaskFactory::createTaskById($_connection,$material->getId(),$taskId);
$taskView=TaskViewFactory::createDefaultTaskView($task);




