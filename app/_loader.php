<?php  if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

session_start();

//app components
require_once APP_PATH.'/_include_list.php';

use Adapter\Assessment\Assessment;
use System\AltoRouter;
use System\DataBaseFactory;
use System\Enums\UserType;
use System\Culture\Lang;
use System\Culture\LangCode;
use System\Enums\AuthenticationState;
use Adapter\User\UserList;
use Adapter\User\UserAuthentication;
use Adapter\User\UserPref;
use Adapter\User\UserPrefParams;
/**
 * GLOBAL VARIABLES
 */
//AltoRouter
$router = new AltoRouter();
$router->setBasePath(APP_ROOT);


require_once APP_LAYOUT_PATH.'/list_of_routes.php';


$match = $router->match();

//creating mysql connection
$_connection = DataBaseFactory::CreateConnection("local");

if(!isset($_connection)){
    die();
}

//user authentication
$_users_list=new UserList($_connection);
$_users_list->checkUserAgent();
$_user_auth=new UserAuthentication($_connection);
$_user=null;
$_user_pref=null;

//app interface language
$_app_lang=LangCode::Tajik;

//Set app lang to user defined lang. It works when user not logged in.
if(isset($_SESSION[SS_APP_LANG]) && isset($_SESSION[SS_APP_LANG_EXPIRE])){
    $r=$_connection->GetValue("SELECT (TIME_TO_SEC(TIMEDIFF(NOW(),'".$_SESSION[SS_APP_LANG_EXPIRE]."')))>400 r;"); //calculating time diff using mysql
    if($r==1){
        //if time expired user defined lang changes to default.
        unset($_SESSION[SS_APP_LANG]);
        unset($_SESSION[SS_APP_LANG_EXPIRE]);
    }
    elseif(Lang::isLang($_SESSION[SS_APP_LANG])){
        $_app_lang=$_SESSION[SS_APP_LANG];
    }
}

//is user logged in
if(isset($_SESSION[SS_USER_TOKEN])){

    if($_user_auth->AuthenticationState()==AuthenticationState::SUCCESS){
        /**
         * Defining user global variable
         */
        //
        $_user=$_users_list->getUserByToken($_SESSION[SS_USER_TOKEN]);

        //
        $_user_type=$_user->getType();

        //User preferences
        $_user_pref=new UserPref($_connection,$_user->getId());

        //
        $_up_lang=$_user_pref->getParam(UserPrefParams::interface_language);
        if(Lang::isLang($_up_lang)){
            $_app_lang=$_up_lang;
        }
    }
}

/**
 * LOAD CONSTRUCTOR
 * Constructor controls for creating pages & running scripts (or simply loading)
 * All variables in this file is available for all pages that load constructor.
 */
require_once APP_LAYOUT_PATH.'/constructor.php';
/**
 * END OF APPLICATION WORK
 */
//clearing memory (not necessary)
$_connection->destruct();
unset($GLOBALS);
unset($_connection);
unset($router);