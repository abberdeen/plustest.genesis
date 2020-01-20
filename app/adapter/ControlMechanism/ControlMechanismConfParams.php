<?php

namespace Adapter\ControlMechanism;
use System\Object;
use System\Enums\TimeLimitMethod;


class ControlMechanismConfParams extends Object{

    /**
     * @var array
     */
    public $items=[];

    public function __construct($params){
        $this->items=[];
        $this->loadParams($params);
    }

    private function loadParams($params){
        $m=[];
        preg_match_all('/(\b[a-z_]*?)=([A-z0-9]*?)\;/',$params,$m);
        for($i=0;$i<count($m[0]);$i++){
            if(strlen($m[1][$i])>0){
                $this->items[$m[1][$i]]=$m[2][$i];
            }
        }
    }

    public function __toString(){
        $str="";
        foreach ($this->items as $key=>$value) {
            $str.=$key.'='.$value.';\n';
        }
        return $str;
    }
    private function getValue($key,$alterValue=null){
        if(array_key_exists($key,$this->items)){
            return $this->items[$key];
        }
        return $alterValue;
    }

    //TimeLimitMethod
    public function getTimeLimitMethod(){
        return intval($this->getValue('time_limit_method',TimeLimitMethod::UNLIMITED));
    }

    public function setTimeLimitMethod($value){
        $this->items['time_limit_method']=$value;
    }

    //TotalTimeLimit
    /**
     * Unit of measure is seconds
     *
     */
    public function getTotalTimeLimit(){
        return intval($this->getValue('total_time_limit',0));
    }

    public function setTotalTimeLimit($value){
        $this->items['total_time_limit']=$value;
    }

    //ThemeOrderMethod
    /**
     * @return int
     */
    public function getThemeOrderMethod(){
        return intval($this->getValue('theme_order_method',0));
    }

    public function setThemeOrderMethod($value){
        $this->items['theme_order_method']=$value;
    }
}