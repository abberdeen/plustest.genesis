<?php

use System\Enums\ControlMechanism;
use Adapter\Task\TaskViewFactory;

require_once(APP_PATH.'/layouts/assessment/view/script_helper.php');

/**
 * Loading Assessment see ::load for more details
 */
$asm=null;
try{
    $asm=AssessmentControl::load();
}
catch(AppException $ex){
    sys::fatal(false,$ex->getCode()) ;
}

$task=null;
$responseData=null;
$taskQueue=null;
$controlButtons="";
$progressIndicator="";

switch($asm->getControlMechanism()){
    case ControlMechanism::LEVEL_PASSING:
        $currentQA=$asm->levelIterator()->current();

        if($currentQA==null){
            try{
                throw new AppException("AssessmentQALevelIterator: Error while selecting current QA. AssessmentId: ".$asm->getId(),2701);
            }
            catch(AppException $ex){
                sys::fatal(false,$ex->getCode()) ;
            }
        }

        $task=$currentQA->getTask();

        if($task==null){
            try{
                throw new AppException("AssessmentQALevelIterator: Returned null task. AssessmentId: ".$asm->getId().";",2703);
            }
            catch(AppException $ex){
                sys::fatal(false,$ex->getCode());
            }
        }

        $taskQueue=$currentQA->getQueue();
        $responseData=$currentQA->getResponseData();
        $progressIndicator=levelPassing_ProgressIndicator($asm,$task->type);
        $controlButtons=levelPassing_ControlButton();
        break;

    case ControlMechanism::SEQUENTIAL:
        //TODO: Do this section
        break;

    case ControlMechanism::FREE_MOVE:
        if(isset($_GET["page"])){
            $key=intval($_GET["page"]);
            if($key > 0 && $key <= $asm->iterator()->count()){
                $asm->iterator()->seek($key);
            }
        }

        $currentQA=$asm->iterator()->current();

        if($currentQA==null){
            try{
                throw new AppException("AssessmentQAIterator: Error while selecting current QA. AssessmentId: ".$asm->getId(),2702);
            }
            catch(AppException $ex){
                sys::fatal(false,$ex->getCode());
            }
        }

        $task=$currentQA->getTask();

        if($task==null){
            try{
                throw new AppException("AssessmentQAIterator: Returned null task. AssessmentId: ".$asm->getId().";",2704);
            }
            catch(AppException $ex){
                sys::fatal(false,$ex->getCode());
            }
        }

        $taskQueue=$currentQA->getQueue();
        $responseData=$currentQA->getResponseData();
        $progressIndicator=freeMove_ProgressIndicator($asm,$task->type);
        $controlButtons = freeMove_ControlButtons($asm);
        break;

    default:
        try{
            throw new AppException("Undefined control mechanism: ".$asm->getControlMechanism());
        }
        catch(AppException $ex){
            sys::fatal(false,$ex->getCode());
        }
        break;
}

$taskView = TaskViewFactory::createResponseTaskView($task,$responseData,$taskQueue);

/**
 * CSRF html form token
 */
$_SESSION[SS_FORM_TOKEN]=app::formToken();

