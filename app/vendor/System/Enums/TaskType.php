<?php

namespace System\Enums;


/**
 * Class TaskType
 */
final class TaskType{
    /**
     * Not defined task type
     * @const UNDEFINED
     */
    const UNDEFINED = 0;
    /**
     * One choice of several list
     * @const SINGLE_CHOICE
     */
    const MULTIPLE_CHOICE = 1;
    /**
     * Multi choice of several list
     * @const MULTIPLE_CHOICE
     */
    const MULTIPLE_RESPONSE = 3;
    /**
     * A matching item is an item
     * @const MATCHING_TYPE
     */
    const MATCHING_TYPE = 4;
    /**
     * Freehand numeric response
     * @const NUMERIC_RESPONSE
     */
    const NUMERIC_RESPONSE = 5;
    /**
     * Freehand text response
     * @const OPEN_RESPONSE
     */
    const OPEN_RESPONSE = 6;
    /**
     * Ordering sequence of list
     * @const ORDERING_SEQUENCE
     */
    const ORDERING_SEQUENCE = 7;
    /**
     *
     * @const ALTERNATIVE
     */
    const ALTERNATIVE = 8;
    /**
     *
     * @const GAP_FILL
     */
    const GAP_FILL = 9;
    /**
     *
     * @const GAP_FILL_BY_LIST
     */
    const GAP_FILL_BY_LIST = 10;
    /**
     *
     * @const ESSAY
     */
    const ESSAY = 11;

    public static function getTaskTypeDesc($taskType){
        switch($taskType){
            case TaskType::MULTIPLE_CHOICE:
                return 'якҷавоба';
                break;
            case TaskType::MULTIPLE_RESPONSE:
                return 'бисёр ҷавоба';
                break;
            case TaskType::MATCHING_TYPE:
                return 'мувофиқоварӣ';
                break;
            case TaskType::NUMERIC_RESPONSE:
                return 'ҳалли масъала';
                break;

        }
    }
}
