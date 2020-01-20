<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

use Adapter\User\UserEvents;

$userEvents=new UserEvents($_connection,$_user->getId());

$eventLink="";
if($userEvents->isUserHaveUnfinishedEvent()){
    $unfinished=$userEvents->isUserHaveSartedEvent();
    $eventCount=count($userEvents->getEventIdList());
    $eventLink="<div class='card card-inverse' style='background-color: #333; border-color: #333;margin-bottom:  20px;'>
  <div class='card-block'>
    <h4 class='card-title'>Имтиҳоноти маъмурӣ</h4>
    <p class='card-text'>Шумо имтиҳоноте доред, ки ҳоло  ".($unfinished?'то охир насупоридаед':'онро насупоридаед').".
                        Барои ".($unfinished?'ба охир расонидани':'супоридани')." он ба саҳифаи имтиҳонот гузаред.</p>
    <a href='".$router->generate("user_events")."' class='btn btn-primary'>Гузариш ба саҳифаи имтиҳонот</a>
  </div>
</div>";
}


