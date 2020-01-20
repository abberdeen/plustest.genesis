<?php

namespace Adapter\MaterialSourceFormat\MSFQuery;
use \AppException;
use Adapter\Material\Material;


abstract class MSFQuery{

    protected $connection;

    protected $materialSourcePath;

    public function __construct(&$_connection,$material){
        $this->connection=$_connection;
        if($material instanceof Material){
            $this->materialSourcePath=$material->getSource()->getPath();
        }
        else{
            throw new  AppException('Undefined Material',2301);
        }
    }

    /**
     * @param $taskId
     * @return MultipleChoice
     */
    public abstract function getMultipleChoiceById($taskId);

    /**
     * @param $taskId
     * @return MultipleResponse
     */
    public abstract function getMultipleResponseById($taskId);

    /**
     * @param $taskId
     * @return MatchingType
     */
    public abstract function getMatchingTypeById($taskId);

    /**
     * @param $taskId
     * @return NumericResponse
     */
    public abstract function getNumericResponseById($taskId);

    /**
     * @param $taskId
     * @return OpenResponse
     */
    public abstract function getOpenResponseById($taskId);

    protected abstract function getCols();
    protected abstract function getColsByTaskType($taskType);
    public abstract function getMultipleChoiceCols();
    public abstract function getMultipleResponseCols();
    public abstract function getMatchingTypeCols();
    public abstract function getNumericResponseCols();
    public abstract function getOpenResponseCols();

    public function __toString(){return $this;}
}