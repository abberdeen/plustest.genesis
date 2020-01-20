<?php

namespace Adapter\Assessment;

use System\Object;
use Adapter\QA\QA;



class AssessmentQAIterator extends Object  implements \Iterator, \SeekableIterator, \Countable {

    private $connection;
    private $assessmentId;

    /**
     * AssessmentControl constructor.
     * @param $connection
     * @param $assessmentId
     */
    public function __construct($connection,$assessmentId)
    {
        $this->connection=$connection;
        $this->assessmentId=$assessmentId;
    }

    protected function queryGetQA($conditions,$order='ORDER BY qa_queue  ASC'){
        if($conditions!=='') $conditions=" AND ".$conditions;
        $qaId=$this->connection->getValue("SELECT qa_id FROM  e_qa WHERE qa_asm_id=$this->assessmentId $conditions $order LIMIT 1;");
        if(!isset($qaId)) return null;
        return new QA($this->connection,$qaId);
    }

    /**
     * @return void
     */
    public function rewind(){
        $firstQA=$this->queryGetQA("");
        if(isset($firstQA)){
            $this->seek($firstQA->getQueue());
        }
    }

    /**
     * @return void
     */
    public function prev(){
        $key=$this->key();
        if(isset($key)){
            $this->seek($key-1);
        }
    }

    /**
     * @return QA
     */
    public function current(){
        $qa=$this->queryGetQA("qa_current=1");
        if(!is_null($qa)){
            return $qa;
        }
        return null;
    }

    /**
     * @return int
     */
    public function key(){
        $qa=$this->current();
        if(!is_null($qa)){
            return $qa->getQueue();
        }
        return null;
    }

    /**
     * @return void
     */
    public function next(){
        $key=$this->key();
        if(isset($key)){
            $this->seek($key+1);
        }
    }

    /**
     * @return array (QA)
     */
    public function getList(){
        $res=$this->queryGetQA("SELECT qa_id FROM e_qa WHERE qa_asm_id=$this->assessmentId ORDER BY qa_queue ASC;");
        $qaList=[];
        foreach ($res as $r) {
            $qaList[]=new QA($this->connection,$r['qa_id']);
        }
        return $qaList;
    }

    /**
     * @return int
     */
    public function count(){
        return $this->connection->getValue("SELECT COUNT(*)c FROM e_qa WHERE qa_asm_id=".$this->assessmentId);
    }

    /**
     * @param int $key
     * @return void
     */
    public function seek($key){
        $this->connection->Execute("UPDATE e_qa SET qa_current=0 WHERE qa_asm_id=".$this->assessmentId.";");
        $this->connection->Execute("UPDATE e_qa SET qa_current=1 WHERE qa_asm_id=".$this->assessmentId." AND qa_queue=".$key.";");
    }

    /**
     * @return boolean
     * Returns true on success or false on failure.
     */
    public function valid(){
        $qa=$this->current();
        if(!is_null($qa)){
            return true;
        }
        return false;
    }

}

