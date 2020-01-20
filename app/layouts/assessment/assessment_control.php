<?php

use Adapter\Event\EventItems;
use Adapter\Assessment\Assessment;
use Adapter\Material\Material;
use Adapter\Task\BasicTaskGenerator;
use Adapter\Task\TaskFactory;
use Adapter\Task\TaskViewFactory;
use Adapter\QA\QAResponse\MatchingTypeQAResponse;
use Adapter\QA\QAResponse\MultipleChoiceQAResponse;
use Adapter\QA\QAResponse\MultipleResponseQAResponse;
use Adapter\QA\QAResponse\NumericResponseQAResponse;
use Adapter\QA\QAResponse\OpenResponseQAResponse;
//
use System\Enums\TaskType;
use System\Enums\AssessmentState;
use System\Enums\ControlMechanism;

class AssessmentControl{
    /**
     * @return Assessment
     * @throws AppException
     */
    public static function load(){
        global $_connection;
        global $_user;
        /**
         * Check session
         * @session SS_EVENT_ID Requested eventId
         * @session SS_ASSESSMENT_ID Requested AssessmentId
         */
        if(!isset($_SESSION[SS_EVENT_ID]) || !isset($_SESSION[SS_ASSESSMENT_ID])){
            throw new AppException('Assessment session variable not defined.');
        }

        /**
         * Check Assessment existing in EventItems, if Assessment not exist then system shows error message
         */
        $eventItems=new EventItems($_connection,$_SESSION[SS_EVENT_ID]);
        if($eventItems->exists($_SESSION[SS_ASSESSMENT_ID])==false){
            throw new AppException('Requested assessment doesn\'t exists. EventId:'.$_SESSION[SS_EVENT_ID].'; AsmId:'.$_SESSION[SS_ASSESSMENT_ID].';',2603);
        }

        /**
         * Create requested Assessment
         * @var Assessment $asm
         */
        $asm = new Assessment($_connection,$_SESSION[SS_ASSESSMENT_ID]);

        /**
         * Check requested assessment userId with current logged userId, if user is not valid system shows error message
         */
        if($asm->getUser()->getId()!=$_user->getId()){
            throw new AppException('Invalid userId. AsmUserId:'.$asm->getUser()->getId().'; LoggedUserId:'.$_user->getId().';',2604);
        }


        /**
         * Starts assessment if not started
         */
        if($asm->getState()==AssessmentState::NOT_STARTED){
            $asm->_start();
        }
        elseif($asm->getState()==AssessmentState::FINISHED){
            //TODO: Send to report page for example
            die("Report:::>>>");
        }

        /**
         * If Assessment state not defined shows error message
         */
        if($asm->getState()!=AssessmentState::STARTED){
            throw new AppException('Assessment state is not equal to STARTED. AsmId:'.$_SESSION[SS_ASSESSMENT_ID].';',2605);
        }

        return $asm;
    }
}
