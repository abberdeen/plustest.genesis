<?php

namespace Adapter\MaterialSourceFormat\MSFQuery;

use System\Enums\TaskType;
use System\Enums\DataFormat;
use Adapter\MaterialSourceFormat\MSFCols;
//
use System\Assessment\Items\Type\MultipleChoice;
use System\Assessment\Items\Type\MultipleResponse;
use System\Assessment\Items\Type\MatchingType;
use System\Assessment\Items\Type\NumericResponse;
//
use System\Assessment\Items\Type\Variants\OpenResponseValue;
use System\Assessment\Items\Type\Variants\xChoiceVariant;
use System\Assessment\Items\Type\Variants\MatchingVariant;
use System\Assessment\Items\Type\Variants\NumericResponseValue;

class MSF_PLUSTEST_Query extends MSFQuery{

    /**
     * @param $taskId
     * @return MultipleChoice|null
     */
    public function getMultipleChoiceById($taskId){
        $row=$this->connection->Query("SELECT
                                  /*id_farmoish, dcp_id, dcp_code, `index`, level, tid, */
                                  id_modul,
                                  `level`,
                                  id,
                                  content,
                                  v1, v2, v3, v4,
                                  state,
                                  lang,
                                  daqiqa,
                                  soniya,
                                  `status`
                                FROM
                                  ".$this->materialSourcePath."
                                WHERE id='".$taskId."';");
        $task=null;
        if(count($row)>0){
            $task=new MultipleChoice($row[0]['id']);
            $task->setText($row[0]['content']);
            $task->addVariant(new xChoiceVariant($row[0]['v1'],true));
            $task->addVariant(new xChoiceVariant($row[0]['v2'],false));
            $task->addVariant(new xChoiceVariant($row[0]['v3'],false));
            $task->addVariant(new xChoiceVariant($row[0]['v4'],false));
            $task->level=0;
            $task->theme=$row[0]['id_modul'];
            $task->dataFormat=DataFormat::HTML;
            $task->timeLimit=(intval($row[0]['daqiqa'])*60)+intval($row[0]['soniya']);
        }
        return $task;
    }

    /**
     * @param $taskId
     * @return null
     */
    public function getMultipleResponseById($taskId){
        $row=$this->connection->Query("SELECT
                                          `index`,
                                          `id`,
                                          `level`,
                                          `content`,
                                          `v1`,
                                          `v2`,
                                          `v3`,
                                          `v4`,
                                          `s1`,
                                          `s2`,
                                          `s3`,
                                          `s4`
                                        FROM
                                          ".$this->materialSourcePath."
                                        WHERE id='".$taskId."';");
        $task=null;
        if(count($row)>0){
            $task=new MultipleResponse($row[0]['id']);
            $task->setText($row[0]['content']);
            $task->addVariant(new xChoiceVariant($row[0]['v1'],$row[0]['s1']==1));
            $task->addVariant(new xChoiceVariant($row[0]['v2'],$row[0]['s2']==1));
            $task->addVariant(new xChoiceVariant($row[0]['v3'],$row[0]['s3']==1));
            $task->addVariant(new xChoiceVariant($row[0]['v4'],$row[0]['s4']==1));
            $task->level=0;
            $task->theme=$row[0]['level'];
            $task->dataFormat=DataFormat::HTML;
            $task->timeLimit=0;
        }
        return $task;
    }

    /**
     * @param $taskId
     * @return MatchingType|null
     */
    public function getMatchingTypeById($taskId){
        $row=$this->connection->Query("SELECT
                                          /*`index`, dcp_code, dcp_id, state, tid,`type`*/
                                          id,
                                          content,
                                          l1, l2, l3, l4,
                                          r1, r2, r3, r4, r5, r6,
                                          `level`
                                        FROM
                                          ".$this->materialSourcePath."
                                        WHERE id='".$taskId."';");
        $task=null;
        if(count($row)>0){
            $task=new MatchingType($row[0]['id']);
            $task->setText($row[0]['content']);
            $task->addVariant(new MatchingVariant($row[0]['l1'],$row[0]['r1']));
            $task->addVariant(new MatchingVariant($row[0]['l2'],$row[0]['r2']));
            $task->addVariant(new MatchingVariant($row[0]['l3'],$row[0]['r3']));
            $task->addVariant(new MatchingVariant($row[0]['l4'],$row[0]['r4']));
            $task->addVariant(new MatchingVariant('',$row[0]['r5']));
            $task->addVariant(new MatchingVariant('',$row[0]['r6']));
            $task->level=0;
            $task->theme=$row[0]['level'];
            $task->dataFormat=DataFormat::HTML;
            $task->timeLimit=0;
        }
        return $task;
    }

    /**
     * @param $taskId
     * @return null|NumericResponse
     */
    public function getNumericResponseById($taskId){
        $task=null;

        $x=explode('_',$taskId);
        if(count($x)!==2) return $task;

        $id_variant=$x[0];

        $number_deton=$x[1];
        $row=$this->connection->Query("SELECT
                                          `index`,
                                          id_variant,
                                          id,
                                          number_deton,
                                          dcp_id,
                                          dcp_code,
                                          `level`,
                                          content,
                                          v1,
                                          v2,
                                          answer_count,
                                          modul,
                                          state,
                                          tid
                                        FROM ".$this->materialSourcePath."
                                WHERE id_variant='".$id_variant."' AND number_deton='".$number_deton."';");

        if(count($row)>0){
            $task=new NumericResponse($row[0]['id_variant'].'_'.$row[0]['number_deton']);
            $task->setText($row[0]['content']);
            $task->addResponse(new NumericResponseValue($row[0]['v1']));
            if($row[0]['answer_count']==2){
                $task->addResponse(new NumericResponseValue($row[0]['v2']));
            }
            $task->level=$row[0]['level'];
            $task->theme=0;
            $task->dataFormat=DataFormat::HTML;
            $task->timeLimit=0;
        }
        return $task;
    }

    /**
     * @param $taskId
     * @return null
     */
    public function getOpenResponseById($taskId){
        //not exists
        return null;
    }

    /**
     * @return MSFCols
     */
    protected function getCols(){
        $cols=new MSFCols();
        return $cols;
    }
    public function getColsByTaskType($taskType){
        switch($taskType){
            case TaskType::MULTIPLE_CHOICE:
                return $this->getMultipleChoiceCols();
                break;
            case TaskType::MULTIPLE_RESPONSE:
                return $this->getMultipleResponseCols();
                break;
            case TaskType::MATCHING_TYPE:
                return $this->getMatchingTypeCols();
                break;
            case TaskType::NUMERIC_RESPONSE:
                return $this->getNumericResponseCols();
                break;
            case TaskType::OPEN_RESPONSE:
                return $this->getOpenResponseCols();
                break;
            default:
        }
        return null;
    }
    public function getMultipleChoiceCols(){
        $cols=$this->getCols();
        $cols->id='id';
        $cols->theme='id_modul';
        $cols->level='level';
        $cols->text='content';
        return $cols;
    }
    public function getMultipleResponseCols(){
        $cols=$this->getCols();
        $cols->id='id';
        $cols->theme='level';
        $cols->level='level';
        $cols->text='content';
        return $cols;
    }
    public function getMatchingTypeCols(){
        $cols=$this->getCols();
        $cols->id='id';
        $cols->theme='level';
        $cols->level='level';
        $cols->text='content';
        return $cols;
    }
    public function getNumericResponseCols(){
        $cols=$this->getCols();
        $cols->id="concat(id_variant,'_',number_deton)";
        $cols->theme='level';
        $cols->level='level';
        $cols->text='content';
        return $cols;
    }
    public function getOpenResponseCols(){
        return null;
    }

}