<?php
namespace System\Assessment\Items\Type;

use System\Enums\TaskType;
use System\Assessment\Items\Task;
use System\Assessment\Items\Type\Variants\OpenResponseValue;

/**
 * Class OpenResponse
 */
class OpenResponse extends Task{
    /**
     * @var OpenResponse $responses list of OpenResponse
     */
    public $responses;

    /**
     * @param string $id
     * @param array $responses
     */
    public function __construct($id,$responses=array()){
        parent::__construct($id,TaskType::OPEN_RESPONSE);
        $this->responses=$responses;
    }

    /**
     * @param OpenResponseValue $responseValue
     */
    public function addResponse(OpenResponseValue $responseValue){
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
    public function &variants($index){
        return $this->responses[$index];
    }
}