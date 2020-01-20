<?php
namespace System\Assessment\Items\Type;

use System\Enums\TaskType;
use System\Assessment\Items\Task;
use System\Assessment\Items\Type\xChoice;
use System\Enums\DataFormat;

/**
 * Class MultipleChoice
 */
class MultipleChoice extends xChoice{
    /**
     * @param string $id
     * @param array $variants
     */
    public function __construct($id, $variants=array()){
        parent::__construct($id, $variants,TaskType::MULTIPLE_CHOICE);
    }
}