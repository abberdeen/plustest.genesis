<?php

namespace Adapter\QA\QAResponse;
use Adapter\QA\QAResponse\QAResponse;
use \AppException;




class NumericResponseQAResponse extends QAResponse{

    public $responses=[];

    public function toString()
    {
        return json_encode(
            [
                'version'=>$this->getVersion(),
                'responses'=>$this->responses,
            ],
            JSON_FORCE_OBJECT);
    }

    public function load($str)
    {
        $a=json_decode($str,true);

        if(array_key_exists('responses',$a)){
            $this->responses=$a['responses'];
        }
        else{
            throw new AppException('NumericResponseQAResponse have incorrect data format.');
        }
    }
}