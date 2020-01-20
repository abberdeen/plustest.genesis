<?php
namespace Adapter;
use Adapter\ControlMechanism\ControlMechanismType;
use Adapter\ControlMechanism\ControlMechanismConf;
use Adapter\User\User;
use Adapter\Material\Material;
use Adapter\ControlMechanism\Policy;


class AdapterGen{

    public static function getPolicyByName(&$connection,$policyName){
        return new Policy($connection,self::getId($connection,"c_policy","policy",$policyName));
    }

    public static function getCMTypeByName(&$connection,$controlMechanismName){
        return new ControlMechanismType($connection,self::getId($connection,"c_cm_type","cm",$controlMechanismName));
    }

    public static function getCMConfByName(&$connection,$cmConfName){
        return new ControlMechanismConf($connection,self::getId($connection,"c_cm_conf","cmconf",$cmConfName));
    }

    public static function getUserByName(&$connection,$controlUserName){
        return new User($connection,self::getId($connection,"xd_users","us",$controlUserName));
    }

    public static function getMaterialByName(&$connection,$materialName){
        return new Material($connection,self::getId($connection,"m_material","mat",$materialName));
    }


    private static function getId(&$connection,$table,$prefix,$name){
        $r=$connection->Query("SELECT ".$prefix."_id as r
                                         FROM $table
                                         WHERE ".$prefix."_name='$name';");
        if(count($r)>0){
            return $r[0]['r'];
        }
        return null;
    }
}