<?php
namespace System\Html\Views\TaskView;

use System\Html\Views\TaskView\TaskViewStyle;
use System\Html\Views\NumericView;
use System\Html\Views\View;
use System\Assessment\Items\Type\NumericResponse;

class NumericResponseView extends View{
    private $data;

    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(TaskViewStyle::NUMERIC_RESPONSE_CLASSIC);
        $this->data=new NumericResponse("","",0,array());
    }

    //Property Data
    public function getData(){
        return $this->data;
    }

    public function setData(NumericResponse $data){
        $this->data=$data;
    }

    /**
     * @return string
     */
    public function render(){
        $r="";
        switch(parent::getViewStyle()){
            case TaskViewStyle::NUMERIC_RESPONSE_CLASSIC;
                $r="<h4 style='margin-top: 0px;' class='no-select '>".$this->getData()->getText()."</h4>";
                for($i=0;$i<count($this->getData()->responses);$i++){
                    $num_id="pgNum".$i;
                    $num_name=parent::getName()."_".$i;
                    $num_text="Response ".($i+1);
                    $num_view=new NumericView($num_id,$num_name,$num_text);
                    $num_view->setValue($this->getData()->responses[$i]->getResponse());
                    $r=$r.$num_view->render();
                }
                break;
        }
        return $r;
    }

}
