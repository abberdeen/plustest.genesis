<?php

namespace Adapter\QA;

use System\Enums\TaskType;
use \AppException;
//
use Adapter\QA\QAResponse\MultipleChoiceQAResponse;
use Adapter\QA\QAResponse\MultipleResponseQAResponse;
use Adapter\QA\QAResponse\MatchingTypeQAResponse;
use Adapter\QA\QAResponse\NumericResponseQAResponse;
use Adapter\QA\QAResponse\OpenResponseQAResponse;
//
use System\Assessment\Items\Type\MultipleChoice;
use System\Assessment\Items\Type\Variants\xChoiceVariant;
use System\Assessment\Items\Type\MultipleResponse;
use System\Assessment\Items\Type\MatchingType;
use System\Assessment\Items\Type\Variants\MatchingVariant;
use System\Assessment\Items\Type\NumericResponse;
use System\Assessment\Items\Type\Variants\NumericResponseValue;

class QAPoint{
    /**
     * @param $qaResponse
     * @return float|null
     * @throws AppException
     */
    public static function calcPoint($task,&$qaResponse){
        $point=null;
        switch($task->type){
            case TaskType::MULTIPLE_CHOICE:
                $point=self::multipleChoicePoint($task,$qaResponse);
                break;
            case TaskType::MULTIPLE_RESPONSE:
                $point=self::multipleResponsePoint($task,$qaResponse);
                break;
            case TaskType::MATCHING_TYPE:
                $point=self::matchingTypePoint($qaResponse);
                break;
            case TaskType::NUMERIC_RESPONSE:
                $point=self::numericResponsePoint($task,$qaResponse);
                break;
            case TaskType::OPEN_RESPONSE:
                break;
            default:
                throw new \AppException('Undefined task type',2201);
        }
        return $point;
    }

    protected static function multipleChoicePoint(MultipleChoice &$task,MultipleChoiceQAResponse &$qaResponse){
        if(isset($qaResponse->response)){
            $index=$qaResponse->variantsKey[$qaResponse->response];
            return $task->variants[$index]->getIsCorrect()?1:0;
        }
        return 0;
    }

    protected static function multipleResponsePoint(MultipleResponse &$task,MultipleResponseQAResponse &$qaResponse){
        $cvc=0;//Task correct variants count
        /** @var xChoiceVariant $v**/
        foreach($task->variants as $v){
            $cvc+=$v->getIsCorrect()?1:0;
        }
        $ucac=0;//User Correct Answer Count
        $uiac=0;//User Incorrect Answer Count
        /** @var xChoiceVariant $v**/
        foreach($qaResponse->responses as $r){
            $index=$qaResponse->variantsKey[$r];
            $task->variants[$index]->getIsCorrect()?$ucac++:$uiac++;
        }
        return self::calcMRPoint($uiac,$ucac,$cvc);
    }

    private static function calcMRPoint($uiac,$ucac,$cvc){
        if(($uiac+$ucac)<=$cvc){
            return (1/$cvc)*$ucac;
        }
        else{
            return (1/(($uiac+$ucac)*2))*$cvc;
        }
    }

    protected static function matchingTypePoint(MatchingTypeQAResponse &$qaResponse){
        $vc=count($qaResponse->leftKey);//variants count
        if($vc==0) return null;
        //count correct matches
        $cc=0; //Correct variant counter
        for($k=0;$k<$vc;$k++){
            if(isset($qaResponse->matches[$k])){
                if($qaResponse->leftKey[$k]==$qaResponse->rightKey[$qaResponse->matches[$k]]){
                    $cc++;
                }
            }
        }
        return $cc/$vc;
    }

    protected static function numericResponsePoint(NumericResponse &$task,NumericResponseQAResponse &$qaResponse){
        $cc=0;//Correct responses counter
        $rc=count($task->responses);//Total response count
        for($i=0;$i<$rc;$i++){
            if(isset($qaResponse->responses[$i])){
                if(self::EQ($task->responses[$i]->getResponse(),$qaResponse->responses[$i],3)){
                    $cc++;
                }
            }
        }
        return $cc/$rc;
    }

    /**
     * Checks $checkValue is equal to $baseValue
     * @param $baseValue
     * @param $checkValue
     * @param $deviation
     * @return bool
     */
    private static function EQ($baseValue,$checkValue,$deviation){
        $baseValue=self::CFloat($baseValue);
        $checkValue=self::CFloat($checkValue);

        $absDiff=abs($baseValue-$checkValue);
        $dvtValue=abs(($baseValue*$deviation)/100);

        if($absDiff<=$dvtValue){
            return true;
        }
        else{
            return false;
        }
    }
    private static function CFloat($v){
        return floatval(str_replace(",",".",trim(strval($v))));
    }

}