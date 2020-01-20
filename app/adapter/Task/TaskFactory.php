<?php

namespace Adapter\Task;
use Adapter\Material\Material;
use System\Enums\TaskType;

/**
 * Class TaskFactory
 */
final class TaskFactory{

    /**
     * @param $connection
     * @param $materialId
     * @param $taskId
     * @return MatchingType|MultipleChoice|MultipleResponse|null|NumericResponse|OpenResponse
     * @throws AppException
     */
    public static function createTaskById(&$connection,$materialId,$taskId){
        $material=new Material($connection,$materialId);
        $MSF=$material->getSourceFormatQuery();
        $task=null;
        switch($material->getTaskType()){


            case TaskType::MULTIPLE_CHOICE:
                $task=$MSF->getMultipleChoiceById($taskId);
                break;


            case TaskType::MULTIPLE_RESPONSE:
                $task=$MSF->getMultipleResponseById($taskId);
                break;


            case TaskType::MATCHING_TYPE:
                $task=$MSF->getMatchingTypeById($taskId);
                break;


            case TaskType::NUMERIC_RESPONSE:
                $task=$MSF->getNumericResponseById($taskId);
                break;


            case TaskType::OPEN_RESPONSE:
                $task=$MSF->getOpenResponseById($taskId);
                break;

            default:
                throw new \AppException('Undefined task type',2201);
        }

        if( !($task instanceof Task || isset($task) ) ){
            throw new \AppException('Task not found. MaterialId: '.$materialId.';TaskId: '.$taskId.';' ,2202);
        }

        return $task;

    }

}