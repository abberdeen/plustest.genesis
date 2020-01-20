<?php

namespace Adapter\User;


/**
 * Class UserPref - User preferences
 */
class UserPref{

    private $userId;
    private $connection;

    public function __construct(&$connection,$user_id){
        $this->userId=$user_id;
        $this->connection=$connection;
        //parent::__construct($connection,'xd_users_preferences','pref_',$user_id);
    }

    /**
     * @param $param
     * @return null
     */
    public function getParam($param){
        $r=$this->connection->Query("SELECT
                                      pref_value r
                                    FROM
                                      xd_users_preferences
                                    WHERE pref_us_id=".$this->userId." AND pref_param='".$param."';");
        if(count($r)>0 && strlen($r[0]['r'])>0){
            return $r[0]['r'];
        }
        return null;
    }

    /**
     * @param $param
     * @param $value
     */
    public function setParam($param,$value){
        if($this->paramExists($param)){
            $this->connection->Execute("UPDATE xd_users_preferences SET pref_value='".$value."' WHERE pref_us_id=".$this->userId." AND pref_param='".$param."';");
        }
        else{
            $this->connection->Execute("INSERT INTO xd_users_preferences SET pref_us_id=".$this->userId.",pref_param='".$param."',pref_value='".$value."';");
        }
    }

    /**
     * @param $param
     * @return bool
     */
    public function paramExists($param){
        $r=$this->connection->Query("SELECT
                                      1
                                    FROM
                                      xd_users_preferences
                                    WHERE pref_us_id=".$this->userId." AND pref_param='".$param."';");
        return  count($r)>0?true:false;
    }
}