<?php
namespace System;


abstract class Object{
    protected function dump(){
        echo "<pre>";
        print_r($this);
        echo "</pre>";
    }

    protected function format($str){
        $str=str_replace("  ","&t",$str); //3 space to &t
        $str=str_replace(" "," ",$str);//2 space 1 space
        $str=str_replace("	","&t",$str);//tab to &t
        $str=str_replace("&t","&t&t",$str);
        return $str;
    }

    protected function pre($str){
        return str_replace("&t","  ",$str);
    }
}