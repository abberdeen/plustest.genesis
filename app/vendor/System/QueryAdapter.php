<?php
namespace System;
use System\Object;

class QueryAdapter extends Object{

    private $connection;

    protected $tableName;

    protected $columnPrefix;

    protected $rowId;

    protected function __construct(&$connection,$tableName,$columnPrefix,$rowId){
        $this->connection=&$connection;
        $this->tableName=$tableName;
        $this->columnPrefix=$columnPrefix;
        $this->rowId=$rowId;

        if(!isset($rowId)||$rowId==''){
            throw new \AppException('QueryAdapter: RowId not defined. TableName: '.$tableName.'; RowName: '.$this->columnPrefix.'id;',2401);
        }


    }

    /**
     * @return MySqlConnection|IConnection
     */
    protected function &connection(){
        return $this->connection;
    }

    protected function getValue($columnName){
        $r=$this->connection->Query("SELECT $columnName AS r
                                     FROM $this->tableName
                                     WHERE ".$this->columnPrefix."id='$this->rowId';");
        if(count($r)>0){
            return $r[0]['r'];
        }
        return null;
    }

    /**
     * @param $columnName
     * @param string $value
     * @param bool|false $query
     */
    protected function setValue($columnName,$value='',$query=false){
        if(!$query||$value==''){
            $value="'".$value."'";
        }
        $this->connection->Execute("UPDATE $this->tableName
                                    SET $columnName=$value
                                    WHERE ".$this->columnPrefix."id='$this->rowId';");
    }

    protected function insert($_values){
        $columns='';
        $values='';
        $x=0;
        foreach($_values as $c => $v){
            $x++;
            $columns.= '`'.$c.'`';
            $values .='\''.$v.'\'';
            if($x<count($_values)){
                $columns.=',';
                $values.=',';
            }
        }
        $this->connection->Execute('Insert Into '. $this->tableName.'('.$columns.') Values ('.$values.');');
    }

}