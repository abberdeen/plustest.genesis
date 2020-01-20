<?php

namespace Adapter\ControlMechanism;
use System\QueryAdapter;
use Adapter\User\User;
use System\Html\Views\TableView;
use System\Html\Views\Accordion;



class Policy extends QueryAdapter{
    private $policyId;
    private $connection;

    public function  __construct(&$connection,$policyId){
        $this->policyId=$policyId;
        $this->connection=&$connection;
        parent::__construct($connection,'c_policy','policy_',$policyId);
    }

    public function getId(){
        return $this->policyId;
    }

    public function getName(){
        return $this->getValue("policy_name");
    }

    public function getTitle(){
        return $this->getValue("policy_title");
    }

    public function getDescription(){
        return $this->getValue("policy_description");
    }

    public function getCreationDatetime(){
        return $this->getValue("policy_creation_datetime");
    }

    public function getCreator(){
        return new User($this->connection,$this->getValue("policy_creator_us_id"));
    }

    public function __toString(){
        return  $this->pre("Policy Object(
&t&t[Id] => ".$this->getId()."
&t&t[Name] => ".$this->getName()."
&t&t[Description] => ".$this->getDescription()."
&t&t[CreationDatetime] => ".$this->getCreationDatetime()."
&t&t[Creator:User:public] => ".$this->format($this->getCreator())."
&t)");
    }

    public function  toHtml(){

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
                    [ 'value'=>"<a href='{{route gen|man_policy_item|item=".$this->getName()."}}'>".$this->getName()."</a>"]],
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
        $accordion=new Accordion("Policy","","");
        $accordion->addItem(app::icon('icon8/Finance/purchase_order-48.png')."Policy",$table->render());
        return $accordion->render();
    }

}