<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

if(isset($_GET['jx'])){
    sys::_500();
    die();
}

$error_code=$params['code']==''?'0x0':$params['code'];
$error_message=$params['message']==''?'INTERNAL ERROR':$params['message'];

include_once app::formLink('templates/system/fatal_simple');



//log
$appLog=new AppLog($_connection);
$user_id=null;
if($_user instanceof User){
    $user_id=$_user->getId();
}
$appLog->addAppCrashLog($user_id,"FATAL_".$error_code,$error_message);





