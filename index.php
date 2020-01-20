<?php
/*
 * Front Controller
 * Everything pass from this file, because it is necessary for app work and that configured in .htaccess
 * But some of the son of a bitch~ can directly load any php file or other type of file if know path to file, it could lead to serious trouble
 * ~hackers are not sun of a bitch, they are hackers
 * Files relations similar to waterfall and app work in general similar to generator or 'function'
*/
/**
 * For check does opening script included from here
 * @return null
 */
function _acdb550314d9c3b4fdcefdf944709b2b(){return null;}

/**
 *
 */
$appdatapath="app/";
include $appdatapath . '_pas_dpdtt_tj.php';
include $appdatapath . '_config.php';
include $appdatapath . '_phpconfig.php';
include $appdatapath . '_loader.php';