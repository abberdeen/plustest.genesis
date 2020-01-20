<?php
namespace System\Assessment\Items\Type;

use System\Enums\TaskType;
use System\Assessment\Items\Task;
use System\Assessment\Items\Type\Variants\NumericResponseValue;


/**
 * Class NumericResponse
 */
class NumericResponse extends Task{

    public $responses;

    /**
     * @param string $id
     * @param array $responses
     */
    public function __construct($id,$responses=array()){
        parent::__construct($id,TaskType::NUMERIC_RESPONSE);
        $this->responses=$responses;
    }


    /**
     * @param NumericResponseValue $responseValue
     */
    public function addResponse(NumericResponseValue $responseValue){
        $this->responses[]=$responseValue;
    }

    /**
     * @param $index
     */
    public function removeResponse($index){
        unset($this->responses[$index]);
    }

    /**
     * @param $index
     * @return mixed
     */
    public function &responses($index){
        return $this->responses[$index];
    }
}