<?php
namespace System\Assessment\Items\Type;

use System\Assessment\Items\Type\xChoice;
use System\Enums\DataFormat;
use System\Enums\TaskType;
use System\Assessment\Items\Task;
/**
 * Class MultipleResponse
 */
class MultipleResponse extends xChoice{
    /**
     * @param string $id
     * @param array $variants
     */
    public function __construct($id,$variants=array()){
        parent::__construct($id,$variants,TaskType::MULTIPLE_RESPONSE);
    }
}