<?php

namespace Adapter\Discipline;
use System\QueryAdapter;



class Discipline extends QueryAdapter{

    private $disciplineId;
    private $connection;

    public function  __construct(&$connection,$disciplineId){
        global $_connection;
        $this->disciplineId=$disciplineId;
        $this->connection=&$_connection;
        parent::__construct($_connection,'m_discipline','dcp_',$disciplineId);
    }

    public function getId(){
        return $this->disciplineId;
    }

    public function getName(){
        return $this->getValue("dcp_name");
    }

    public function getDescription(){
        return $this->getValue("dcp_description");
    }

    public function __toString(){
        return $this->pre("Discipline Object(
&t&t[Id] => ".$this->getId()."
&t&t[Name] => ".$this->getName()."
&t&t[Description] => ".$this->getDescription()."
&t)");
    }


}