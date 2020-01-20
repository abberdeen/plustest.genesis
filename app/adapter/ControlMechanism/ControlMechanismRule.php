<?php

namespace Adapter\ControlMechanism;
use System\QueryAdapter;
use Adapter\ControlMechanism\ControlMechanismType;
use Adapter\User\User;
use Adapter\ControlMechanism\ControlMechanismSubRule;



class ControlMechanismRule  extends QueryAdapter{
    private $cmRuleId;
    private $connection;

    public function  __construct(&$connection,$cmRuleId){
        $this->cmRuleId=$cmRuleId;
        $this->connection=&$connection;
        parent::__construct($connection,'c_cm_rule','cmrule_',$cmRuleId);
    }

    public function getId(){
        return $this->cmRuleId;
    }

    public function getControlMechanismConf(){
        return new ControlMechanismType($this->connection,$this->getValue("cmrule_cmconf_id"));
    }

    public function getCredit(){
        return $this->getValue("cmrule_cr_id");
    }

    public function getTaskType(){
        return $this->getValue("cmrule_ttp_id");
    }

    public function getOutMaxPoint(){
        return $this->getValue("cmrule_out_max_point");
    }

    public function getThemesOrderMethod(){
        return $this->getValue("cmrule_themes_order_method_id");
    }

    /**
     * TimeLimit in seconds
     * @return null
     */
    public function getTimeLimit(){
        return $this->getValue("cmrule_time_limit");
    }

    public function getSpecRules(){
        return null;
    }

    public function getDescription(){
        return $this->getValue("cmrule_description");
    }

    public function getCreator(){
        return new User($this->connection,$this->getValue("cmrule_creator_us_id"));
    }

    public function getCreationDatetime(){
        return $this->getValue("cmrule_creation_datetime");
    }

    public function getSubrules(){
        $res=$this->connection->Query("SELECT subrule_id
                                      FROM c_cm_subrule
                                      WHERE subrule_cmrule_id=".$this->cmRuleId."
                                      ORDER BY subrule_theme_id,subrule_level_in_theme;");
        $subruleList=[];
        foreach($res as $r){
            $subruleList[]=new ControlMechanismSubRule($this->connection,$r['subrule_id']);
        }
        return $subruleList;
    }

    public function getSubrulesCount(){
        $res=$this->connection->Query("SELECT COUNT(1) c FROM c_cm_subrule WHERE subrule_cmrule_id=".$this->cmRuleId.";");
        return $res[0]["c"];
    }

    public function getSubruleByLevel($level){
        $res=$this->connection->Query("SELECT subrule_id
                                      FROM c_cm_subrule
                                      WHERE subrule_cmrule_id=".$this->cmRuleId." AND  subrule_xl_level=".$level."
                                      ORDER BY subrule_theme_id,subrule_level_in_theme;");
        if(isset($this->connection,$res[0]['subrule_id'])){
            return new ControlMechanismSubRule($this->connection,$res[0]['subrule_id']);
        }
        return null;
    }

}