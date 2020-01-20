<?php

namespace Adapter\QA\QAResponse;
use Adapter\QA\QAResponse\QAResponse;
use \AppException;


class MultipleChoiceQAResponse extends QAResponse{
    /**
     * @var array
     */
    public $variantsKey=[];
    /**
     * @var null
     */
    public $response=null;

    /**
     * @return string
     */
    public function toString()
    {
        return json_encode(
            [
                'version'=>$this->getVersion(),
                'variantsKey'=>$this->variantsKey,
                'response'=>$this->response,
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
        if(array_key_exists('variantsKey',$a) && array_key_exists('response',$a)){
            $this->variantsKey=$a['variantsKey'];
            $this->response=$a['response'];
        }
        else{
            throw new AppException('QAResponse have incorrect data format.');
        }
    }
}