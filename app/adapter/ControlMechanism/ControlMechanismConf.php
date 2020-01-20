<?php

namespace Adapter\ControlMechanism;
use System\QueryAdapter;
use Adapter\ControlMechanism\Policy;
use Adapter\ControlMechanism\ControlMechanismType;
use Adapter\ControlMechanism\ControlMechanismConfParams;
use Adapter\ControlMechanism\ControlMechanismRule;
use Adapter\User\User;
use System\Html\Views\TableView;
use System\Html\Views\Accordion;
use System\Enums\ControlMechanism;


class ControlMechanismConf extends QueryAdapter{
    private $cmConfId;
    private $connection;

    public function  __construct(&$connection,$cmConfId){
        $this->cmConfId=$cmConfId;
        $this->connection=&$connection;
        parent::__construct($connection,'c_cm_conf','cmconf_',$cmConfId);
    }

    public function getId(){
        return $this->cmConfId;
    }

    public function getName(){
        return $this->getValue("cmconf_name");
    }

    public function getDescription(){
        return $this->getValue("cmconf_description");
    }

    public function getPolicy(){
        return new Policy($this->connection,$this->getValue("cmconf_policy_id"));
    }

    public function getControlMechanism(){
        return new ControlMechanismType($this->connection,$this->getValue("cmconf_cm_id"));
    }

    public function getCreationDatetime(){
        return $this->getValue("cmconf_creation_datetime");
    }

    public function getCreator(){
        return new User($this->connection,$this->getValue("cmconf_creator_us_id"));
    }

    /**
     * @return ControlMechanismConfParams
     */
    public function getParams(){
        return new ControlMechanismConfParams($this->getValue("cmconf_params"));
    }

    /**
     * @param $params ControlMechanismConfParams
     */
    public function setParams($params){
        $this->setValue('cmconf_params',$params->__toString());
    }

    /**
     * @param int $credit
     * @return array
     */
    public function getRulesByCredit($credit=Credit::UNDEFINED){
        $res=$this->connection->Query("SELECT cmrule_id
                                      FROM c_cm_rule
                                      WHERE cmrule_cmconf_id=".$this->cmConfId." AND cmrule_cr_id=".$credit."
                                      ORDER BY cmrule_ttp_queue, cmrule_ttp_id;");
        $ruleList=[];
        foreach($res as $r){
            $ruleList[]=new ControlMechanismRule($this->connection,$r['cmrule_id']);
        }
        return $ruleList;
    }

    /**
     * @param $level
     * @return ControlMechanismSubRule|null
     */
    public function getSubruleByLevel($level){
        $res=$this->connection->Query("SELECT subrule_id FROM
                                          c_cm_conf,c_cm_rule,c_cm_subrule
                                       WHERE cmrule_cmconf_id=cmconf_id AND subrule_cmrule_id=cmrule_id
                                          AND  cmconf_id=".$this->getId()." AND  subrule_xl_level=".$level);
        if(isset($res[0]['subrule_id'])){
            return new ControlMechanismSubRule($this->connection,$res[0]['subrule_id']);
        }
        return null;
    }

    /**
     * Returns current CMConf's level count.
     * @return int|null
     */
    public function getLevelCountByCredit($credit){
        $res=$this->connection->Query("SELECT COUNT(1) c FROM
                                          c_cm_conf,c_cm_rule,c_cm_subrule
                                       WHERE cmrule_cmconf_id=cmconf_id AND subrule_cmrule_id=cmrule_id
                                          AND  cmconf_id=".$this->getId()." AND  cmrule_cr_id=".$credit);
        if(isset($res[0]['c'])){
            return intval($res[0]['c']);
        }
        return null;
    }

    public function __toString(){
        return $this->pre("ControlMechanismConf Object(
&t&t[Id] => ".$this->getId()."
&t&t[Name] => ".$this->getName()."
&t&t[Description] => ".$this->getDescription()."
&t&t[CreationDatetime] => ".$this->getCreationDatetime()."
&t&t[Policy] => ".$this->format($this->getPolicy())."
&t&t[ControlMechanism] => ".$this->format($this->getControlMechanism())."
&t&t[Creator:User:public] => ".$this->format($this->getCreator())."
&t)");
    }

    public function  toHtml($collapseActive=false){
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
                    [ 'value'=>"<a href='{{route gen|man_cm_conf_item|item=".$this->getName()."}}'>".$this->getName()."</a>"]],
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
                    [ 'value'=>$this->getCreator()->toHtml() ,'attr'=>'colspan="2"']],
                ],
                ['list'=>[
                    [ 'value'=>$this->getPolicy()->toHtml(),'attr'=>'colspan="2"']],
                ],
                ['list'=>[
                    [ 'value'=>$this->getControlMechanism()->toHtml(),'attr'=>'colspan="2"']],
                ],
            ];

        $accordion=new Accordion("ControlMechanismConf","","");
        $accordion->addItem(app::icon('icon8/User_Interface/horizontal_settings_mixer-48.png')."ControlMechanismConf",$table->render(),$collapseActive);
        return $accordion->render();
    }
}

