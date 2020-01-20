<?php

namespace Adapter\Assessment;
use System\QueryAdapter;



use Adapter\QA\QA;

class AssessmentQALevelItems extends QueryAdapter{

    /**
     * @var int $assessmentId
     */
    private $assessmentId;
    private $connection;
    private $xlLevel;//xlLevel

    public function  __construct(&$connection,$assessmentId,$xlLevel){
        $this->assessmentId=$assessmentId;
        $this->connection=&$connection;
        $this->xlLevel=$xlLevel;
        parent::__construct($connection,'e_qa','qa_',$assessmentId);
    }

    /**
     * @param int $queue
     * @return QA
     */
    public function getByQueue($queue){
        $qaId=$this->connection->getValue("SELECT  qa_id FROM e_qa  WHERE qa_asm_id='$this->assessmentId' AND qa_queue='$queue' AND qa_task_xl_level=".$this->xlLevel);
        return new QA($this->connection,$qaId);
    }

    public function getFirst(){
        $qaId=$this->connection->getValue("SELECT  qa_id FROM e_qa  WHERE qa_asm_id='$this->assessmentId' AND qa_task_xl_level=".$this->xlLevel."  ORDER BY qa_queue ASC LIMIT 1;");
        return new QA($this->connection,$qaId);
    }

    public function getLast(){
        $qaId=$this->connection->getValue("SELECT  qa_id FROM e_qa  WHERE qa_asm_id='$this->assessmentId'  AND qa_task_xl_level=".$this->xlLevel."  ORDER BY qa_queue DESC LIMIT 1;");
        return new QA($this->connection,$qaId);
    }

    public function addByParam($userId,$materialId,$taskId,$queue){
        $this->connection->Execute("INSERT INTO e_qa( qa_asm_id,qa_us_id,qa_mat_id,qa_task_id,qa_queue,qa_task_xl_level)
                                    VALUES ( '".$this->assessmentId."','".$userId."','".$materialId."','".$taskId."','".$queue."','".$this->xlLevel."');");
    }

    public function clear(){
        $this->connection->Execute("DELETE FROM e_qa  WHERE qa_asm_id='$this->assessmentId' AND qa_task_xl_level=".$this->xlLevel.";");
    }

    /**
     * Return correct answers count in level
     * @param $xlLevel
     * @return int
     */
    public function totalPointsByLevel($xlLevel){
        return $this->calculatePointByLevel($xlLevel,1);
    }

    /**
     * Return incorrect answers count in level
     * Note: will use in level control mechanism
     * @param $level
     * @return int
     */
    public function totalNegativePointsByLevel($level){
        return $this->calculatePointByLevel($level,0);
    }

    private function calculatePointByLevel($xlLevel,$point){
        $r = $this->connection->Query("SELECT COUNT(1) c
                                        FROM e_qa
                                        WHERE qa_asm_id='".$this->assessmentId."' AND
                                            qa_task_xl_level=".$xlLevel." AND
                                            qa_responded=1 AND
                                            qa_point=".$point);
        if($r[0]["c"] != null){
            return $r[0]["c"];
        }
        return 0;
    }

}