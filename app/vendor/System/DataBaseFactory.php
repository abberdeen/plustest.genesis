<?php
namespace System;
use System\MySqlConnection;


class DataBaseFactory{
    /**
     * @param string $server
     * @return MySqlConnection
     */
    public static function CreateConnection($server="mt"){
        switch($server){
            case "mt":
                return new MySqlConnection("192.168.50.50","mt_user","mtdaf","_igx");
                break;
            case "local":
                return new MySqlConnection("localhost","root","","_igx");
                break;
        }
    }
}