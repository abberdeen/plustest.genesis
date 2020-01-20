<?php

final class sys{

    static function _400($justcode=false){
        header('content-type=text','',400);
        die();
    }

    static function _403($justcode=false){
        if($justcode)
            header('content-type=text','',403);
        else
            app::constructPage('templates/system/403');
        die();
    }

    static function _404($justcode=false){
        if($justcode)
            header('content-type=text','',404);
        else
            app::constructPage('templates/system/404');
        die();
    }

    static function _500($justcode=false){
        header('content-type=text','',500);
        die();
    }

    static function fatal($justcode=false,$code='',$message='', $source=''){
        if($justcode){
            header('content-type=text','');
            echo 'fatal';
        }
        else{
            app::constructPage('templates/system/fatal',
                [
                    'code'=>$code,
                    'message'=>$message,
                    'source'=>$source,
                ]
            );
        }
        die();
    }
    static function fatal_simple($code='',$message='',$source=''){
        $params = [
                    'code'=>$code,
                    'message'=>$message,
                    'source'=>$source,
                ];
        require_once app::scriptLink('templates/system/fatal_simple');
        require_once app::formLink('templates/system/fatal_simple');
    }
}