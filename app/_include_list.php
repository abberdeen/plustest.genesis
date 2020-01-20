<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

//include global using classes
require_once(APP_PATH.'/vendor/Core/ajax.php');
require_once(APP_PATH.'/vendor/Core/app.php');
require_once(APP_PATH.'/vendor/Core/kb.php');
require_once(APP_PATH.'/vendor/Core/sys.php');
require_once(APP_PATH.'/vendor/Core/security.php');
require_once(APP_PATH.'/vendor/Core/InterLang.php');
require_once(APP_PATH.'/vendor/Core/ViewExt.php');
require_once(APP_PATH.'/vendor/Core/UIControls.php');
require_once(APP_PATH.'/vendor/Core/Exceptions/AppException.php');
require_once(APP_PATH.'/vendor/Core/Exceptions/MySqlConnectException.php');

require_once(APP_PATH.'/layouts/assessment/assessment_control.php');

function isns($class,$ns){
    //$ns project-specific namespace prefix

    // does the class use the namespace prefix?
    $len = strlen($ns);
    if (strncmp($ns, $class, $len) !== 0) {
        return false;
    }
    return true;
}
spl_autoload_register(function ($class) {
    // base directory for the namespace prefix
    $base_dir = APP_PATH.'/vendor/';

    if(isns($class,'Adapter')){
        $base_dir=APP_PATH.'/';
    }
    //echo $class."<br>";
    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . $class . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});
