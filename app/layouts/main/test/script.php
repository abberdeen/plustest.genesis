<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}


use Adapter\Assessment\Assessment;
use System\Enums\AssessmentState;

if($_SERVER['REMOTE_ADDR']!=='127.0.0.1') sys::_403();




$asmId=1;
$_SESSION[SS_ASSESSMENT_ID]=$asmId;
$asm=new Assessment($_connection,$asmId);

//$asm->_purge();
if($asm->getState()==AssessmentState::NOT_STARTED){
    $asm->_start();

    $taskList=BasicTaskGenerator::generateList($_connection,$asm->getDiscipline(),$asm->getRules());
    $q=0;
    foreach ($taskList as $t) {
        $q++;
        $asm->items()->addByParam(14690,$t['mat_id'],$t['task_id'],$q);
    }

    $asm->iterator()->rewind();

}
$c=app::GET('c');
switch($c){
    case 'next':
        $asm->iterator()->next();
        break;
    case 'prev':
        $asm->iterator()->prev();
        break;
    case 'rew':
        $asm->iterator()->rewind();
        break;
}

