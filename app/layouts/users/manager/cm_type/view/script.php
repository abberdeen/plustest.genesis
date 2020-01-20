<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

$cmName=$match['params']['item'];
$cmExists=true;

$cm=AdapterGen::getCMTypeByName($_connection,$cmName);
if($cm->getId()==0||$cm->getId()==null){
    $cmExists=false;
}
?>