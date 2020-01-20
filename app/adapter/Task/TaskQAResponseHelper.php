<?php

namespace Adapter\Task;
//
use Adapter\Assessment\Assessment;
use Adapter\QA\QAResponse\MatchingTypeQAResponse;
use Adapter\QA\QAResponse\MultipleChoiceQAResponse;
use Adapter\QA\QAResponse\MultipleResponseQAResponse;
use Adapter\QA\QAResponse\NumericResponseQAResponse;
use Adapter\QA\QAResponse\OpenResponseQAResponse;
//
use System\Enums\TaskType;

/**
 * Class TaskQAResponseHelper
 * @package Adapter\Task
 */
class TaskQAResponseHelper{

    /**
     * @param $task
     * @return MatchingTypeQAResponse|MultipleChoiceQAResponse|MultipleResponseQAResponse|NumericResponseQAResponse|bool|null
     */
    public static function getQAResponse($task){
        $response=null;
        switch($task->type){
            case TaskType::MULTIPLE_RESPONSE:
                $response=new MultipleResponseQAResponse();
                $response->variantsKey=self::genKey(count($task->variants));
                break;

            case TaskType::MULTIPLE_CHOICE:
                $response=new MultipleChoiceQAResponse();
                $response->variantsKey=self::genKey(count($task->variants));
                break;

            case TaskType::MATCHING_TYPE:
                $response=new MatchingTypeQAResponse();
                $response->leftKey=self::genKey( $task->getLeftCount());
                $response->rightKey=self::genKey( $task->getRightCount());
                break;

            case TaskType::NUMERIC_RESPONSE:
                $response=new NumericResponseQAResponse();
                $response->responses=[];
                break;

            case TaskType::OPEN_RESPONSE:

                break;

            default:
                return false;
        }
        return $response;
    }

    private static function genKey($length,$shuffle=true){
        $x=[];
        for($i=0;$i<$length;$i++){
            $x[]=$i;
        }
        if($shuffle) shuffle($x);
        return $x;
    }
}