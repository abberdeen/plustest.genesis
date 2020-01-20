<?php

namespace System\Assessment\Items\Type\Variants;

/**
 * Class MatchingVariant
 */
class MatchingVariant{
    /**
     * @var string $left
     */
    private $left;
    /**
     * @var string $right
     */
    private $right;

    /**
     * @param string $left
     * @param string $right
     */
    public function __construct($left='',$right=''){
        $this->setLeft($left);
        $this->setRight($right);
    }

    /**
     * @return string
     */
    public function getLeft(){
        return $this->left;
    }

    /**
     * @param $left
     */
    public function setLeft($left){
        $this->left=trim(strval($left));
    }

    /**
     * @return string
     */
    public function getRight(){
        return $this->right;
    }

    /**
     * @param $right
     */
    public function setRight($right){
        $this->right=trim(strval($right));
    }
}