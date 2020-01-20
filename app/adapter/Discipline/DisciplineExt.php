<?php

namespace Adapter\Discipline;

use System\QueryAdapter;
use Adapter\Material\Material;
use Adapter\ControlMechanism\ControlMechanismConf;


class DisciplineExt extends QueryAdapter{
    private $disciplineId;
    private $connection;

    public function  __construct(&$connection,$disciplineId){
        $this->disciplineId=$disciplineId;
        $this->connection=&$connection;
        parent::__construct($connection,'m_discipline','dcp_',$disciplineId);
    }

    /**
     *
     */
    public function getMaterialsId(){
        $matlist=[];
        foreach($this->connection->Query("SELECT
                                              mat_id
                                            FROM
                                              m_discipline,
                                              m_material
                                            WHERE dcp_id = mat_dcp_id
                                              AND dcp_id = '".$this->disciplineId."'
                                              AND mat_active = 1;") as $mat){
            $matlist[]=$mat['mat_id'];
        }
        return $matlist;
    }

    /**
     *
     */
    public function getMaterialsIdByTaskType($taskType=TaskType::UNDEFINED){
        $matIdList=[];
        foreach($this->connection->Query("SELECT
                                              mat_id
                                            FROM
                                              m_discipline,
                                              m_material
                                            WHERE dcp_id = mat_dcp_id
                                              AND dcp_id = '".$this->disciplineId."'
                                              AND mat_ttp_id='".$taskType."'
                                              AND mat_active = 1;") as $mat){
            $matIdList[]=$mat['mat_id'];
        }
        return $matIdList;
    }

    /**
     *
     */
    public function getMaterialsByTaskType($taskType=TaskType::UNDEFINED){
        $matList=[];
        foreach($this->connection->Query("SELECT
                                              mat_id
                                            FROM
                                              m_discipline,
                                              m_material
                                            WHERE dcp_id = mat_dcp_id
                                              AND dcp_id = '".$this->disciplineId."'
                                              AND mat_ttp_id='".$taskType."'
                                              AND mat_active = 1;") as $mat){
            $matList[]=new Material($this->connection,$mat['mat_id']);
        }
        return $matList;
    }

    /**
     * @param $policyId
     * @return ControlMechanismConf
     */
    public function getControlMechanismConfByPolicyId($policyId){
        $cmconf_id=$this->connection->GetValue("SELECT dpp_cmconf_id r
                                                FROM m_discipline_pack
                                                WHERE dpp_policy_id='".$policyId."' AND dpp_dcp_id='".$this->disciplineId."';");
        return new ControlMechanismConf($this->connection,$cmconf_id);
    }
}