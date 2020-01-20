<?php
namespace System\Html\Views;


final class FormViewStyle{
    /**
     * @const DEFAULT_STYLE
     */
    const DEFAULT_STYLE=0;
    /**
     * @const RADIO_CLASSIC
     */
    const RADIO_CLASSIC=1000;
    /**
     * @const RADIO_STACKED
     */
    const RADIO_STACKED=1001;
    /**
     * @const CHECKBOX_CLASSIC
     */
    const CHECKBOX_CLASSIC=1002;
    /**
     * @const RADIO_STACKED
     */
    const CHECKBOX_STACKED=1003;
    /**
     * @const NUMERIC_CLASSIC
     */
    const NUMERIC_CLASSIC=1004;
    /**
     * @const OPEN_CLASSIC
     */
    const OPEN_CLASSIC=1005;
    /**
     * @const BUTTON_PRIMARY
     */
    const BUTTON_PRIMARY=1006;
    /**
     * @const SIDEBAR_SIMPLE
     */
    const SIDEBAR_SIMPLE=1007;
    /**
     * @const SIDEBAR_LIST_GROUP
     */
    const SIDEBAR_LIST_GROUP=1008;
    /**
     * @const BUTTON_SECONDARY
     */
    const BUTTON_SECONDARY=1009;
    /**
     * @const BUTTON_LINK
     */
    const BUTTON_LINK=1010;
    /**
     * @const BUTTON_LINK
     */
    const LABEL_BEFORE_INPUT=1011;
    /**
     * @param $messageStyle
     * @return string
     */
    public static function getClass($messageStyle){
        switch($messageStyle){
            case self::BUTTON_PRIMARY:
                return 'primary';
            case self::BUTTON_SECONDARY:
                return 'secondary';
                break;
            case self::BUTTON_LINK:
                return 'link';
                break;
            case self::DEFAULT_STYLE:
                return '';
        }
    }
}