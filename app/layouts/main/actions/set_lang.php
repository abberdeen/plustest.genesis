<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

use Adapter\User\UserPrefParams;

if(isset($match['params']['item'])){
    $selectedLang=$match['params']['item'];
    if(Lang::isLang($selectedLang)){
        if(isset($_user_pref)){
            $_user_pref->setParam(UserPrefParams::interface_language,$selectedLang);
        }
    }
}
header('location:/');

