<?php

use System\Enums\ControlMechanism;

require_once(APP_PATH.'/layouts/assessment/view/actions/action_helper.php');

if(!isValidFormToken()){
    if(!isset($_SESSION['redundant_submit'])){
        $_SESSION['redundant_submit']=0;
        $_SESSION['redundant_submit_post_data']=$appLog->getPostData();
    }
    $_SESSION['redundant_submit']++;
    app::redirect($router->generate('assessment_view'));
    /** EXIT **/
}

unset($_SESSION[SS_FORM_TOKEN]);

addRedundantSubmitLog();

$asm=AssessmentControl::load();

$QAResponse=fillQAResponseFromPOST($asm);
$asm->iterator()->current()->setResponseData($QAResponse);

//Check user answer POST
if(!isset($QAResponse)){
    app::redirect($router->generate('assessment_view'));
    throw new \AppException('QAResponse is null!');
}

//
if($QAResponse->responded){
    $asm->iterator()->current()->setResponded(true);;
    $asm->iterator()->current()->setResponseIp($_SERVER['REMOTE_ADDR']);
}
else{
    $asm->iterator()->current()->setResponded(false);
    $asm->iterator()->current()->setResponseIp(null);
}

//
switch($asm->getControlMechanism()){
    case ControlMechanism::LEVEL_PASSING:
        if(isset($_POST['pgAccept'])){
            levelPassing_Accept($asm, $QAResponse->responded);
        }
        break;

    case ControlMechanism::SEQUENTIAL:
        if(isset($_POST['pgSubmit'])){
            if($asm->iterator()->current()->getQueue() < $asm->iterator()->count()){
                $asm->iterator()->next();
            }
        }
        break;

    case ControlMechanism::FREE_MOVE:
        if(isset($_POST['pgNext'])){
            if($asm->iterator()->current()->getQueue() < $asm->iterator()->count()){
                $asm->iterator()->next();
            }
        }
        elseif(isset($_POST['pgBack'])){
            if($asm->iterator()->current()->getQueue() > 1){
                $asm->iterator()->prev();
            }
        }
        break;

    default:
        throw new \AppException("Undefined ControlMechanism type: ".$asm->getControlMechanism().";",3002);
        break;
}

app::redirect($router->generate('assessment_view'));
