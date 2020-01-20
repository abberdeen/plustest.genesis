<?php

namespace Adapter\User;


final class UserIpAuthorization{
    private $connection;

    public function  __construct(&$connection){
        $this->connection=&$connection;
    }

    /**
     * @param $ipAddres
     * @return bool
     */
    public function isHaveAccess($ipAddres){
        if($this->ipBanned($ipAddres)){
            return false;
        }
        $r=$this->connection->Query("SELECT (COUNT(*) > 0) r
                                        FROM xd_ip_zones, xd_ip_white_list
                                        WHERE ((za_name = 'ALL_ZONES' AND za_access = 1) OR
                                             (za_id = zf_za_id AND za_access = 1 AND zf_access = 1 AND zf_ip = '".$ipAddres."'));");
        if(count($r)>0){
            if($r[0]["r"]=='1') return true;
        }
        return false;
    }

    /**
     * @param $ipAddres
     * @return bool
     */
    public function ipBanned($ipAddres){
        $r=$this->connection->Query("SELECT
                                          (COUNT(*) > 0) r
                                     FROM
                                          xd_ip_black_list
                                     WHERE ipb_ip='".$ipAddres."';");
        if(count($r)>0){
            if($r[0]["r"]=='1') return true;
        }
        return false;
    }
}