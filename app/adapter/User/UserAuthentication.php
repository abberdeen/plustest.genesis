<?php

namespace Adapter\User;
use Adapter\User\UserList;
use Adapter\User\UserIpAuthorization;
use Adapter\User\User;
use System\Enums\UserType;



use Adapter\App\Log;
use System\Enums\AuthenticationState;

final class UserAuthentication{
    private $connection;
    private $userList;
    private $appLog;

    public function __construct(&$connection){
        $this->connection=&$connection;
        $this->userList=new UserList($connection);
        $this->appLog=new Log($connection);
        $this->appLog->group="UserAuthentication";
    }

    /**
     * @return bool|int
     */
    public function AuthenticationState(){

        if(!isset($_SESSION[SS_USER_TOKEN])){
            return false;
        }
        if(strlen(trim($_SESSION[SS_USER_TOKEN]))!=USER_TOKEN_LENGTH){
            return false;
        }

        //IP_BANNED?
        $user_ip_auth=new UserIpAuthorization($this->connection);
        if($user_ip_auth->ipBanned($_SERVER["REMOTE_ADDR"])){
            $this->appLog->newLog(null,$_SERVER["REMOTE_ADDR"],'IP_BANNED');
            self::unlog();
            return AuthenticationState::IP_BANNED;
        }


        //CHECK TOKEN
        if(!$this->userList->tokenExists($_SESSION[SS_USER_TOKEN])){
            if(isset($_SESSION[SS_USER_TOKEN])||strlen($_SESSION[SS_USER_TOKEN])!=0){
                self::unlog();
                return AuthenticationState::TOKEN_FAIL;
            }
            $this->appLog->newLog(null,"SS_USER_TOKEN:".$_SESSION[SS_USER_TOKEN].";",'BROKED_TOKEN');
            self::unlog();
            return AuthenticationState::BROKED_TOKEN;
        }


        //CHECK USER
        $user=$this->userList->getUserByToken($_SESSION[SS_USER_TOKEN]);


        //check USER LOGIN IP with CURRENT IP
        if($_SESSION[SS_USER_LOGIN_IP]!=md5($_SERVER['REMOTE_ADDR'])){
            $this->appLog->newLog($user->getId(),"SS_USER_TOKEN:".$_SESSION[SS_USER_TOKEN].";\nSS_USER_LOGIN_IP:".$_SESSION[SS_USER_LOGIN_IP].";\nREMOTE_ADDR:".$_SERVER['REMOTE_ADDR'].";",'USER_LOGIN_IP_BROK');
            self::unlog();
            return AuthenticationState::USER_LOGIN_IP_ERR;
        }


        //check USER LOGIN AGENT with CURRENT AGENT
        if($_SESSION[SS_USER_LOGIN_AGENT]!=md5($_SERVER['HTTP_USER_AGENT'])){
            $this->appLog->newLog($user->getId(),"SS_USER_TOKEN:".$_SESSION[SS_USER_TOKEN].";\nSS_USER_LOGIN_AGENT:".$_SESSION[SS_USER_LOGIN_AGENT].";\nHTTP_USER_AGENT:".$_SERVER['HTTP_USER_AGENT'].";",'USER_LOGIN_AGENT_BROK');
            self::unlog();
            return AuthenticationState::USER_LOGIN_AGENT_ERR;
        }


        //CHECK USER LOGIN DURATION (user online duration)
        if($user->tokenExpired()){
            $this->appLog->newLog($user->getId(),"SS_USER_TOKEN:".$_SESSION[SS_USER_TOKEN].";\n",'AUTH_TIMEOUT');
            self::unlog();
            return AuthenticationState::AUTH_TIMEOUT;
        }


        //AUTHENTICATION SUCCESS
        $user->setLastRequestTime();

        return AuthenticationState::SUCCESS;
    }

    /**
     * @param string $redirectPage
     * @param bool $authorization
     * @return bool
     */
    public function CheckAuthentication($redirectPage="",$authorization=true){
        if($this->AuthenticationState()!=AuthenticationState::SUCCESS || !$authorization){
            if($redirectPage!="") {
                self::unlog();
                app::redirect($redirectPage);
            }
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function ManagerAccessControl(){
        return false;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function login($username,$password)
    {
        if($this->userList->userValidate($username,$password)){
            session_regenerate_id(true);
            //check double login
            $this->logDoubleLogin($username,$password);
            //clear
            self::unlog();
            //
            $user_id=$this->userList->getId($username,$password);
            $this->_login($user_id);
            //
            //write log
            $this->appLog->newLog($user_id,"Username:$username;\nPassword:$password;\nTOKEN:".$_SESSION[SS_USER_TOKEN].";\n",'LOGIN');
            $user=new User($this->connection,$user_id);
            $this->appLog->addUserLoginLog($user_id,$user->getSessKey());
            //user log-in success
            return true;
        }
        else
        {
            $this->appLog->newLog(null,"username:$username;password:$password;",'Username_Not_Exists');
        }
        return false;
    }

    /**
     * @param $username
     * @param $password
     */
    private function logDoubleLogin($username,$password){
        $xtoken=$this->userList->getUserToken($username,$password);
        if($xtoken!==null){
            $xuser=$this->userList->getUserByToken($xtoken);
            if(!$xuser->tokenExpired()){
                $this->appLog->newLog($xuser->getId(),"Username:$username;\nPassword:$password;\nTOKEN:".$xtoken.";\n".$this->appLog->getServerVariables()  ,'DOUBLE_LOGIN');
            }
        }
    }

    /**
     * @param $user_id
     */
    private function _login($user_id){
        $user=new User($this->connection,$user_id);
        $user->setToken();
        if($user->getType()==UserType::Manager){
            $user->setAccessKey();
        }
        $user->setLastRequestTime();
        $user->setSessKey();
        $_SESSION[SS_USER_TOKEN]=$user->getToken();
        $_SESSION[SS_USER_LOGIN_IP]=md5($_SERVER['REMOTE_ADDR']);
        $_SESSION[SS_USER_LOGIN_AGENT]=md5($_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * soft logout - without redirect
     */
    public static function unlog(){

        if(isset($_SESSION[SS_USER_TOKEN])){
            unset($_SESSION[SS_USER_TOKEN]);
        }

        if(isset($_SESSION[SS_USER_LOGIN_IP])){
            unset($_SESSION[SS_USER_LOGIN_IP]);
        }

        if(isset($_SESSION[SS_USER_LOGIN_AGENT])){
            unset($_SESSION[SS_USER_LOGIN_AGENT]);
        }

        if(isset($_SESSION[SS_EVENT_ID])){
            unset($_SESSION[SS_EVENT_ID]);
        }

        if(isset($_SESSION[SS_ASSESSMENT_ID])){
            unset($_SESSION[SS_ASSESSMENT_ID]);
        }

        if(isset($_COOKIE)){
            unset($_COOKIE);
        }
    }

    public function logout(){
        if(isset($_SESSION[SS_USER_TOKEN])){
            $user=$this->userList->getUserByToken($_SESSION[SS_USER_TOKEN]);
            $user->setToken("(null)");
            $user->setTokenCreateAt("(null)");
            $user->setTokenExpireAt("(null)");
            $user->setLastRequestTime("(null)");
            $user->setSessKey("(null)");
            $this->appLog->setUserLoginLogEndTime($_SESSION[SS_USER_TOKEN]);
            $this->appLog->newLog($user->getId(),"SS_USER_TOKEN:".$_SESSION[SS_USER_TOKEN].";\n",'LOGOUT');
            self::unlog();
            @session_regenerate_id(true);
        }
    }
}
