<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}?>
<?php
use System\Enums\UserType;

$userType=null;
if(isset($_user)){
    $userType=$_user->getType();
}
switch($userType){
    case UserType::User:
        include app::templateLink("page/user_navbar");
        break;
    case UserType::Manager:
        if($_user->checkAccessKey()){
            include app::templateLink("page/manager_navbar");
        }
        else{
            include app::templateLink("page/default_navbar");
        }
        break;
    case UserType::Observer:
        include app::templateLink("page/observer_navbar");
        break;
    case UserType::Editor:
        include app::templateLink("page/editor_navbar");
        break;
    default:
        include app::templateLink("page/default_navbar");
        break;
}