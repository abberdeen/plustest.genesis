<?php

namespace Adapter\QA;

use System\QueryAdapter;
use Adapter\Assessment\Assessment;
use Adapter\User\User;
use Adapter\Material\Material;
use Adapter\Task\TaskFactory;
use System\Enums\TaskType;
use Adapter\QA\QAResponse\QAResponse;
use Adapter\QA\QAResponse\MultipleChoiceQAResponse;
use Adapter\QA\QAResponse\MultipleResponseQAResponse;
use Adapter\QA\QAResponse\MatchingTypeQAResponse;
use Adapter\QA\QAResponse\NumericResponseQAResponse;
use Adapter\QA\QAResponse\OpenResponseQAResponse;
use \AppException;
use Adapter\QA\QAPoint;



class QA extends QueryAdapter{

    private $qaId;
    private $connection;

    public function  __construct(&$connection,$qaId){
        $this->qaId=$qaId;
        $this->connection=&$connection;
        parent::__construct($connection,'e_qa','qa_',$qaId);
    }

    public function getId(){
        return $this->qaId;
    }

    /**
     * @return Assessment
     */
    public function getAssessment(){
        return new Assessment($this->connection,$this->getValue("qa_asm_id"));
    }

    /**
     * @return User
     */
    public function getUser(){
        return new User($this->connection,$this->getValue("qa_us_id"));
    }

    /**
     * @return Material
     */
    public function getMaterial(){
        return new Material($this->connection, $this->getValue("qa_mat_id"));
    }

    /**
     * @return MatchingType|MultipleChoice|MultipleResponse|null|NumericResponse|OpenResponse
     * @throws AppException
     */
    public function getTask(){
        return TaskFactory::createTaskById($this->connection,$this->getMaterial()->getId(),$this->getValue("qa_task_id"));
    }

    public function getTaskXlLevel(){
        return $this->getValue("qa_task_xl_level");
    }

    public function getQueue(){
        return ($this->getValue("qa_queue"));
    }

    public function getStartTime(){
        return $this->getValue("qa_start_time");
    }

    public function setStartTime($value='NOW()'){
        $this->setValue('qa_start_time',$value,$value=='NOW()');
    }

    public function getEndTime(){
        return $this->getValue("qa_end_time");
    }

    public function setEndTime($value='NOW()'){
        $this->setValue('qa_end_time',$value,$value=='NOW()');
    }

    public function getPoint(){
        return $this->getValue("qa_point");
    }

    /**
     * @param float $value
     */
    public function setPoint($value){
        $this->setValue('qa_point',$value);
    }

    public function getHash(){
        return $this->getValue("qa_hash");
    }

    public function setHash($value){
        $this->setValue('qa_hash',$value);
        $r=$this->getResponseData();
    }

    /**
     * @return MatchingTypeQAResponse|MultipleChoiceQAResponse|MultipleResponseQAResponse|NumericResponseQAResponse|OpenResponseQAResponse
     * @throws AppException
     */
    public function getResponseData(){
        $str=$this->getValue("qa_response_data");
        switch($this->getTask()->type){
            case TaskType::MULTIPLE_CHOICE:
                $r=new MultipleChoiceQAResponse();
                if(strlen($str)>0) $r->load($str);
                return $r;
                break;
            case TaskType::MULTIPLE_RESPONSE:
                $r=new MultipleResponseQAResponse();
                if(strlen($str)>0) $r->load($str);
                return $r;
                break;
            case TaskType::MATCHING_TYPE:
                $r=new MatchingTypeQAResponse();
                if(strlen($str)>0) $r->load($str);
                return $r;
                break;
            case TaskType::NUMERIC_RESPONSE:
                $r=new NumericResponseQAResponse();
                if(strlen($str)>0) $r->load($str);
                return $r;
                break;
            case TaskType::OPEN_RESPONSE:
                $r=new OpenResponseQAResponse();
                if(strlen($str)>0) $r->load($str);
                return $r;
                break;
            default:
                throw new AppException('Undefined task type',2201);
        }
    }

    /**
     * @param QAResponse $qaResponse
     */
    public function setResponseData(QAResponse $qaResponse){
        $this->setValue('qa_response_data',$this->connection->Escape($qaResponse->toString()));
        $this->setPoint(QAPoint::calcPoint($this->getTask(),$qaResponse));
    }

    public function getResponseIp(){
        return $this->getValue("qa_response_ip");
    }

    public function setResponseIp($value){
        $this->setValue('qa_response_ip',$value);
    }

    /**
     * @return bool
     */
    public function responded(){
        return $this->getValue("qa_responded")=='1'?true:false;
    }

    /**
     * @param bool $value
     */
    public function setResponded($value=true){
        $this->setValue('qa_responded',$value?1:0);
    }

    /**
     * @return bool
     */
    public function skipped(){
        return $this->getValue("qa_skipped")=='1'?true:false;
    }

    /**
     * @param bool $value
     */
    public function setSkipped($value=true){
        $this->setValue('qa_skipped',$value?1:0);
    }

    /**
     * @return bool
     */
    public function mistaken(){
        return $this->getValue("qa_mistaken")=='1'?true:false;
    }

    /**
     * @param bool $value
     */
    public function setMistaken($value=true){
        $this->setValue('qa_mistaken',$value?1:0);
    }

}