<?php

namespace Adapter\Assessment;

use Adapter\Task\TaskQAResponseHelper;
use \AppException;

use System\QueryAdapter;
//
use Adapter\Event\Event;
use Adapter\User\User;
use Adapter\Discipline\Discipline;
use Adapter\Discipline\DisciplineExt;
use Adapter\Assessment\AssessmentQAItems;
use Adapter\Assessment\AssessmentQAIterator;
use Adapter\Assessment\CMData\AssessmentCMData;
use Adapter\Assessment\CMData\AssessmentFreeMoveCMData;
use Adapter\Assessment\CMData\AssessmentLevelPassingCMData;
use Adapter\Assessment\CMData\AssessmentSequentialCMData;
use Adapter\Task\BasicTaskGenerator;
//
use System\Enums\AssessmentState;
use System\Enums\TimeLimitMethod;
use System\Enums\ControlMechanism;
use System\Enums\AssessmentLockReason;


class Assessment extends QueryAdapter{

    /**
     * @var int $assessmentId
     */
    private $assessmentId;
    private $connection;

    public function  __construct(&$connection,$assessmentId){
        $this->assessmentId=$assessmentId;
        $this->connection=&$connection;
        parent::__construct($connection,'e_assessment','asm_',$assessmentId);
        if(!$this->locked() && $this->getState()==AssessmentState::STARTED){
            $this->setLastRequestTime();
        }
    }

    public function getId(){
        return $this->assessmentId;
    }

    /**
     * @return Event
     */
    public function getEvent(){
        return new Event($this->connection,$this->getValue("asm_ev_id"));
    }

    /**
     * @return User
     */
    public function getUser(){
        return new User($this->connection,$this->getValue("asm_us_id"));
    }

    /**
     * @return Discipline
     */
    public function getDiscipline(){
        return new Discipline($this->connection, $this->getValue("asm_dcp_id"));
    }

    /**
     * @return int
     */
    public function getControlMechanism(){
        return $this->getConf()->getControlMechanism()->getId();
    }

    /**
     * @return ControlMechanismConf
     */
    public function getConf(){
        $dExt=new DisciplineExt($this->connection,$this->getDiscipline()->getId());
        return $dExt->getControlMechanismConfByPolicyId($this->getEvent()->getPolicy()->getId());
    }

    /**
     * @return array (ControlMechanismRule)
     */
    public function getRules(){
        return $this->getConf()->getRulesByCredit($this->getCredit());
    }

    /**
     * @return int
     */
    public function getCredit(){
        return intval($this->getValue("asm_cr_id"));
    }

    //State
    public function getState(){
        return intval($this->getValue("asm_state_id"));
    }

    private function setState($state){
        $this->setValue("asm_state_id",$state);
    }

    public function _start(){
        if($this->locked()){
            throw new AppException('Cannot start locked assessment',0);
        }

        if($this->getState()==AssessmentState::NOT_STARTED){
            $this->setTaskList();
            $this->setCMData();
            $this->setStartTime();
            $this->setStartIp();
            $this->setState(AssessmentState::STARTED);
        }
        else{
            throw new AppException('Cannot start, assessment already started.',2511);
        }
    }

    private function setTaskList(){
        switch($this->getControlMechanism()){
            case ControlMechanism::LEVEL_PASSING:
                $this->addTaskListByLevel(1);
                break;
            case ControlMechanism::FREE_MOVE:
            case ControlMechanism::SEQUENTIAL:
                $this->addAllTaskList();
                break;
        }
    }


    private function addAllTaskList(){
        //
        $taskList=BasicTaskGenerator::generateList($this->connection,$this->getDiscipline(),$this->getRules());
        //queue
        $q=0;
        //user id
        $usid=$this->getUser()->getId();
        //
        if($this->iterator()->count()>0){
            //prevent double adding
            return;
        }
        foreach ($taskList as $t) {
            $q++;
            $this->items()->addByParam($usid,$t['mat_id'],$t['task_id'],$q);
            $qa=$this->items()->getByQueue($q);
            $task=$qa->getTask();
            $qaResponseData=TaskQAResponseHelper::getQAResponse($task);
            $qa->setResponseData($qaResponseData);
        }
        $this->iterator()->rewind();
    }

    public function addTaskListByLevel($level){
        //
        $subRule=$this->getConf()->getSubruleByLevel($level);
        //
        $taskList=BasicTaskGenerator::generateListByLevel($this->connection,$this->getDiscipline(),$subRule);
        //queue
        $q=0;
        //user id
        $usid=$this->getUser()->getId();
        //
        $levelItems=new AssessmentQALevelItems($this->connection,$this->getId(),$level);
        if($this->levelIterator()->count()>0){
            //prevent double adding
            return;
        }
        foreach ($taskList as $t) {
            $q++;//
            $levelItems->addByParam($usid,$t['mat_id'],$t['task_id'],$q);
            //Note: selecting (getting) qa  must come after adding qa. It means: select last added qa
            $qa=$levelItems->getByQueue($q);
            $task=$qa->getTask();
            $qaResponseData=TaskQAResponseHelper::getQAResponse($task);
            $qa->setResponseData($qaResponseData);
        }
        $this->levelIterator()->rewind();
    }

