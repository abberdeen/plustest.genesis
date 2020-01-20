<?php
namespace System\Assessment\Items\Type\Variants;


/**
 * Class OpenResponse
 */
class OpenResponseValue{
    /**
     * @var string $response
     */
    private $response;

    /**
     * @param string $response
     */
    public function __construct($response=''){
        $this->setResponse($response);
    }

    /**
     * @return string
     */
    public function getResponse(){
        return $this->response;
    }

    /**
     * @param string $response
     */
    public function setResponse($response){
        $this->response=strval($response);
    }

}