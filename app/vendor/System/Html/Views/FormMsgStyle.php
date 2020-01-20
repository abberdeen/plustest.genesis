<?php
namespace System\Html\Views;


final class FormMsgStyle{

    /**
     * @const DEFAULT_STYLE
     */
    const DEFAULT_STYLE=0;
    /**
     * @const SUCCESS
     */
    const SUCCESS=1000;
    /**
     * @const WARNING
     */
    const WARNING=1001;
    /**
     * @const DANGER
     */
    const DANGER=1002;
    /**
     * @const INFO
     */
    const INFO=1002;


    public static function getClass($messageStyle,$prefix=''){
        switch($messageStyle){
            case self::SUCCESS:
                return $prefix.'success';
                break;
            case self::WARNING:
                return $prefix.'warning';
                break;
            case self::DANGER:
                return $prefix.'danger';
                break;
            case self::INFO:
                return $prefix.'info';
                break;
            case self::DEFAULT_STYLE:
                return '';
        }
    }
}
