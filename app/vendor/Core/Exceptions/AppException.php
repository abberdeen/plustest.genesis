<?php

/**
 * Class AppException
 * Application regular exception, can be identified by code
 */
class AppException extends Exception{

    protected $title='AppException';

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Construct the exception. Note: The message is NOT binary safe.
     * @link http://php.net/manual/en/exception.construct.php
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message,$code,$previous);
        if(DEBUG_MODE_ENABLED){
            $this->viewTrace();
        }
    }


    /**
     *
     */
    public function viewTrace(){
        echo "<html><div style='margin: 20px;padding: 20px;background-color: #dadada;'>";
        echo "<h4>Uncaught exception</h4>";
        echo "<p><b>Code: ".$this->getCode()."</b></p>";
        echo "<p>".$this->getMessage()."</p>";
        echo "<p><b>".$this->title." trace:</b></p>";
        echo "<table border='1'><tr><th>#</th><th>File</th><th>Line</th><th>Function</th><th>Args</th></tr>";
        $i=0;
        foreach($this->getTrace() as $trace){
            echo "<tr".($i==0?' style="background:#ff000021;"':'').">";
            echo "<td>".$i."</td>";
            echo "<td>".$trace['file']."</td>";
            echo "<td>".$trace['line']."</td>";

            $func="";
            if(isset($trace['class'])){
                $func.=$trace['class'];
                if(isset($trace['type'])){
                    $func.=$trace['type'];
                }
                if(isset($trace['function'])){
                    $func.=$trace['function'];
                }
            }
            elseif(isset($trace['function'])){
                $func.=$trace['function'];
            }

            echo "<td>".$func."</td>";

            $args='';
            if(isset($trace['args'])){
                foreach ($trace['args'] as $arg){
                    if(is_string($arg)){
                        $args.="'".$arg."'; ";
                    }
                    elseif(is_numeric($arg)){
                        $args.=$arg.'; ';
                    }
                    elseif(is_array($arg)){
                        $args.='array; ';
                    }
                    elseif(is_object($arg)){
                        $args.='Object ('.get_class($arg).'); ';
                    }
                }
            }
            echo "<td>".$args."</td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";
        echo "<br><p><b>Thrown in: </b><br>".$this->getFile().' on line '.$this->getLine()."</p>";
        echo "</div></html>";
        die();
    }
}