    /**
     * Pause assessment.
     */
    public function _pause(){
        if($this->locked()){
            throw new AppException('Cannot pause locked assessment',0);
        }

        if($this->getState()==AssessmentState::STARTED){
            $this->setState(AssessmentState::PAUSED);
        }
        elseif($this->getState()==AssessmentState::FINISHED){
            throw new AppException('Cannot pause finished assessment',0);
        }
        else{
            throw new AppException('Cannot pause not started assessment',2512);
        }
    }

    /**
     * Continue after pause
     */
    public function _continue(){
        if($this->locked()){
            throw new AppException('Cannot continue locked assessment',0);
        }

        if($this->getState()==AssessmentState::PAUSED){
            $this->setState(AssessmentState::STARTED);
            $this->addPauseSeconds();
        }
        else{
            throw new AppException('Cannot continue un-paused assessment',2513);
        }
    }

    private function addPauseSeconds(){
        $addSeconds=$this->getValue('TIME_TO_SEC(TIMEDIFF(NOW(),asm_last_request_time))');
        $this->setStartTimeAdd($addSeconds);
    }

    public function _finish(){
        if($this->locked()){
            throw new AppException('Cannot finish locked assessment',0);
        }

        if($this->getState()==AssessmentState::STARTED){
            $this->setState(AssessmentState::FINISHED);
            $this->setEndTime();
        }
        else{
            throw new AppException('Cannot finish, assessment not stared ',2514);
        }
    }

    //Locked?
    public function locked(){
        return $this->getValue("asm_locked")=='1'?true:false;
    }

    public function _lock($reason=AssessmentLockReason::UNDEFINED){
        $this->setValue("asm_locked",1);
        $this->setLockReason($reason);
    }

    public function _unlock(){
        $this->setValue("asm_locked",0);
        $this->setLockReason('(NULL)');
        if($this->getState()==AssessmentState::STARTED){
            $this->addPauseSeconds();
        }
    }

    //LockReason
    public function getLockReason(){
        return $this->getValue("asm_lock_reason");
    }

    private function setLockReason($reason=AssessmentLockReason::UNDEFINED){
        $this->setValue("asm_lock_reason",$reason);
    }

    //Enabled
    /**
     * @return bool
     */
    public function enabled(){
        return $this->getValue("asm_enabled")=='1'?true:false;
    }


    public function _enable(){
        $this->setValue("asm_enabled",1);
    }

    public function _disable(){
        $this->setValue("asm_enabled",0);
    }

    /**
     *
     * Returns parent assessment if have
     * Note: will used when parent assessment have try count value is more than one and current assessment is child (subsequent try).
     * Note: parent assessment CANNOT have parent, means assessment CANNOT have grandchild's.
     * @return Assessment|null
     */
    public function getParentAssessment(){
        $parentAsmId=$this->getValue("asm_parent_asm_id");
        if($parentAsmId>0){
            return new Assessment($this->connection,$parentAsmId);
        }
        return null;
    }

    /**
     * Sets parent assessment id
     * Note: will used when parent assessment have try count value is more than one and current assessment is child (subsequent try).
     * Note: parent assessment CANNOT have parent, means assessment CANNOT have grandchild's.
     * @param int $parentAsmId
     */
    public function setParentAssessmentId($parentAsmId=0){
        $this->setValue("asm_parent_asm_id",$parentAsmId);
    }

    public function getStartTime(){
        return $this->getValue("asm_start_time");
    }

    private function setStartTime($value="NOW()"){
        $this->setValue("asm_start_time",$value,true);
    }

    public function getLastRequestTime(){
        return $this->getValue("asm_last_request_time");
    }

    private function setLastRequestTime($value="NOW()"){
        $this->setValue("asm_last_request_time",$value,true);
    }

    public function getEndTime(){
        return $this->getValue("asm_end_time");
    }

    private function setEndTime($value="NOW()"){
        $this->setValue("asm_end_time",$value,true);
    }

    /**
     * @param int $addSeconds
     */
    public function setStartTimeAdd($addSeconds=0){
        $this->setValue("asm_start_time_add",$addSeconds);
    }

