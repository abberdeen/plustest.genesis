<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

$policyName=$match['params']['item'];
$policyExists=true;

$policy=AdapterGen::getPolicyByName($_connection,$policyName);
if($policy->getId()==0||$policy->getId()==null){
    $policyExists=false;
}