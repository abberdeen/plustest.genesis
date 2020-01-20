<?php

namespace Adapter\App;



class AppLetter{

    private $connection;
    public function __construct(&$connection){
        $this->connection=&$connection;
    }
    public function letterHash($caption,$text){
        return md5($caption.$text);
    }
    public function addLetter($type,$theme,$caption,$text){
        $hash=$this->letterHash($caption,$text);
        $badLang=preg_match_all('/bad.?lang/',$text)>0;
        if(!$this->letterExists($hash)){
            $caption=base64_encode($caption);
            $text=base64_encode($text);
            $this->connection->Execute("INSERT INTO xd_letter (lt_type,lt_theme,lt_caption,lt_text,lt_datetime,lt_hash,lt_bad_lang)
                                        VALUES ('".$type."', '".$theme."', '".$caption."', '".$text."', NOW(),'".$hash."','".$badLang."');");
        }
        else{
            $this->connection->Execute("UPDATE xd_letter SET lt_datetime=NOW() WHERE lt_hash='".$hash."';");
        }
    }
    private function letterExists($hash){
        $r=$this->connection->Query("SELECT COUNT(1) r FROM xd_letter WHERE lt_hash='".$hash."';");
        return $r[0]['r']>=1;
    }

}