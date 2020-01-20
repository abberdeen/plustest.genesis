<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

$userName=$match['params']['item'];
$userExists=true;

$user=AdapterGen::getUserByName($_connection,$userName);
if($user->getId()==0||$user->getId()==null){
    $userExists=false;
}
