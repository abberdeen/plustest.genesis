<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

use Adapter\User\UserEvents;

require_once(APP_PATH.'/layouts/users/user/events/script_helper.php');
//
$userEvents=new UserEvents($_connection,$_user->getId());
$eventIdList=$userEvents->getEventIdList();


$events="";
if(count($eventIdList)==0){
    $events="Empty :(";
}
else{
    foreach($eventIdList as $eventId){
        $events.=generateEventView($eventId);
    }
}

