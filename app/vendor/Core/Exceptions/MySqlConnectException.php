<?php




class MySqlConnectException extends AppException{
    public function __construct($error_str,$error_code){
        $this->title='MySqlConnectException';
        parent::__construct('Connection error. Code: '. $error_code.';' ,2011);
    }
}