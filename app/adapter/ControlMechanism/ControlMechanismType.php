<?php

namespace Adapter\ControlMechanism;
use System\QueryAdapter;
use Adapter\User\User;
use System\Html\Views\TableView;
use System\Html\Views\Accordion;
use System\Enums\ControlMechanism;


class ControlMechanismType extends QueryAdapter{
    private $controlMechanismId=ControlMechanism::UNDEFINED;
    private $connection;

    public function  __construct(&$connection,$controlMechanismId){
        $this->controlMechanismId=$controlMechanismId;
        $this->connection=&$connection;
        parent::__construct($connection,'c_cm_type','cm_',$controlMechanismId);
    }

    public function getId(){
        return $this->controlMechanismId;
    }

    public function getName(){
        return $this->getValue("cm_name");
    }

    public function getDescription(){
        return $this->getValue("cm_description");
    }

    public function getCreationDatetime(){
        return $this->getValue("cm_creation_datetime");
    }

    public function getCreator(){
        return new User($this->connection,$this->getValue("cm_creator_us_id"));
    }

    public function __toString(){
        return  $this->pre("ControlMechanism Object(
&t&t[Id] => ".$this->getId()."
&t&t[Name] => ".$this->getName()."
&t&t[Description] => ".$this->getDescription()."
&t&t[CreationDatetime] => ".$this->getCreationDatetime()."
&t&t[Creator:User:public] => ".$this->format($this->getCreator())."
&t)");
    }

    public function toHtml(){
        $table= new TableView('','','');
        $table->columns=['Param','Value'];
        $table->rows=[];
        $table->rows=
            [
                ['list'=>[
                    ['value'=>'Id','class'=>'param'],
                    [ 'value'=>$this->getId()]],
                ],
                ['list'=>[
                    ['value'=>'Name'],
                    [ 'value'=>"<a href='{{route gen|man_cm_type_item|item=".$this->getName()."}}'>".$this->getName()."</a>"]],
                ],
                ['list'=>[
                    ['value'=>'Description'],
                    [ 'value'=>$this->getDescription()]],
                ],
                ['list'=>[
                    ['value'=>'Creation Datetime'],
                    [ 'value'=>$this->getCreationDatetime()]],
                ],
                ['list'=>[
                    ['value'=>'Creator'],
                    [ 'value'=>$this->getCreator()->toHtml()]],
                ],
            ];

        $accordion=new Accordion("ControlMechanism","","");
        $accordion->addItem(app::icon('icon8/Very_Basic/settings-48.png')."ControlMechanism",$table->render());
        return $accordion->render();
    }
}