<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

/**
 * checking pas.dpdtt.tj available and redirect
 */
$_server_new_alias="pas.dpdtt.tj";
$_server_new_url="http://".$_server_new_alias;

$_http_host=$_SERVER['HTTP_HOST']; //client http host. server address
$_request_url=$_SERVER['REQUEST_URI'];//client requested url on this server

if($_http_host==$_server_new_alias && $_request_url=='/ping'){
    die('');
    die('I\'m say: pong!<br><i>Host available and totaly works.</i>');//Yeah it's a pity
}

if($_http_host!=$_server_new_alias){
    $_curl=curl_init($_server_new_url.'/ping');
    if(curl_exec($_curl)){
        header('location:'.$_server_new_url.$_request_url);
    }
}