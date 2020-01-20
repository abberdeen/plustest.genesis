<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

if($match['name']=='ajax_x1'||$match['name']=='ajax_x2'||$match['name']=='ajax_x3'){
    sys::_400(true);
    die();
}

//if param key not exists
if(!isset($match['params']['key'])){
    sys::_400(true);
    die();
}

//if token is not correct
if(!jx::checkToken($match['params']['key'])){
    sys::_403(true);
    die();
}

//fx:function;
if(!isset($match['params']['fx'])){
    sys::_400(true);
    die();
}

$fx=$match['params']['fx'];

if(preg_match('/^'.jxMANAGEMENT.'/',$fx)){


    include app::actionLink('ajax/actions/article.php');


}
elseif(preg_match('/^'.jxMANAGEMENT.'/',$fx)){



    if(isset($_user)&&$_user->checkAccessKey()){
        include app::actionLink('ajax/actions/users/manager.php');
        echo jx::getToken();
    }
    else{
        sys::_403(true);
        die();
    }



}
elseif(preg_match('/^'.jxMANAGEMENT.'/',$fx)){



    if($_user_auth->CheckAuthentication('',$_user_type==UserType::User||
        $_user_type==UserType::Manager)){
        include app::actionLink('ajax/actions/users/user.php');
    }
    else{
        sys::_403(true);
        die();
    }


}
else{


    sys::_404(true);
    die();


}


use System\Enums\UserType;

