<?php

namespace Adapter\Material;
use System\QueryAdapter;
use Adapter\Material\MaterialSource;
use Adapter\MaterialSourceFormat\MSF_Factory;
use Adapter\Discipline\Discipline;



class Material extends QueryAdapter{

    private $materialId;
    private $connection;

    private $mat_msf_id;
    private $mat_source;
    private $mat_ttp_id;

    public function  __construct(&$connection,$materialId){
        $this->materialId=$materialId;
        $this->connection=&$connection;
        parent::__construct($connection,'m_material','mat_',$materialId);

        $this->mat_msf_id=$this->getValue("mat_msf_id");
        $this->mat_source=$this->getValue("mat_source");
        $this->mat_ttp_id=$this->getValue("mat_ttp_id");
    }

    public function getId(){
        return $this->materialId;
    }

    public function getName(){
        return $this->getValue("mat_name");
    }

    public function getDescription(){
        return $this->getValue("mat_description");
    }

    /**
     * @return MaterialSource
     */
    public function getSource(){
        $ms=new MaterialSource();
        $ms->parseAndSetPath($this->mat_source);
        return $ms;
    }

    /**
     * @return MSF
     */
    public function getSourceFormat(){
        return  $this->mat_msf_id;
    }

    /**
     * @return MSF_IGX2018_Query|MSF_MT2012_G_Query|MSF_MT2017_G_Query|MSF_PLUSTEST_Query
     * @throws AppException
     */
    public function getSourceFormatQuery(){
        return MSF_Factory::createMSFQuery($this->connection,$this);
    }

    /**
     * @return Discipline
     */
    public function getDiscipline(){
        return new Discipline($this->connection,$this->getValue("mat_dcp_id"));
    }

    /**
     * @return TaskType
     */
    public function getTaskType(){
        return $this->mat_ttp_id;
    }

    /**
     * @return int
     */
    public function getTaskCount(){
        return intval($this->connection->getValue("SELECT COUNT(1) FROM ". $this->getSource()->getPath().($this->getSource()->conditions !== '' ? ' WHERE ' . $this->getSource()->conditions : '')));
    }

    /**
     * @return bool
     */
    public function getActiveState(){
        return $this->getValue("mat_active")=='1'?true:false;
    }

    /**
     * @param bool $state
     */
    public function setActiveState($state){}

    public function sourceExists(){
        return $this->connection->GetValue("SELECT '123' FROM ".$this->getSource()->getPath())=='123'?true:false;
    }

    public function __toString(){
        return $this->pre("Material Object(
&t&t[Id] => ".$this->getId()."
&t&t[Name] => ".$this->getName()."
&t&t[Description] => ".$this->getDescription()."
&t&t[Source] => ".$this->format($this->getSource())."
&t&t[SourceFormat] => ".$this->getSourceFormat()."
&t&t[Discipline] => ".$this->format($this->getDiscipline())."
&t&t[TaskType] => ".$this->getTaskType()."
&t&t[ActiveState] => ".($this->getActiveState()?'1':'0')."
&t)");
    }
}