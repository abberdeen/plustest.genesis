<?php

namespace Adapter\QA\QAResponse;




abstract class QAResponse{

    public $responded=false;

    public function getVersion(){
        return 'QARF_1.0';
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