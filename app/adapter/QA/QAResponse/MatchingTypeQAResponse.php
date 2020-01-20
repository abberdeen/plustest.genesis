<?php

namespace Adapter\QA\QAResponse;
use Adapter\QA\QAResponse\QAResponse;
use \AppException;


class MatchingTypeQAResponse extends QAResponse{
    /**
     * @var array
     */
    public $leftKey=[];

    /**
     * @var array
     */
    public $rightKey=[];

    /**
     * @var array
     */
    public $matches=[];

    /**
     * @return string
     */
    public function toString()
    {
        return json_encode(
            [
                'version'=>$this->getVersion(),
                'leftKey'=>$this->leftKey,
                'rightKey'=>$this->rightKey,
                'matches'=>$this->matches,
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
        if(isset($a['leftKey']) && isset($a['rightKey']) && isset($a['matches'])){
            $this->leftKey=$a['leftKey'];
            $this->rightKey=$a['rightKey'];
            $this->matches=$a['matches'];
        }
        else{
            throw new AppException('QAResponse have incorrect data format.');
        }
    }

}