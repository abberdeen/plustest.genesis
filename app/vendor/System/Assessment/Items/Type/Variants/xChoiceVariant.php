<?php
namespace System\Assessment\Items\Type\Variants;


/**
 * Class xChoiceVariant
 */
class xChoiceVariant{
    /**
     * @var string $text
     */
    private $text;
    /**
     * @var bool $isCorrect
     */
    public $isCorrect=false;

    /**
     * @param string $text
     * @param bool $isCorrect
     */
    public function  __construct($text='',$isCorrect=false){
        $this->setText($text);
        $this->setIsCorrect($isCorrect);
    }

    /**
     * @return string
     */
    public function getText(){
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text){
        $this->text=strval($text);
    }

    /**
     * @return bool
     */
    public function getIsCorrect(){
        return $this->isCorrect;
    }

    /**
     * @param bool $isCorrect
     */
    public function setIsCorrect($isCorrect){
        $this->isCorrect=$isCorrect;
    }
}