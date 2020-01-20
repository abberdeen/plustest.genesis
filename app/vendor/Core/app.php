<?php

final class app{

    static function actionLink($layoutPath){
        return APP_LAYOUT_PATH.'/'.$layoutPath;
    }

    static function formLink($layoutPath){
        return self::actionLink($layoutPath.'/form.php');
    }

    static function scriptLink($layoutPath){
        return self::actionLink($layoutPath.'/script.php');
    }

    static function templateLink($templateName){
        return self::actionLink('/templates/'.$templateName.'.php');
    }

    static function constructPage($layoutPath,$params=[]){
        global $router;
        global $_connection;
        global $_users_list;
        global $_user_auth;
        global $_user;
        global $_user_pref;
        global $_app_lang;
        global $match;
        require_once self::scriptLink($layoutPath);
        require_once self::formLink($layoutPath);
    }

    static function  loadResource($type,$path,$prevspace='    '){
        switch($type){
            case "css":
                echo self::getResource($type,$path,$prevspace);
                break;
            case "js":
                echo self::getResource($type,$path,$prevspace);
                break;
        }
        return '';
    }

    static function  getResource($type,$path,$prevspace='    '){
        switch($type){
            case "css":
                return  $prevspace.'<link rel="stylesheet" href="'.self::resourceLink($path).'">'."\n";
                break;
            case "js":
                return '<script type="text/javascript" src="'.self::resourceLink($path).'" async=""></script>'."\n";
                break;
        }
        return '';
    }

    static function resourceLink($path){
        return APP_FULL_PATH.'/resources/'.$path;
    }

    static function redirect($url){
        header("location: ".$url);
        die();
    }

    private static function getPOST(&$connection,$name){
        if(isset($_POST[$name])){
            if(trim($_POST[$name])!=""){
                return $connection->Escape(htmlspecialchars($_POST[$name]));
            }
        }
        return "";
    }

    public static function POST($name){
        global $_connection;
        return app::getPOST($_connection,$name);
    }

    private static function getGET(&$connection,$name){
        if(isset($_GET[$name])){
            if(trim($_GET[$name])!=""){
                return $connection->Escape(htmlspecialchars($_GET[$name]));
            }
        }
        return "";
    }

    public static function GET($name){
        global $_connection;
        return app::getGET($_connection,$name);
    }

    static function t($group,$item){
        return ":xt:".$item;
    }

    static function msg($type,$caption,$text,$return=false){
        $msgcontent="<div class='bd-callout bd-callout-warning'>";
        strlen($caption)>0?$msgcontent.="<h4>".$caption."</h4>":0;
        strlen($text)>0?$msgcontent.= "<p>".$text."</p>":0;
        $msgcontent.="</div>";
        if($return) return $msgcontent;
        echo $msgcontent;
    }

    static function icon($path,$width=22,$output=false,$margin='0 5 0 0',$vertical_align='middle',$class=""){
        $r="<img src='".APP_FULL_PATH.'/resources/files/icons/'.$path."' alt='' style='width:".$width."px;padding:0;margin:".$margin.";vertical-align: ".$vertical_align.";' class='".$class."'/>";
        if($output==false){
            return $r;
        }
        echo $r;
    }

    static function varDump($var){
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }

    static function formatArticleTitle($title){
        $title=str_replace('_',' ',$title);
        $title=mb_strtoupper(mb_substr($title,0,1)).mb_substr($title,1);
        return $title;
    }

    static function formToken(){
        return strtoupper(md5($_SESSION[SS_USER_TOKEN].time()));
    }
}