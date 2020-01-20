<?php

namespace Adapter\App;


class Log{

    private $connection;
    public $group;
    public $subgroup;
    private $cookie;

    /**
     * @param $connection
     */
    public function __construct(&$connection){
        $this->connection=&$connection;
        if(isset($_COOKIE)){
            $this->cookie=$_COOKIE;
        }
    }

    /**
     * @param $userId
     * @param $data
     * @param string $subgroup
     * @param string $group
     * @return bool
     */
    public function newLog($userId,$data,$subgroup="",$group=""){
        if(!isset($userId)||$userId<=0){
            if(ENABLE_CTR_LOGGING_IFNULL==false){
                return false;
            }
        }
        $data=$this->getQueryString()."\n".$this->getPostData()."\n".$data;
      //  $data=$this->connection->Escape($data);
        if($group=="") $group=$this->group;
        if($subgroup=="") $subgroup=$this->subgroup;

        if(strlen(trim($subgroup))>0){
            $this->connection->Execute("INSERT INTO app_log (app_log_group,app_log_subgroup,app_log_us_id,app_log_datetime,app_log_data,app_log_ip,app_log_handler,app_log_uagent_key,app_log_phpsessid)
                                    VALUES ('".
                $group."','".
                $subgroup."','".
                $userId."',".
                "NOW(),'".
                $data."','".
                $this->connection->Escape($_SERVER['REMOTE_ADDR'])."','".
                $this->connection->Escape(urldecode($_SERVER['REQUEST_URI']))."','".
                md5($_SERVER['HTTP_USER_AGENT'])."','".
                session_id()."');");
        }

    }

    /**
     * @param $userId
     */
    public function addUserLoginLog($userId,$sessKey){
        $this->connection->Execute("INSERT INTO xd_user_login_log(ul_us_id,ul_token,ul_uagent_key,ul_session_start_time,ul_ip,ul_phpsessid,ul_server_variable,ul_us_sk)
                                    VALUES('".$userId."','".
            $_SESSION[SS_USER_TOKEN]."','".
            md5($_SERVER['HTTP_USER_AGENT']).
            "',NOW(),'".
            $this->connection->Escape($_SERVER['REMOTE_ADDR'])."','".
            session_id()."','".
            $this->getServerVariables()."','".
            $sessKey."');");
    }

    public function addAppCrashLog($userId,$code,$message){
        $message=$this->connection->Escape($message);
        $this->connection->Execute("INSERT INTO app_crash_log SET
                                      app_crl_code='".$code."',
                                      app_crl_message='".$message."',
                                      app_crl_handler='".$this->connection->Escape(urldecode($_SERVER['REQUEST_URI']))."',
                                      app_crl_us_id='".$userId."',
                                      app_crl_datetime=NOW(),
                                      app_crl_ip='".$_SERVER['REMOTE_ADDR']."';");
    }

    /**
     * @param $user_token
     */
    public function setUserLoginLogEndTime($user_token){
        $this->connection->Execute("UPDATE xd_user_login_log SET ul_session_end_time=NOW() WHERE ul_token='".$user_token."';");
    }

    /**
     * @return string
     */
    public function getServerVariables(){
        $server="";
        foreach($_SERVER as $k=>$v){
            if($k=='argv'||$k=='argc') continue;
            $server.="[$k]=>$v;\n";
        }
        $server=$this->connection->Escape($server)."";
        return $server;
    }

    /**
     * @return string
     */
    public function getPostData(){
        if(count($_POST)<=0) return '';
        $post="\nPOST:={\n";
        foreach($_POST as $k=>$v){
            if($k=='argv'||$k=='argc') continue;
            $post.="[$k]=>$v;\n";
        }
        $post=$this->connection->Escape($post)."";
        return $post."};";
    }

    /**
     * @return string
     */
    public function getQueryString(){
        if(count($_GET)<=0) return '';
        $get="\nGET:={\n";
        foreach($_GET as $k=>$v){
            if($k=='argv'||$k=='argc') continue;
            $get.="[$k]=>$v;\n";
        }
        $get=$this->connection->Escape($get)."";
        return $get."};";
    }


    public function addConstructorLog($status=200){
        global $_user;
        global $match;
        $this->group="C";
        $user_id=null;
        if($_user instanceof User){
            $user_id=$_user->getId();
        }

        $x_params="";
        if(isset($match['params']) && count($match['params'])>0){
            $x_params="\nPARAMS:={\n";
            foreach($match['params'] as $k=>$v){
                $x_params.="[$k]=>$v;\n";
            }
            $x_params.="};";
        }

        if($status!==200){
            $x_params.="\nSTATUS:=".$status.";";
        }

        $this->newLog($user_id,$x_params,$match['name']);
    }
}