<?php

namespace Adapter\Assessment;

use Adapter\ControlMechanism\ControlMechanismConf;
use System\Object;
use Adapter\QA\QA;


class AssessmentQALevelIterator extends Object  implements \Iterator, \SeekableIterator, \Countable {

    private $connection;
    private $asm;

    /**
     * AssessmentControl constructor.
     * @param $connection
     * @param $assessmentId
     */
    public function __construct($connection,$assessmentId)
    {
        $this->connection=$connection;
        $this->asm=new Assessment($this->connection,$assessmentId); 
    }

    /**
     * Backs to first QA in level
     * @return void
     */
    public function rewind(){
        $firstQA=$this->queryGetQA("");
        if(isset($firstQA)){
            $this->seek($firstQA->getQueue());
        }
    }

    /**
     * Returns prev  QA in level
     * @return void
     */
    public function prev(){
        $key=$this->key();
        if(isset($key)){
            $this->seek($key-1);
        }
    }

    /**
     * Returns current QA in level
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
     * Return current QA key in level
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
     * Moves to next QA in level
     * @return void
     */
    public function next(){
        $key=$this->key();
        if(isset($key)){
            $this->seek($key+1);
        }
    }

    /**
     * Returns count of task in level
     * @return int
     */
    public function count(){
        return $this->connection->getValue("SELECT COUNT(*) c
                                            FROM e_qa
                                            WHERE qa_asm_id=".$this->asm->getId()."
                                            AND qa_task_xl_level=".$this->currentLevel());
    }

    /**
     * Selects QA by key in level
     * @param int $key
     * @return void
     */
    public function seek($key){
        $this->connection->Execute("UPDATE e_qa
                                    SET qa_current=0
                                    WHERE qa_asm_id=".$this->asm->getId()."
                                    AND  qa_task_xl_level=".$this->currentLevel().";");
        $this->connection->Execute("UPDATE e_qa
                                    SET qa_current=1
                                    WHERE qa_asm_id=".$this->asm->getId()."
                                    AND qa_queue=".$key." AND  qa_task_xl_level=".$this->currentLevel().";");
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

    /**
     * Returns current level
     * @return int
     */
    public function currentLevel(){
        $asmCMData=$this->asm->getCMData();
        return $asmCMData->currentLevel;
    }

    /**
     * Moves to next level
     */
    public function nextLevel(){
        $this->seek(0);//before incrementing level clear current selection
        $nextLevelKey=$this->currentLevel() + 1;
        $this->seekLevel($nextLevelKey);
        //Note: check 'count' in below condition now with nextLevel value, because nextLevel already seeked in above code
        if($this->count()==0){//check by zero is not good idea therefore it's minimal checking to  prevent double adding tasklist
            $this->asm->addTaskListByLevel($nextLevelKey);
        }
    }

    /**
     * Return level count
     * @return int
     */
    public function countOfLevel(){
        /**@var ControlMechanismConf $CMConf **/
        $CMConf = $this->asm->getConf();
        $levelCount = $CMConf->getLevelCountByCredit($this->asm->getCredit());
        return $levelCount;
    }

    /**
     * Selects level by @$key
     * @param int $key
     */
    public function seekLevel($key){
        $asmCMData=$this->asm->getCMData();
        $asmCMData->currentLevel=$key;
        $this->asm->setCMData($asmCMData);
    }

    /**
     * Returns QA by defined conditions
     * @param $conditions
     * @param string $order
     * @return QA|null
     */
    protected function queryGetQA($conditions,$order='ORDER BY qa_queue ASC'){
        if($conditions!=='') $conditions=" AND ".$conditions;
        $qaId=$this->connection->getValue("SELECT qa_id
                                            FROM  e_qa
                                            WHERE qa_asm_id=".$this->asm->getId()." AND qa_task_xl_level=".$this->currentLevel()."
                                            ".$conditions."
                                            ".$order."
                                            LIMIT 1; ");
        if(!isset($qaId)) return null;
        return new QA($this->connection,$qaId);
    }

    /**
     * Returns QA list of current level
     * @return array (QA)
     */
    public function getList(){
        $res=$this->queryGetQA("SELECT qa_id FROM e_qa WHERE qa_asm_id=".$this->asm->getId()." AND qa_task_xl_level=".$this->currentLevel()." ORDER BY qa_queue ASC;");
        $qaList=[];
        foreach ($res as $r) {
            $qaList[]=new QA($this->connection,$r['qa_id']);
        }
        return $qaList;
    }
}

