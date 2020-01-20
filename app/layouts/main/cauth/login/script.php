<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}



use System\Enums\UserType;
use System\Enums\AuthenticationState;
use System\Html\Views\InputView;
use System\Html\Views\ButtonView;
use System\Html\Views\FormViewStyle;
use System\Html\Views\FormMsgStyle;

//If logged in then redirect from here
if($_user_auth->AuthenticationState()==AuthenticationState::SUCCESS){
    $_user=$_users_list->getUserByToken($_SESSION[SS_USER_TOKEN]);
    switch($_user->getType()){
        case UserType::User:
            app::redirect($router->generate('user_home'));
            break;
        case UserType::Manager:
            app::redirect($router->generate('man_home'));
            break;
        case UserType::Observer:
            app::redirect($router->generate('ob_home'));
            break;
        case UserType::Editor:
            app::redirect($router->generate('editor_home'));
            break;
    }
}

//CHECK FAIL
$username=null;
if(isset($_SESSION["_AUTH_U"])){
    $username=$_SESSION["_AUTH_U"];
    $username=str_replace("\\","",$username);
    $username=str_replace("/","",$username);
    $username=str_replace("'","",$username);
    unset($_SESSION["_AUTH_U"]);
}

$code=null;
if(isset($_SESSION["_AUTH_C"])){
    $code=$_SESSION["_AUTH_C"];
    unset($_SESSION["_AUTH_C"]);
}

//FORM VIEWS
$usernameView=new InputView('pgUsername','username','Login');//pgUsername
$usernameView->setValue(trim($username));
$usernameView->setClass('#username');

$passwordView=new InputView('','password','Password');//pgPassword
$passwordView->setType('password');

$keyboardView=new ButtonView('pgKeyboard','keyboard', '<img align="right"
                                 style="vertical-align: middle;"
                                 src="/resourceses/keyboard.png"
                                 id="keyboardInputInitiator">');
$keyboardView->setType('button');
$keyboardView->setViewStyle(FormViewStyle::BUTTON_SECONDARY);

$submitView=new ButtonView('pgSubmit','submit','Даромадан');
$submitView->setType('submit');

//FORM VIEW STYLE CHANGING
switch($code){
    case AuthenticationState::INCORRECT_USERNAME:
        $usernameView->setMessageStyle(FormMsgStyle::DANGER);
        $usernameView->setFeedback("Номи корбар ёфт нашуд.");
        break;
    case AuthenticationState::INCORRECT_PASSWORD:
        $passwordView->setMessageStyle(FormMsgStyle::DANGER);
        $passwordView->setFeedback("Гузарвожа нодуруст");
        break;
    case AuthenticationState::EMPTY_USERNAME:
        $username="";
        $usernameView->setMessageStyle(FormMsgStyle::WARNING);
        $usernameView->setFeedback("Номи корбар набояд холи бошад.");
        break;
    case AuthenticationState::EMPTY_PASSWORD:
        $passwordView->setMessageStyle(FormMsgStyle::WARNING);
        $passwordView->setFeedback("Гузарвожа набояд холи бошад.");
        break;
    case AuthenticationState::BROKED_TOKEN:
    case AuthenticationState::TOKEN_FAIL:
    case AuthenticationState::AUTHORIZATION_ERR:
        break;
    case '0x0':
        break;
    default:
        break;
}
