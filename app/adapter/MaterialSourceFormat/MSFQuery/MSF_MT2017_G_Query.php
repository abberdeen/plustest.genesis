<?php

namespace Adapter\MaterialSourceFormat\MSFQuery;
use Adapter\MaterialSourceFormat\MSFQuery\MSFQuery;



class MSF_MT2017_G_Query extends MSFQuery{
    public function getMultipleChoiceById($taskId){return null;}
    public function getMultipleResponseById($taskId){return null;}
    public function getMatchingTypeById($taskId){return null;}
    public function getNumericResponseById($taskId){return null;}
    public function getOpenResponseById($taskId){return null;}

    protected function getCols(){return null;}
    public function getColsByTaskType($taskType){return null;}
    public function getMultipleChoiceCols(){return null;}
    public function getMultipleResponseCols(){return null;}
    public function getMatchingTypeCols(){return null;}
    public function getNumericResponseCols(){return null;}
    public function getOpenResponseCols(){return null;}
}