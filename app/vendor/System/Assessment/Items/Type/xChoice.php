<?php
namespace System\Assessment\Items\Type;
use System\Assessment\Items\Task;
use System\Assessment\Items\Type\Variants\xChoiceVariant;


/**
 * Class SingleChoice
 */
class xChoice extends Task{
    /**
     * @var xChoiceVariant $variants
     */
    public $variants;

    /**
     * @param string $id
     * @param array $variants
     * @param $task_type
     */
    public function __construct($id,$variants=array(),$task_type){
        parent::__construct($id,$task_type);
        $this->variants=$variants;
    }

    /**
     * @param xChoiceVariant $variant
     */
    public function addVariant(xChoiceVariant $variant){
        $this->variants[]=$variant;
    }

    /**
     * @param $index
     * Starts from 0
     */
    public function removeVariant($index){
        unset($this->variants[$index]);
    }

    /**
     * @param $index
     * @return mixed
     */
    public function &variants($index){
        return $this->variants[$index];
    }
}