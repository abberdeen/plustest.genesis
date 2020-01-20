<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}


use System\Enums\AuthenticationState;
use System\Enums\UserType;


$u_name=app::POST("username");
$u_password=app::POST("password");
$u_password=md5($u_password);

$_SESSION["_AUTH_U"]="";//user name
$_SESSION["_AUTH_C"]="";//AuthenticationState

if(strlen($u_name)<3){
    $_SESSION["_AUTH_U"]="";
    $_SESSION["_AUTH_C"]=AuthenticationState::EMPTY_USERNAME;
    app::redirect($router->generate('auth_login_fail'));
}



if(strlen(app::POST("password"))<1){
    $_SESSION["_AUTH_U"]=$u_name;
    $_SESSION["_AUTH_C"]=AuthenticationState::EMPTY_PASSWORD;
    app::redirect($router->generate('auth_login_fail'));
}



if(!$_users_list->usernameExists($u_name)){
    $_SESSION["_AUTH_U"]=$u_name;
    $_SESSION["_AUTH_C"]=AuthenticationState::INCORRECT_USERNAME;
     app::redirect($router->generate('auth_login_fail'));
}



$xuser=$_users_list->getUserByName($u_name);
if($xuser->getAuthTryCount()>=AUTH_MAX_TRY && !$xuser->authBanned()){
    $xuser->setAuthBan();
}
if($xuser->authBanned()){
    $_SESSION["banned_username"]=$u_name.' ';
    app::redirect($router->generate('auth_login_ban'));
    die();
}
$xuser->setAuthTryCount();



if(!$_users_list->userValidate($u_name,$u_password)){
    $_SESSION["_AUTH_U"]=$u_name;
    $_SESSION["_AUTH_C"]=AuthenticationState::INCORRECT_PASSWORD;
    app::redirect($router->generate('auth_login_fail'));
}



$_user_auth->login($u_name,$u_password);


switch($_user_auth->AuthenticationState()){
    case AuthenticationState::SUCCESS:
        unset($_SESSION["_AUTH_U"]);
        unset($_SESSION["_AUTH_C"]);
        $_user=$_users_list->getUserByToken($_SESSION[SS_USER_TOKEN]);
        $_user->setAuthTryCount(0);
        switch($_user->getType()){
            case UserType::User:
                app::redirect($router->generate('user_base'));
                break;
            case UserType::Manager:
                app::redirect($router->generate('man_base'));
                break;
            case UserType::Observer:
                app::redirect($router->generate('ob_base'));
                break;
            case UserType::Editor:
                app::redirect($router->generate('editor_base'));
                break;
            default:
                $_user_auth->logout();
                app::redirect($router->generate('auth_login_fail'));
                break;
        }
        echo "user type undefined";

        break;
    case AuthenticationState::IP_BANNED:
        $_user_auth->logout();
        sys::_403();
        break;
    case AuthenticationState::BROKED_TOKEN:
        $_SESSION["_AUTH_U"]="";
        $_SESSION["_AUTH_C"]=AuthenticationState::BROKED_TOKEN;
        app::redirect($router->generate('auth_login_fail'));
        break;
    case AuthenticationState::AUTHORIZATION_ERR:
        $_SESSION["_AUTH_U"]="";
        $_SESSION["_AUTH_C"]=AuthenticationState::AUTHORIZATION_ERR;
        app::redirect($router->generate('auth_login_fail'));
        break;
    case AuthenticationState::TOKEN_FAIL:
        $_SESSION["_AUTH_U"]="";
        $_SESSION["_AUTH_C"]=AuthenticationState::TOKEN_FAIL;
        app::redirect($router->generate('auth_login_fail'));
        break;
    default:
        $_SESSION["_AUTH_U"]="";
        $_SESSION["_AUTH_C"]="0x0";
        app::redirect($router->generate('auth_login_fail'));
        break;
}

