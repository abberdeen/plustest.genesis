<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

use Adapter\User\UserIpAuthorization;

if(isset($_GET['jx'])){
    header('content-type=text','',403);
    die();
}

$reasonText="";

$user_ip_auth=new UserIpAuthorization($_connection);
if($user_ip_auth->ipBanned($_SERVER['REMOTE_ADDR'])){
    $reasonText="<br>Даромад бо IP-суроғаи шумо манъ карда шудааст. Сабаб: номаълум.
                     Агар ба фикри Шумо ин нодуруст бошад <a href='".$router->generate('cpl_shared')."'>хабар диҳед</a>.";
}





