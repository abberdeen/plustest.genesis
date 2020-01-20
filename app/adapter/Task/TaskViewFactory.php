<?php

namespace Adapter\Task;
//
use System\Enums\TaskType;
//
use System\Html\Views\TaskView\MultipleChoiceView;
use System\Html\Views\TaskView\TaskViewStyle;
use System\Html\Views\TaskView\MatchingTypeView;
use System\Html\Views\TaskView\MultipleResponseView;
use System\Html\Views\TaskView\NumericResponseView;
//
use System\Assessment\Items\Type\Variants\MatchingVariant;
use System\Html\Views\FormViewStyle;
use System\Assessment\Items\Task;

final class TaskViewFactory{

    /**
     * @param Task $task
     * @return null|MatchingTypeView|MultipleChoiceView|MultipleResponseView|NumericResponseView
     */
    public static function createDefaultTaskView(Task $task){
        $taskView=null;
        switch($task->type){ 
            case TaskType::MULTIPLE_CHOICE:
                $taskView=new MultipleChoiceView('Q'.$task->id,'Q'.$task->id,''); 
                $taskView->setData($task);
                $taskView->setViewStyle(TaskViewStyle::SINGLE_CHOICE_CLASSIC_STACKED);
                break;
            
            case TaskType::MATCHING_TYPE:
                $taskView=new MatchingTypeView('Q'.$task->id,'Q'.$task->id,'');
                //$taskView->matches=$responseData->matches;
                $taskView->setData($task);
                break;

            case TaskType::MULTIPLE_RESPONSE:
                $taskView=new MultipleResponseView('Q'.$task->id,'Q'.$task->id,'');
                $taskView->setData($task);
                $taskView->setViewStyle(TaskViewStyle::MULTIPLE_CHOICE_CLASSIC_STACKED);
                break;

            case TaskType::NUMERIC_RESPONSE:
                $taskView=new NumericResponseView('Q'.$task->id,'Q'.$task->id,'');
                $taskView->setData($task);
                break;

            default:
                sys::fatal(false,'0x0','Task type undefined. TaskType:'.$task->type.';');
        }
        return $taskView;
    }

    /**
     * Creates task (html) view
     *
     * Note: Orientation in code by task type (cases)
     * Note: For each task type prepares task data with reordering variants position by keys (randomizes task variants).
     * Note: After preparing task data sets data to corresponding task view (control)
     *
     * @param $task
     * @param $responseData
     * @param $taskQueue
     * @return MatchingTypeView|MultipleChoiceView|MultipleResponseView|NumericResponseView
     * @throws \AppException
     */
    public static function createResponseTaskView(&$task,&$responseData,$taskQueue){
        switch($task->type){
            case TaskType::MULTIPLE_CHOICE:
                $taskView=new MultipleChoiceView('Q'.$taskQueue,'Q'.$taskQueue,'');

                self::sortByKey($task->variants,$responseData->variantsKey);

                for($i=0;$i<count($task->variants);$i++){
                    $task->variants[$i]->isCorrect=false;
                }
                if (isset($task->variants[$responseData->response])){
                    $task->variants[$responseData->response]->isCorrect=true;
                }

                $taskView->setData($task);
                $taskView->setViewStyle(TaskViewStyle::SINGLE_CHOICE_CLASSIC_STACKED);

                return $taskView;
                break;

            case TaskType::MATCHING_TYPE:
                $taskView=new MatchingTypeView('Q'.$taskQueue,'Q'.$taskQueue,'');

                // Sort task variants by key (shuffle, relocate)
                $tmpVariants=[];
                for($i=0;$i<count($task->variants);$i++){
                    $tmpVariants[]=new MatchingVariant(null,null);
                }
                for($i=0;$i<count($responseData->leftKey);$i++){
                    $ki=$responseData->leftKey[$i];
                    $tmpVariants[$i]->setLeft($task->variants[$ki]->getLeft());
                }
                for($i=0;$i<count($responseData->rightKey);$i++){
                    $ki=$responseData->rightKey[$i];
                    $tmpVariants[$i]->setRight($task->variants[$ki]->getRight());
                }

                $task->variants=$tmpVariants;

                $taskView->matches=$responseData->matches;
                $taskView->setData($task);

                return $taskView;
                break;

            case TaskType::MULTIPLE_RESPONSE:
                $taskView=new MultipleResponseView('Q'.$taskQueue,'Q'.$taskQueue,'');

                self::sortByKey($task->variants,$responseData->variantsKey);

                for($i=0;$i<count($task->variants);$i++){
                    $task->variants[$i]->isCorrect=false;
                }
                foreach($responseData->responses as $response){
                    if (isset($task->variants[$response])){
                        $task->variants[$response]->isCorrect=true;
                    }
                }

                $taskView->setData($task);
                $taskView->setViewStyle(TaskViewStyle::MULTIPLE_CHOICE_CLASSIC_STACKED);

                return $taskView;
                break;

            case TaskType::NUMERIC_RESPONSE:
                $taskView=new NumericResponseView('Q'.$taskQueue,'Q'.$taskQueue,'');

                for($i=0;$i<count($task->responses);$i++){
                    if(isset($responseData->responses[$i])){
                        $task->responses[$i]->setResponse($responseData->responses[$i]);
                    }
                    else{
                        $task->responses[$i]->setResponse(null);
                    }
                }

                $taskView->setData($task);

                return $taskView;
                break;

            default:
                throw new \AppException('createResponseTaskView: Task type undefined. TaskType:'.$task->type.';');
        }
    }

    /**
     * Sorts task variants by key (shuffle, relocate)
     * @param $arr
     * @param $key
     */
    private static function  sortByKey(&$arr,&$key){
        $newArr=[];
        for($i=0;$i<count($arr);$i++){

            $newArr[]=$arr[$key[$i]];
        }
        $arr=$newArr;
    }
}