<?php
namespace System\Assessment\Items\Type;

use System\Enums\TaskType;
use System\Assessment\Items\Task;
use System\Assessment\Items\Type\Variants\MatchingVariant;

/**
 * Class MatchingType
 */
class MatchingType extends Task{

    public $variants;

    /**
     * @param string $id
     * @param array $variants
     */
    public function __construct($id, $variants=array()){
        parent::__construct($id, TaskType::MATCHING_TYPE);
        $this->variants=$variants;
    }

    /**
     * @param MatchingVariant $variant
     */
    public function addVariant(MatchingVariant $variant){
        $this->variants[]=$variant;
    }

    /**
     * @param $index
     */
    public function removeVariant($index){
        unset($this->variants[$index]);
    }

    /**
     * @param $index
     * @return MatchingVariant
     */
    public function &variantByIndex($index){
        $r=new MatchingVariant;
        $r=$this->variants[$index];
        return $r;
    }

    public function getLeftCount(){
        $c=0;
        foreach($this->variants as $v){
            if(strlen($v->getLeft())>0){
                $c++;
            }
        }
        return $c;
    }

    public function getRightCount(){
        $c=0;
        foreach($this->variants as $v){
            if(strlen($v->getRight())>0){
                $c++;
            }
        }
        return $c;
    }

}