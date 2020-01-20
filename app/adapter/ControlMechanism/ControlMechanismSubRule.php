<?php

namespace Adapter\ControlMechanism;
use System\QueryAdapter;
use Adapter\ControlMechanism\ControlMechanismRule;
use Adapter\User\User;



class ControlMechanismSubRule extends QueryAdapter{
    private $subruleId;
    private $connection;

    public function  __construct(&$connection,$subruleId){
        $this->subruleId=$subruleId;
        $this->connection=&$connection;
        parent::__construct($connection,'c_cm_subrule','subrule_',$subruleId);
    }

    public function getId(){
        return $this->subruleId;
    }

    public function getControlMechanismRule(){
        return new ControlMechanismRule($this->connection,$this->getValue("subrule_cmrule_id"));
    }

    public function getTheme(){
        return $this->getValue("subrule_theme_id");
    }

    public function getLevelInTheme(){
        return $this->getValue("subrule_level_in_theme");
    }

    public function getTaskCount(){
        return $this->getValue("subrule_task_count");
    }

    public function getXlLevel(){
        return $this->getValue("subrule_xl_level");
    }

    public function getXlCorrectCount(){
        return $this->getValue("subrule_xl_correct_count");
    }

    /**
     * TimeLimit in seconds
     * @return null
     */
    public function getTimeLimit(){
        return $this->getValue("subrule_time_limit");
    }

    public function getDescription(){
        return $this->getValue("subrule_description");
    }

    public function getCreator(){
        return new User($this->connection,$this->getValue("subrule_creator_us_id"));
    }

    public function getCreationDatetime(){
        return $this->getValue("subrule_creation_datetime");
    }

}