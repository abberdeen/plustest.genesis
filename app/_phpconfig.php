<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

/**
 * PHP config
 */

//hide errors by default
$display_errors='off';
$display_startup_errors='off';
$error_reporting='0';
if(DEBUG_MODE_ENABLED){
    //show errors
    $display_errors='on';
    $display_startup_errors='on';
    $error_reporting='-1';
}
//error reporting
ini_set('display_errors',$display_errors);//On|Off
ini_set('display_startup_errors',$display_startup_errors);//On|Off
ini_set('error_reporting',$error_reporting);//-1 E_ALL & E_STRICT | 0 nothing
ini_set('log_errors','on');//On|Off
//short tags
ini_set('short_open_tag','on');//On|Off;
//
date_default_timezone_set('Asia/Dushanbe');
//
ini_set('date.timezone','Asia/Dushanbe');//On|Off;