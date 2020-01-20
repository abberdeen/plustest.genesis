<?php
/**
 * Class jx
 * ajax helper
 */
class ajax{

    /**
     * @return string
     */
    const KEY='96b0755ae91eefe3955075447d721114';

    /**
     * @return null
     */
    public static  function getToken()
    {
        if(isset($_SESSION[self::KEY]))
        {
            return $_SESSION[self::KEY];
        }
        return null;
    }

    /**
     *
     */
    public static function newToken()
    {
        $_SESSION[self::KEY]=strtoupper(dechex(rand(0,16777216)+rand(0,144284057)));
    }

    /**
     * @param $token
     * @return bool
     */
    public static function checkToken($token)
    {
        if(isset($_SESSION[self::KEY]))
        {
            if($token==$_SESSION[self::KEY])
            {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * @param $function
     * @param bool|false $prefix
     * @return mixed|string
     * @throws Exception
     */
    public static function route($function,$prefix=false){
        global $router;
        $r=self::_server().$router->generate('ajax_post',
            [
                'key'=>self::getToken(),
                'fx'=>$function,
            ]);
        if($prefix==false){
            $r=str_replace(self::routePrefix(),'',$r);
        }
        return $r;
    }

    /**
     * @return string
     */
    private static function _server(){
        return  "http://".$_SERVER['SERVER_NAME'];
    }

    /**
     * @return string
     */
    public static  function routePrefix(){
        return self::_server().'/'.AJAX_DIR_NAME.'/'.self::getToken();
    }
}