    /**
     * ElapsedTime in seconds. From start time To current time OR end time of assessment
     * @return int
     */
    public function getElapsedTime(){

        switch($this->getState()){

            case AssessmentState::STARTED:
                if($this->locked()){
                    return intval($this->getValue($this->timeDiffQuery('asm_last_request_time')));
                }
                else{
                    $r=intval($this->getValue($this->timeDiffQuery('NOW()')));

                    //define params
                    $dcpExt=new DisciplineExt($this->connection, $this->getDiscipline()->getId());
                    $cm_conf=$dcpExt->getControlMechanismConfByPolicyId($this->getEvent()->getPolicy()->getId());
                    $params=$cm_conf->getParams();

                    if($params->getTimeLimitMethod()==TimeLimitMethod::UNLIMITED){
                        return $r;
                    }
                    elseif($params->getTimeLimitMethod()==TimeLimitMethod::OVERALL_LIMIT){
                        if($params->getTotalTimeLimit()>0 && $r>$params->getTotalTimeLimit()){
                            return $params->getTotalTimeLimit();
                        }
                        return $r;
                    }
                }
                break;

            case AssessmentState::PAUSED:
                return intval($this->getValue($this->timeDiffQuery('asm_last_request_time')));
                break;

            case AssessmentState::FINISHED:
                return intval($this->getValue($this->timeDiffQuery('asm_end_time')));
                break;

        }
        return 0;
    }


    private function timeDiffQuery($time2){
        return "TIME_TO_SEC(TIMEDIFF($time2,asm_start_time))-asm_start_time_add";
    }

    /**
     * Gets Ip from which user started assessment
     * @return null
     */
    public function getStartIp(){
        return $this->getValue("asm_start_ip");
    }

    /**
     * Sets Ip from which user started assessment
     * @return null
     */
    private function setStartIp($ip=''){
        $this->setValue(
            'asm_start_ip',
            $ip==''?$_SERVER['REMOTE_ADDR']:$ip
        );
    }

    public function getCreationDatetime(){
        return $this->getValue("asm_creation_datetime");
    }

    /**
     * @return User
     */
    public function getCreator(){
        return new User($this->connection,$this->getValue("asm_creator_us_id"));
    }

    /**
     * Clean all assessment progress
     */
    public function _purge(){
        $this->setState(AssessmentState::NOT_STARTED);
        $this->setStartTime('(NULL)');
        $this->setLastRequestTime('(NULL)');
        $this->setEndTime('(NULL)');
        $this->setStartIp('(NULL)');
        $this->items()->clear();
    }

    /**
     * Current assessment's list of questions
     * @return AssessmentQAItems
     */
    public function items(){
        return new AssessmentQAItems($this->connection,$this->assessmentId);
    }

    public function levelItems(){
        return new AssessmentQALevelItems($this->connection,$this->assessmentId,$this->levelIterator()->currentLevel());
    }

    /**
     * Iterator is helper class for control assessment process
     * @return AssessmentQAIterator
     */
    public function iterator(){
        return new AssessmentQAIterator($this->connection,$this->assessmentId);
    }

    public function levelIterator(){
         return new AssessmentQALevelIterator($this->connection,$this->assessmentId);
    }

    /**
     * @return AssessmentFreeMoveCMData|AssessmentLevelPassingCMData|AssessmentSequentialCMData|null
     */
    public function getCMData(){
        $str=$this->getValue("asm_cm_data");
        switch($this->getControlMechanism()){
            case ControlMechanism::LEVEL_PASSING:
                $r=new AssessmentLevelPassingCMData();
                if(strlen($str)>0) $r->load($str);
                return $r;
                break;

            case ControlMechanism::SEQUENTIAL:
                $r=new AssessmentSequentialCMData();
                if(strlen($str)>0) $r->load($str);
                return $r;
                break;

            case ControlMechanism::FREE_MOVE:
                $r=new AssessmentFreeMoveCMData();
                if(strlen($str)>0) $r->load($str);
                return $r;
                break;

            default:
                return null;
                break;
        }
    }

    public function setCMData(AssessmentCMData $CMData=null){
        //set to default if null
        if($CMData==null){
            switch($this->getControlMechanism()){
                case ControlMechanism::LEVEL_PASSING:
                    $CMData=new AssessmentLevelPassingCMData();
                    break;
                case ControlMechanism::SEQUENTIAL:
                    $CMData=new AssessmentSequentialCMData();
                    break;
                case ControlMechanism::FREE_MOVE:
                    $CMData=new AssessmentFreeMoveCMData();
                    break;
            }
        }
        $this->setValue('asm_cm_data',$this->connection->Escape($CMData->toString()));
    }

    public function isEndOfAssessment(){
        switch($this->getControlMechanism()){
            case ControlMechanism::LEVEL_PASSING:
                break;

            case ControlMechanism::SEQUENTIAL:
                break;

            case ControlMechanism::FREE_MOVE:
                return false;
                break;

            default:
                return null;
                break;
        }
        return null;
    }



}

