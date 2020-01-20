<?php

use System\Html\Views\TableView;
use System\Enums\AssessmentState;
use Adapter\Event\Event;
use Adapter\Assessment\Assessment;
//
function generateEventView($eventId){
    global $_connection;
    $event= new Event($_connection,$eventId);
    $eventView=generateEventViewTable($event);
    $policyTitle=trim($event->getPolicy()->getTitle());
    $eventDesc=trim($event->getDescription());
    $subtitle=[];
    if(strlen($policyTitle)>0) $subtitle[]=$policyTitle=kb::a("tg",$policyTitle,null,'_blank');
    if(strlen($eventDesc)>0) $subtitle[]=$eventDesc;
    if($eventView!=""){
        return "<div class='card' style='margin-bottom: 20px;'>
  <div class='card-block'>
    <h4 class='card-title'>".$event->getTitle()."</h4>
      <h6 class='card-subtitle mb-2 text-muted'>".implode(' | ',$subtitle)."</h6>
      <div style='height: 16px;'></div>
        ".$eventView."
  </div>
</div>";
    }
    return "";
}

/**
 * @param Event $event
 * @return string
 */
function generateEventViewTable(&$event){
    global $_connection;
    $eventView="";
    $eventEnabled = $event->enabled();
    $table= new TableView('','','');
    $table->rows=[];
    $table->marginBottom=0;
    foreach($event->items()->idList() as $asmId){
        $asm=new Assessment($_connection,$asmId);
        $table->rows[]=[
            'list'=>[
                [
                    'value'=>$asm->getDiscipline()->getName(),
                ],
                [
                    'value'=>'',
                ],
                [
                    'value'=>generateAssessmentButtonView($eventEnabled, $asm),
                    'style'=>'text-align: right;'
                ],
            ],
            'style'=>'',
        ];
    }
    $table->cellAlignment='left';
    $table->headAlignment='left';
    $eventView.=$table->render();
    return $eventView;
}

/**
 * @param bool $eventEnabled
 * @param Assessment $asm
 * @return string
 */
function generateAssessmentButtonView($eventEnabled, &$asm){
    global $router;
    $stateCaption="";
    $btnStyle="";
    switch($asm->getState()){
        case AssessmentState::NOT_STARTED:
            $stateCaption="ШУРӮЪ";
            $btnStyle="primary";
            break;
        case AssessmentState::STARTED:
            $stateCaption="ИДОМА";
            $btnStyle="warning";
            break;
        case AssessmentState::PAUSED:
            $stateCaption="ТАВАҚҚУФ";
            $btnStyle="secondary";
            $eventEnabled=false;
            break;
        case AssessmentState::FINISHED:
            $stateCaption="ҲИСОБОТ";
            $btnStyle="info";
            $eventEnabled=true;
            break;
    }
    //
    $disabled=$eventEnabled?'':' disabled ';
    $href="#";
    if($eventEnabled){
        $encrypted_asm_id=security::encrypt($asm->getId());
        $data=urlencode($encrypted_asm_id);
        $href=$router->generate('assessment_load')."?a=".$data;
    }
    return "<a href='".$href."' class='btn btn-sm btn-outline-".$btnStyle." ".$disabled."' style='width:88px;'>".$stateCaption."</a>";
}