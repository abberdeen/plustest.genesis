<?php

namespace Adapter\Assessment;
use System\QueryAdapter;



use Adapter\QA\QA;

class AssessmentQAItems extends QueryAdapter{

    /**
     * @var int $assessmentId
     */
    private $assessmentId;
    private $connection;

    public function  __construct(&$connection,$assessmentId){
        $this->assessmentId=$assessmentId;
        $this->connection=&$connection;
        parent::__construct($connection,'e_qa','qa_',$assessmentId);
    }

    /**
     * @param int $queue
     * @return QA
     */
    public function getByQueue($queue){
        $qaId=$this->connection->getValue("SELECT  qa_id FROM e_qa  WHERE qa_asm_id='$this->assessmentId' AND qa_queue='$queue';");
        return new QA($this->connection,$qaId);
    }

    public function getFirst(){
        $qaId=$this->connection->getValue("SELECT  qa_id FROM e_qa  WHERE qa_asm_id='$this->assessmentId'  ORDER BY qa_queue ASC LIMIT 1;");
        return new QA($this->connection,$qaId);
    }

    public function getLast(){
        $qaId=$this->connection->getValue("SELECT  qa_id FROM e_qa  WHERE qa_asm_id='$this->assessmentId'  ORDER BY qa_queue DESC LIMIT 1;");
        return new QA($this->connection,$qaId);
    }

    public function addByParam($userId,$materialId,$taskId,$queue){
        $this->connection->Execute("INSERT INTO e_qa( qa_asm_id,qa_us_id,qa_mat_id,qa_task_id,qa_queue)
                                    VALUES ( '".$this->assessmentId."','".$userId."','".$materialId."','".$taskId."','".$queue."');");
    }

    public function clear(){
        $this->connection->Execute("DELETE FROM e_qa  WHERE qa_asm_id='$this->assessmentId';");
    }

}