<?php
namespace System\Html\Views\TaskView;
use System\Html\Views\TaskView\TaskViewStyle;
use System\Html\Views\RadioView;
use System\Html\Views\FormViewStyle;
use System\Html\Views\View;
use System\Assessment\Items\Type\MultipleChoice;
class MultipleChoiceView extends View{
    private $data;

    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(TaskViewStyle::SINGLE_CHOICE_CLASSIC);
        $this->data=new MultipleChoice("","",0,array());
    }

    //Property Data
    public function getData(){
        return $this->data;
    }

    /**
     * @param MultipleChoice $data
     */
    public function setData(MultipleChoice &$data){
        $this->data=$data;
    }

    /**
     * @return string
     */
    public function render(){
        $r="<div class='MultipleChoice'><p style='margin-top: 0px;' class='no-select '>".$this->getData()->getText()."</p>";
        switch(parent::getViewStyle()){
            case TaskViewStyle::SINGLE_CHOICE_CLASSIC:
            case TaskViewStyle::SINGLE_CHOICE_CLASSIC_STACKED:
                $viewStyle=FormViewStyle::RADIO_CLASSIC;
                if(parent::getViewStyle()==TaskViewStyle::SINGLE_CHOICE_CLASSIC_STACKED){
                    $viewStyle=FormViewStyle::RADIO_STACKED;
                }
                for($i=0;$i<count($this->getData()->variants);$i++){
                    $v=new RadioView(parent::getName().'V'.($i),parent::getName(),$this->getData()->variants($i)->getText());
                    $v->setValue($i);
                    $v->setViewStyle($viewStyle);
                    $v->checked=$this->getData()->variants($i)->isCorrect;
                    $r=$r.$v->render();
                }

                break;
        }
        $r.='</div>';
        return $r;
    }
}