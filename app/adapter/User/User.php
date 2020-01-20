<?php

namespace Adapter\User;
use System\QueryAdapter;
use System\Enums\UserType;
use System\Html\Views\TableView;
use System\Html\Views\Accordion;


class User extends QueryAdapter{

    private $userId;

    public function __construct(&$connection,$user_id){
        $this->userId=$user_id;
        parent::__construct($connection,'xd_users','us_',$user_id);
    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->userId;
    }

    public function getName(){
        return $this->getValue('us_name');
    }

    /**
     * @return string
     */
    public function getDisplayName(){
        $r=parent::connection()->Query("SELECT CONCAT(ui_last_name,' ', ui_first_name,' ', ui_third_name) AS full_name
                                         FROM xd_users_info
                                         WHERE ui_us_id='$this->userId';");
        return trim($r[0]['full_name']);
    }

    /**
     * @return mixed
     */
    public function getFirstName(){
        $r=parent::connection()->Query("SELECT ui_first_name AS `name`
                                         FROM xd_users_info
                                         WHERE ui_us_id='$this->userId';");
        return $r[0]['name'];
    }

    /**
     * @return string
     */
    public function getPassword(){
        return $this->getValue('us_password');
    }

    /**
     * @param string $value
     */
    public function setLastRequestTime($value="NOW()"){
        $this->setValue('us_last_request_time',$value,$value=='NOW()');
    }

    /**
     * @return int
     */
    public function getType(){
        $x=$this->getValue('us_type');
        switch($x){
            case UserType::User:
                return UserType::User;
                break;
            case UserType::Observer:
                return UserType::Observer;
                break;
            case UserType::Manager:
                return UserType::Manager;
                break;
            case UserType::Editor:
                return UserType::Editor;
                break;
            case UserType::System:
                return UserType::System;
                break;
            default:
                return UserType::Undefined;
                break;
        }
    }

    /**
     * @param string $value
     */
    public function setToken($value=""){
        if($value==""){
            $value='MD5(CONCAT(us_id,us_name,md5(NOW()),UUID()))';
        }
        $this->setValue('us_token',$value,true);
        $this->setTokenCreateAt();
        $this->setTokenExpireAt();
    }

    /**
     * @return null
     */
    public function getToken(){
        return $this->getValue('us_token');
    }

    /**
     *
     */
    public  function setAccessKey(){
        $this->connection()->Execute("INSERT INTO xd_users_access_control(uac_us_token,uac_key) VALUES ('".$this->getToken()."',MD5(CONCAT('".$this->getToken()."',UUID())));");
    }

    /**
     *
     */
    public  function setAccessKey2(){
        $_SESSION['_K2E']=$this->getValue('md5(NOW())');
        $this->connection()->Execute("UPDATE xd_users_access_control SET uac_key2=MD5(concat(uac_key,'".$_SESSION['_K2E']."')) WHERE uac_us_token='".$this->getToken()."'");
    }

    /**
     * @param $key3
     */
    public  function setAccessKey3($key3){
        $this->connection()->Execute("UPDATE xd_users_access_control SET uac_key3='".$key3."' WHERE uac_us_token='".$this->getToken()."'");
    }

    /**
     * @return bool
     */
    public function checkAccessKey(){
        if(!isset($_SESSION['_K2E'])) return false;
        $r=$this->connection()->Query("SELECT MD5(concat(uac_key3,'".$_SESSION['_K2E']."'))=uac_key2 r FROM xd_users_access_control WHERE uac_us_token='".$this->getToken()."' LIMIT 1;");
        return ($r[0]['r']==1);
    }

    /**
     * @return mixed
     */
    public function getAccessKey(){
        $r=$this->connection()->Query("SELECT uac_key r FROM xd_users_access_control WHERE uac_us_token='".$this->getToken()."' LIMIT 1;");
        return $r[0]['r'];
    }

    /**
     * @param string $value
     */
    public function setTokenCreateAt($value="NOW()"){
        $this->setValue('us_token_create_at',$value,$value=='NOW()');
    }

    /**
     * @param string $value
     */
    public function setTokenExpireAt($value=""){
        if($value==""){
            $value='DATE_ADD(us_token_create_at,INTERVAL us_token_duration MINUTE)';
        }
        $this->setValue('us_token_expire_at',$value,true);
    }

    /**
     * returns login duration in seconds
     * @return int
     */
    public function tokenExpired(){
        return  ($this->getValue('TIME_TO_SEC(TIMEDIFF(us_token_expire_at,NOW()))<=0')==1);
    }

    /**
     * @return bool
     */
    public function authBanned(){
        return ($this->getValue('us_login_banned')==1);
    }

    /**
     * @param int $duration
     */
    public function setAuthBan($duration=AUTH_BAN_DURATION){
        $this->setValue('us_login_banned',1);
        $this->setValue('us_login_ban_expire_at','DATE_ADD(NOW(),INTERVAL '.$duration.' MINUTE)',true);
    }

    /**
     *
     */
    public function getAuthBan(){
        $this->setValue('us_login_banned',0);
        $this->setValue('us_login_ban_expire_at','(NULL)');
        $this->setAuthTryCount(0);
    }

    /**
     * @return bool
     */
    public function authBanExpired(){
        return  ($this->getValue('TIME_TO_SEC(TIMEDIFF(us_login_ban_expire_at,NOW()))<=0')==1);
    }

    /**
     * @return null
     */
    public function getAuthTryCount(){
        return $this->getValue('us_login_try');
    }

    /**
     * @param string $value
     */
    public function setAuthTryCount($value='us_login_try+1'){
        $this->setValue('us_login_try',$value,true);
    }

    /**
     *
     */
    public function addAuthTry(){
        $this->setAuthTryCount();
    }

    /**
     * @return bool
     */
    public function ajaxAccess(){
        return ($this->getValue('us_ajax_access')==1);
    }

    /**
     *
     */
    public function openAjaxAccess(){
        $this->setValue('us_ajax_access',1);
    }

    /**
     *
     */
    public function closeAjaxAccess(){
        $this->setValue('us_ajax_access',0);
    }

    /**
     * @return bool
     */
    public function banned(){
        return ($this->getValue('us_banned')==1);
    }

    /**
     * @return null
     */
    public function banReason(){
        return $this->getValue('us_ban_reason');
    }

    /**
     * @param $banReason
     * @param $duration in minutes
     */
    public function setBan($banReason,$duration){
        $this->setValue('us_banned',1);
        $this->setValue('us_ban_reason',$banReason);
        $this->setValue('us_ban_create_at','NOW()',true);
        if(intval($duration)<=0)  $duration=0;
        $this->setValue('us_ban_expire_at','DATE_ADD(NOW(),INTERVAL '.$duration.' MINUTE)',true);
    }

    /**
     *
     */
    public function getBan(){
        $this->setValue('us_banned',0);
        $this->setValue('us_ban_reason','(NULL)');
        $this->setValue('us_ban_create_at','(NULL)');
        $this->setValue('us_ban_expire_at','(NULL)');
    }

    public function setSessKey($value=null){
        if(!isset($value)){
            $value="HEX(65535-((DAYOFYEAR(NOW())))-".$this->getId().")";
        }
        $this->setValue('us_sk',$value,true);
    }

    public function getSessKey(){
        return $this->getValue('us_sk');
    }

    /**
     * @return mixed
     */
    public function __toString(){
        return $this->pre("User Object(
&t&t[Id] => ".$this->getId()."
&t&t[Name] => ".$this->getName()."
&t)");
    }

    /**
     * @return string
     */
    public function  toHtml(){
        $table= new TableView('','','');
        $table->columns=['Param','Value'];
        $table->rows=[];
        $table->rows=
            [
                ['list'=>[
                    ['value'=>'Id','class'=>'param'],
                    [ 'value'=>$this->getId()]],
                ],
                ['list'=>[
                    ['value'=>'Name'],
                    [ 'value'=>"<a href='{{route gen|man_user_item|item=".$this->getName()."}}'>".$this->getName()."</a>"]],
                ],
                ['list'=>[
                    ['value'=>'Full name'],
                    [ 'value'=>$this->getDisplayName()]],
                ],
            ];

        $accordion=new Accordion("User","","");
        $accordion->addItem(app::icon('icon8/Users/gender_neutral_user-48.png')."User",$table->render());
        return $accordion->render();
    }


}
