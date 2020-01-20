<?php

namespace Adapter\QA\QAResponse;
use Adapter\QA\QAResponse\QAResponse;
use \AppException;



class MultipleResponseQAResponse extends QAResponse{
    /**
     * @var array
     */
    public $variantsKey=[];
    /**
     * @var array
     */
    public $responses=[];

    /**
     * @return string
     */
    public function toString()
    {
        return json_encode(
            [
                'version'=>$this->getVersion(),
                'variantsKey'=>$this->variantsKey,
                'responses'=>$this->responses,
            ],
            JSON_FORCE_OBJECT);
    }

    /**
     * @param string $str
     * @throws AppException
     */
    public function load($str)
    {
        $a=json_decode($str,true);

        if(array_key_exists('variantsKey',$a) && array_key_exists('responses',$a)){
            $this->variantsKey=$a['variantsKey'];
            $this->responses=$a['responses'];
        }
        else{
            throw new AppException('MultipleResponseQAResponse have incorrect data format.');
        }
    }
}