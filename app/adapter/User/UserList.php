<?php

namespace Adapter\User;
use Adapter\User\User;


use System\Browser;
class UserList{
    private $connection;

    public function __construct(&$connection){
        $this->connection=&$connection;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function userValidate($username,$password){
        $r=$this->connection->Query("SELECT COUNT(*)>0 AS r
                                        FROM xd_users
                                        WHERE us_name='$username' AND us_password='$password';");
        return ($r[0]['r']==1);
    }

    /**
     * @param $username
     * @return bool
     */
    public function usernameExists($username){
        $r=$this->connection->Query("SELECT COUNT(*)>0 AS r
                                        FROM xd_users
                                        WHERE us_name='$username';");
        return ($r[0]['r']==1);
    }

    /**
     * @param $token
     * @return bool
     */
    public function tokenExists($token){
        if(strlen(trim($token))!=USER_TOKEN_LENGTH){
            return false;
        }
        $r=$this->connection->Query("SELECT count(*)>0 AS r
                                         FROM xd_users
                                         WHERE us_token='$token';");
        return ($r[0]['r']==1);
    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    public function getId($username,$password){
        $r=$this->connection->Query("SELECT us_id
                                         FROM xd_users
                                         WHERE us_name='$username' AND us_password='$password';");
        return $r[0]['us_id'];
    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    public function getUserToken($username,$password){
        $r=$this->connection->Query("SELECT CASE WHEN CHAR_LENGTH(us_token)>=32 THEN us_token ELSE NULL END r
                                         FROM xd_users
                                         WHERE us_name='$username' AND us_password='$password';");
        return $r[0]['r'];
    }

    /**
     * @param $token
     * @return User
     */
    public function getUserByToken($token){
        $r=$this->connection->Query("SELECT us_id
                                         FROM xd_users
                                         WHERE us_token='$token';");
        return new User($this->connection,$r[0]['us_id']);
    }

    /**
     * @param $name
     * @return User
     */
    public function getUserByName($name){
        $r=$this->connection->Query("SELECT us_id
                                         FROM xd_users
                                         WHERE us_name='$name';");
        return new User($this->connection,$r[0]['us_id']);
    }

    /**
     * @param $name
     */
    public function getUserBySessKey($name){

    }

    /**
     * @return bool
     */
    public function checkUserAgent(){
        $userAgent=$_SERVER['HTTP_USER_AGENT'];
        $userAgentKey=md5($userAgent);
        $_r=$this->connection->Query("SELECT COUNT(*)>0 AS r
                                        FROM xd_user_agent
                                        WHERE uagent_key='".$userAgentKey."';");
        if($_r[0]['r']!=1){
            $b=new Browser($userAgent);
            $this->connection->Execute("INSERT INTO xd_user_agent
                                            SET
                                            uagent_key='".$userAgentKey."',
                                            uagent_text='".$userAgent."',
                                            uagent_browser='".$b->getBrowser()."',
                                            uagent_browser_version='".$b->getVersion()."',
                                            uagent_device='".($b->isMobile()?'mobile':null)."',
                                            uagent_platform='".$b->getPlatform()."';");
        }
        return $_r[0]['r']==1;
    }
}