<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

$_user->setAccessKey3(app::POST('igxKey'));
if($_user->getAccessKey()==app::POST('igxKey') && strlen($_user->getAccessKey())==32){
    $_user->setAccessKey2();
    if($_user->checkAccessKey()){
        //if access control passed then okey dokey!
        app::redirect($router->generate('man_base'));
    }
}

//if access control not passed then panic and ban user
$_user->setAuthTryCount(AUTH_MAX_TRY);
$_user->setAuthBan();

//unlog this user and move to login page
$_user_auth->logout();
app::redirect($router->generate('auth_login'));





