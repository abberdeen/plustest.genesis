<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 


if(!isset($_SESSION["banned_username"])){
    app::redirect($router->generate('auth_login'));
}

$username=$_SESSION["banned_username"];
unset($_SESSION["banned_username"]);

$_SESSION["_AUTH_U"]=$username;

$xuser=$_users_list->getUserByName($username);
if($xuser->authBanExpired()){
    $xuser->getAuthBan();
    app::redirect($router->generate('auth_login'));
}



