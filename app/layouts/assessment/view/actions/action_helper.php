<?php

use Adapter\App\Log;
use Adapter\Assessment\Assessment;
use Adapter\ControlMechanism\ControlMechanismSubRule;
//
use System\Enums\TaskType;

/**
 * @param Assessment $asm
 * @param bool $responded
 * @throws AppException
 */
function levelPassing_Accept(&$asm,$responded){
    //Prepare work variables
    $asmCMData=$asm->getCMData();
    $currentLevel=$asmCMData->currentLevel;
    /** @var ControlMechanismSubRule $subRule*/
    $subRule=$asm->getConf()->getSubruleByLevel($currentLevel);
    $incorrectAnswersCount=$asm->levelItems()->totalNegativePointsByLevel($currentLevel);
    $maxIncorrectAnswerCount=$subRule->getTaskCount() - $subRule->getXlCorrectCount();

    //assess the situation
    if($incorrectAnswersCount > $maxIncorrectAnswerCount){
        $asm->_finish();
    }
    elseif($responded==true){
        $correctAnswersCount = $asm->levelItems()->totalPointsByLevel($currentLevel);
        $correctCount=$subRule->getXlCorrectCount();

        if($correctCount==0 || !isset($correctCount)){
            throw new \AppException("Control Mechanism's SubRule have undefined subrule_xl_correct_count. SubRuleId: ".$subRule->getId().";",3001);
        }

        $levelIterator = $asm->levelIterator();
        if($correctAnswersCount >= $subRule->getXlCorrectCount()){ //Can just check for equality (==), but for prevent exceptions need check (>=)
            if($levelIterator->currentLevel() < $levelIterator->countOfLevel()){
                $levelIterator->nextLevel(); //Move to next level's first question (QA)
            }
        }
        else{
            if(($levelIterator->current()->getQueue() < $levelIterator->count())){
                $levelIterator->next(); //Move to next question (QA)
            }
        }
    }
}



/**
 * @return bool
 */
function isValidFormToken(){
    if(isset($_POST['FORM_ID']) && isset($_SESSION[SS_FORM_TOKEN])){
        if($_SESSION[SS_FORM_TOKEN]==$_POST['FORM_ID']){
            return true;
        }
    }
    return false;
}

function addRedundantSubmitLog(){
    global $_connection;
    global $_user;
    if(isset($_SESSION['redundant_submit'])){
        $appLog=new Log($_connection);
        $appLog->newLog($_user->getId(),
            "asm_id: ".$_SESSION[SS_ASSESSMENT_ID].
            ";\nredundant_submit_to_action_form_count:= ".$_SESSION['redundant_submit'].
            ";\nfirst_post_data: ".$_SESSION['redundant_submit_post_data'],'redundant_submit','ASSESSMENT');
        unset($_SESSION['redundant_submit']);
    }
}

function fillQAResponseFromPOST(Assessment &$assessment){
    $queue=$assessment->iterator()->current()->getQueue();
    $qar=$assessment->iterator()->current()->getResponseData();
    switch($assessment->iterator()->current()->getTask()->type){
        case TaskType::MULTIPLE_CHOICE:

            if(!isset($_POST['Q'.$queue])){
                $qar->response=null;
                $qar->responded=false;
            }
            else{
                $q=($_POST['Q'.$queue]);
                if(in_array($q,[0,1,2,3]) && is_numeric($q) ){
                    $qar->response=intval($_POST['Q'.$queue]);
                    $qar->responded=true;
                }
            }

            break;

        case TaskType::MULTIPLE_RESPONSE:
            $varsCounts=count($assessment->iterator()->current()->getTask()->variants);
            $qar->responses=[];
            for($i=0;$i<$varsCounts;$i++){
                if(isset($_POST['Q'.$queue.'_'.$i])){
                    $qar->responses[]=$i;
                }
            }
            if(count($qar->responses)>0){
                $qar->responded=true;
            }
            else{
                $qar->responded=false;
            }
            break;

        case TaskType::MATCHING_TYPE:
            $varsCount=$assessment->iterator()->current()->getTask()->getLeftCount();
            $qar->matches=[];
            $c=0;
            for($i=0;$i<$varsCount;$i++){
                if(isset($_POST['Q'.$queue.'_'.$i])){
                    $x=str_replace('r','',($_POST['Q'.$queue.'_'.$i]));
                    if( ($x >= 0 && $x <= 5) && is_numeric($x) ){
                        $qar->matches[$i]=$x;
                        $c++;
                    }
                }
            }

            if($c==$varsCount){
                $qar->responded=true;
            }
            else{
                $qar->responded=false;
            }
            break;

        case TaskType::NUMERIC_RESPONSE:
            $respCount=count($assessment->iterator()->current()->getTask()->responses);
            $qar->responses=[];
            $c=0;
            for($i=0;$i<$respCount;$i++){
                if(isset($_POST['Q'.$queue.'_'.$i])){
                    $x=($_POST['Q'.$queue.'_'.$i]);
                    $qar->responses[$i]=$x;
                    $c++;
                }
            }
            if($c==$respCount){
                $qar->responded=true;
            }
            else{
                $qar->responded=false;
            }
            break;

        case TaskType::OPEN_RESPONSE:
            break;

        default:
            return null;
    }
    return $qar;
}


