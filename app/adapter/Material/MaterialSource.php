<?php

namespace Adapter\Material;
use System\Object;



class MaterialSource extends Object{

    public function __construct(){}

    /**
     * @var string
     */
    public $database;

    /**
     * @var string
     */
    public $table;

    /**
     * @var string
     */
    public $conditions;


    public $colRank='igx_rank';

    public $colFrequency='igx_frequency';

    /**
     * @return null|string
     */
    public function  getPath(){
        if(isset($this->database) && isset($this->table)){
            return $this->database.'.'.$this->table;
        }
        return null;
    }

    /**
     * Set material source by path like:
     * db:;table:'1234';conditions:[X]=1 AND [X]=2;
     * @param $sourcePath
     * @throws Exception
     */
    public function parseAndSetPath($sourcePath){
        $this->database=$this->getParamValue($sourcePath,'db|database');

        $this->table=$this->getParamValue($sourcePath,'table');

        $this->conditions=$this->getParamValue($sourcePath,'conditions');
        if($this->conditions){
            $this->conditions=str_replace('[',$this->database.'.'.$this->table.'.',$this->conditions);
            $this->conditions=str_replace(']','',$this->conditions);
        }

    }

    private function getParamValue($sourcePath,$param){
        $m=null;
        preg_match_all("/(".$param."):(.*?);/",$sourcePath,$m);
        if(isset($m[2][0])){
            return $m[2][0];
        }
        return null;
    }

    public function __toString(){
        return $this->pre("MaterialSource Object(
&t&t[Database] => ".$this->database."
&t&t[Table] => ".$this->table."
&t&t[Conditions] => ".$this->conditions."
&t)");
    }

}