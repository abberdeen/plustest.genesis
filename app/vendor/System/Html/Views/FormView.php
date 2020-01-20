<?php
namespace System\Html\Views;
use System\Html\Views\View;


abstract class FormView extends View{
    private $value;
    private $enabled=true;
    protected $addClass;
    protected $size="";
    //Property Value
    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value=$value;
    }

    //Property Enabled
    public function getEnabled(){
        return $this->enabled;
    }

    public function setEnabled($value){
        $this->enabled=$value;
    }

    public function setClass($addClass){
        $this->addClass=$addClass;
    }

    public function setSize($size){
        $this->size=$size;
    }

}