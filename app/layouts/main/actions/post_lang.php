<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 



$selectedLang=app::POST("igxLangSelector");
if(Lang::isLang($selectedLang)){
    if(isset($_user_pref)){
        $_user_pref->setParam(UserPrefParams::interface_language,$selectedLang);

        unset($_SESSION[SS_APP_LANG]);
        unset($_SESSION[SS_APP_LANG_EXPIRE]);
    }
    else{
        $_SESSION[SS_APP_LANG]=$selectedLang;
        $_SESSION[SS_APP_LANG_EXPIRE]=$_connection->GetValue("SELECT NOW() r;");
    }
}

app::redirect($_SERVER['HTTP_REFERER']);


use Adapter\User\UserPrefParams;

