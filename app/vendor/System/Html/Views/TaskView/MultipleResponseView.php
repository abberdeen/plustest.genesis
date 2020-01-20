<?php
namespace System\Html\Views\TaskView;

use System\Html\Views\TaskView\TaskViewStyle;
use System\Html\Views\CheckView;
use System\Html\Views\View;
use System\Html\Views\FormViewStyle;
use System\Assessment\Items\Type\MultipleResponse;


class MultipleResponseView extends View{
    private $data;

    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(TaskViewStyle::MULTIPLE_CHOICE_CLASSIC);
        $this->data=new MultipleResponse("","",0,array());
    }

    //Property Data
    public function getData(){
        return $this->data;
    }

    public function setData(MultipleResponse $data){
        $this->data=$data;
    }

    public function render(){
        $r="<h4 style='margin-top: 0px;' class='no-select '>".$this->getData()->getText()."</h4>";
        switch(parent::getViewStyle()){
            case TaskViewStyle::MULTIPLE_CHOICE_CLASSIC:
            case TaskViewStyle::MULTIPLE_CHOICE_CLASSIC_STACKED:
                $viewStyle=FormViewStyle::CHECKBOX_CLASSIC;
                if(parent::getViewStyle()==TaskViewStyle::MULTIPLE_CHOICE_CLASSIC_STACKED){
                    $viewStyle=FormViewStyle::CHECKBOX_STACKED;
                }
                for($i=0;$i<count($this->getData()->variants);$i++){
                    $v=new CheckView($i,parent::getName()."_".$i,$this->getData()->variants($i)->getText());
                    $v->setValue($i);
                    $v->setViewStyle($viewStyle);
                    $v->checked=$this->getData()->variants($i)->isCorrect;
                    $r=$r.$v->render();
                }
                break;
        }
        return $r;
    }

}