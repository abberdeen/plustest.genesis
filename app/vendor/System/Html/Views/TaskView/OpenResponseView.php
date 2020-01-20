<?php
namespace System\Html\Views\TaskView;
use System\Html\Views\TaskView\TaskViewStyle;
use System\Html\Views\OpenView;


use System\Html\Views\View;
use System\Assessment\Items\Type\OpenResponse;
class OpenResponseView extends View{
    private $data;

    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(TaskViewStyle::OPEN_RESPONSE_CLASSIC);
        $this->data=new OpenResponse("","",0,array());
    }

    //Property Data
    public function getData(){
        return $this->data;
    }

    public function setData(OpenResponse $data){
        $this->data=$data;
    }

    /**
     * @return string
     */
    public function render(){
        $r="";
        switch(parent::getViewStyle()){
            case TaskViewStyle::OPEN_RESPONSE_CLASSIC;
                $r="<h4 style='margin-top: 0px;' class='no-select '>".$this->getData()->getText()."</h4>";
                for($i=0;$i<count($this->getData()->responses);$i++){
                    $open_id="num".$i;
                    $open_name=parent::getName()."_".$i;
                    $open_text="Response ".($i+1);
                    $open_view=new OpenView($open_id,$open_name,$open_text);
                    $open_view->setValue($this->getData()->responses[$i]->getResponse());
                    $r=$r.$open_view->render();
                }
                break;
        }
        return $r;
    }

}
