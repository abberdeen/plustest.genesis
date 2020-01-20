<?php
namespace System\Assessment\Items\Type\Variants;


/**
 * Class ProblemResponse
 */
class NumericResponseValue{
    /**
     * @var float $response
     */
    private $response;

    /**
     * @param float $response
     */
    public function __construct($response=0.0){
        $this->setResponse($response);
    }

    /**
     * Get's response value
     * @return float
     */
    public function getResponse(){
        return $this->response;
    }

    /**
     * Set's response value
     * @param float $response
     * @return void
     */
    public function setResponse($response){
        if($response==null){
            $this->response=null;
        }
        else{
            $this->response=floatval($response);
        }
    }
}