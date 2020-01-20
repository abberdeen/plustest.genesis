<?php
use Adapter\Assessment\Assessment;
use System\Html\Views\PaginationView;
use System\Enums\TaskType;

/**
 * @param $asm
 * @return string
 */
function levelPassing_ProgressIndicator(&$asm,$taskType){
    //
    $levelIterator=$asm->levelIterator();
    $currentLevel=$levelIterator->currentLevel();
    $levelCount=$levelIterator->countOfLevel();
    //
    $levelItems=$asm->levelItems();
    $correctCount=$levelItems->totalPointsByLevel($currentLevel);
    $incorrectCount=$levelItems->totalNegativePointsByLevel($currentLevel);
    //
    /** @var \Adapter\ControlMechanism\ControlMechanismSubRule $subRule*/
    $subRule=$asm->getConf()->getSubruleByLevel($currentLevel);
    $xlCorrectCount=$subRule->getXlCorrectCount();
    $maxIncorrectAnswerCount=$subRule->getTaskCount() - $xlCorrectCount + 1;
    //
    $progressIndicator="<p>Дараҷаи ".$currentLevel." аз ".$levelCount." <i>(".TaskType::getTaskTypeDesc($taskType).")</i>
                        <span style='float:right;'>
                            Дуруст:&nbsp;<span class='badge badge-".($correctCount==0?'default':'success')."'>".$correctCount."/".$xlCorrectCount."
                            </span>&nbsp;
                            Нодуруст:&nbsp;<span class='badge badge-".($incorrectCount==0?'default':'warning')."'>".$incorrectCount."/".$maxIncorrectAnswerCount."
                            </span>
                        </span>
                        <br>
                        <small>Вақти боқимонда: ".$asm->getElapsedTime()."</small>
                    </p>
                    <script>
                        if(pgCorrectCount.InnerText()!=0){
                            pgICorrect.Class
                        }
                    </script>";
    return $progressIndicator;
}

function levelPassing_ControlButton(){
    return '<script>var c=0;
            function accept_onclick(){
                if(c==0){
                    document.forms.pgTaskResponse.submit();
                    c=1;
                }
            }
            </script>
            <input type="hidden" name="pgAccept">
            <input type="button" class="btn btn-primary" style="width: 125px;" value="Accept" onclick="accept_onclick();">';
}

function freeMove_ProgressIndicator(&$asm,$taskType){
    $currentItemQueue=$asm->iterator()->current()->getQueue();
    $totalItems=$asm->iterator()->count();
    $itemTypeDesc=TaskType::getTaskTypeDesc($taskType);
    return "<p>Саволи ".$currentItemQueue." аз ".$totalItems." <i>(".$itemTypeDesc.")</i>
                        <br>
                        <small>Вақти боқимонда: ".$asm->getElapsedTime()."</small>
                    </p>";
}

function freeMove_ControlButtons(&$asm){
    $currentItemQueue=$asm->iterator()->current()->getQueue();
    $totalItems=$asm->iterator()->count();
    $controlButtons="";
    /*pagination/quizination*/
    $pagination=new PaginationView($currentItemQueue,"",$totalItems,1);
    $pagination->showLimits=false;
    $pagination->showNextLink=false;
    $pagination->showPrevLink=false;
    $controlButtons="<div style='margin-bottom:10px;background: #e3f2fd;'>".$pagination->render()."</div>";
    /*button move back */
    if($asm->iterator()->current()->getQueue()>1){
        $controlButtons.='<input type="submit" class="btn btn-primary btn-sm" style="width: 125px;margin-right: 30px;" name="pgBack" value="Пешина">';
    }
    else{
        $controlButtons.='<input type="button" class="btn btn-primary btn-sm disabled" style="width: 125px;margin-right: 30px;" name="" value="Пешина">';
    }

    /*button move next*/
    if($asm->iterator()->current()->getQueue() < $asm->iterator()->count()){
        $controlButtons.='<input type="submit" class="btn btn-primary" style="width: 125px;" name="pgNext"  value="Оянда">';
    }
    else{
        $controlButtons.='<input type="button" class="btn btn-primary disabled" style="width: 125px;" name=""  value="Оянда">';
    }
    return $controlButtons;
}