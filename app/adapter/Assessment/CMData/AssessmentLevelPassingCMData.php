<?php

namespace Adapter\Assessment\CMData;
use Adapter\Assessment\CMData\AssessmentCMData;



class AssessmentLevelPassingCMData extends AssessmentCMData{

    public $currentLevel = 1;
    public $queueInLevel = 0;
    public $correctCount;
    /**
     * @return string
     */
    public function toString()
    {
        return json_encode(
            [
                'version'=>$this->getVersion(),
                'currentLevel'=>$this->currentLevel,
            ],
            JSON_FORCE_OBJECT);
    }

    /**
     * @param string $str
     * @throws \AppException
     */
    public function load($str)
    {
        $a=json_decode($str,true);
        if(array_key_exists('currentLevel',$a)){
            $this->currentLevel=$a['currentLevel'];
        }
        else{
            throw new \AppException('AssessmentCMData have incorrect data format.');
        }
    }
}