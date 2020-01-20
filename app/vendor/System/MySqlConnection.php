<?php
namespace System;
use System\Object;
use \MySqlConnectException;
use \AppException;


class MySqlConnection extends Object implements IConnection
{
    public  $_linkIdentifier;

    private function _die(){
        throw new MySqlConnectException(mysqli_connect_error(),mysqli_connect_errno());
    }
    public function __construct($server,$user,$password,$dbName){
        $this->_linkIdentifier=mysqli_connect($server,$user,$password) or $this->_die();
        mysqli_select_db($this->_linkIdentifier,$dbName);
        mysqli_set_charset($this->_linkIdentifier,"utf8");
    }

    public function __destruct() {
        if(isset($this->_linkIdentifier)){
            mysqli_close($this->_linkIdentifier);
            unset($this->_linkIdentifier);
        }
    }

    public function destruct(){
        mysqli_close($this->_linkIdentifier);
        unset($this->_linkIdentifier);
    }

    public function Escape($str){
        return mysqli_real_escape_string($this->_linkIdentifier,$str);
    }

    public function Query($sql,$fetch_type='assoc'){
        //echo $sql.";</br>";
        $result=mysqli_query($this->_linkIdentifier,$sql);

        if(mysqli_errno($this->_linkIdentifier)>0){
            throw new AppException(mysqli_error($this->_linkIdentifier));
        }
        $arr=[];
        if($result){
            if($fetch_type=='assoc'){
                while ($row=mysqli_fetch_assoc($result))
                {
                    $arr[]=$row;
                }
            }
            elseif($fetch_type=='array'){
                while ($row=mysqli_fetch_array($result))
                {
                    $arr[]=$row;
                }
            }
        }
        return $arr;
    }

    public function Execute($sql){
        //echo $sql."</br>";
        return mysqli_query($this->_linkIdentifier,$sql);
    }

    public function MultiQuery($sql){
        //echo $sql."</br>";
        return mysqli_multi_query($this->_linkIdentifier,$sql);
    }

    public function GetValue($sql){
        $r=$this->Query($sql,'array');
        if(count($r)>0){
            return $r[0][0];
        }
        return null;
    }

    public function IsConnected(){
        return mysqli_connect_errno()==0?true:false;
    }
}

