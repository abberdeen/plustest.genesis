<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

if(isset($_user)){
    $_SESSION['cauth_saygoodbye']='';
}
$_user_auth->logout();
app::redirect($router->generate('goodbye'));



