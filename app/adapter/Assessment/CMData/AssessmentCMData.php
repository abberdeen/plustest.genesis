<?php

namespace Adapter\Assessment\CMData;


abstract class AssessmentCMData{
    public function getVersion(){
        return 'ACMD_1.0';
    }

    /**
     * @return string
     */
    public abstract function toString();

    /**
     * @param string $str
     * @return void
     */
    public abstract function load($str);
}
