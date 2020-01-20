<?php 
namespace System\Html\Views;


abstract class View{
    private $id;
    private $name;
    private $text;
    private $value;
    private $viewStyle;
    private $messageStyle;
    /**
     * @param $id
     * @param $name
     * @param $text
     */
    public function __construct($id,$name,$text){
        $this->setId($id);
        $this->setName($name);
        $this->setText($text);
    }

    //Property Id
    /**
     * @return String
     */
    public function getId(){
        return $this->id;
    }
    /**
     * indentificator of view element
     * @param $id
     */
    public function setId($id){
        $this->id=$id;
    }

    //Property Name
    /**
     * @return mixed
     */
    public function getName(){
        return $this->name;
    }
    /**
     * Sets view name
     * Name is view element name
     * @param $name
     */
    public function setName($name){
        $this->name=$name;
    }

    //Property Text
    /**
     * @return mixed
     */
    public function getText(){
        return $this->text;
    }
    /**
     * Sets caption of view
     * @param $text
     */
    public function setText($text){
        $this->text=$text;
    }

    //Property Value
    /**
     * @return mixed
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * @param $value
     */
    public function setValue($value){
        $this->value=$value;
    }

    //Property ViewStyle
    /**
     * @return mixed
     */
    public function getViewStyle(){
        return $this->viewStyle;
    }
    /**
     * @param $viewStyle
     */
    public function setViewStyle($viewStyle){
        $this->viewStyle=$viewStyle;
    }

    /**
     * @return mixed
     */
    public function getMessageStyle(){
        return $this->messageStyle;
    }

    /**
     * Sets view message style.
     * Use this property for view any message (warning, success, info etc.) to user
     * If this property not set, views default views style
     * @param $messageStyle
     */
    public function setMessageStyle($messageStyle){
        $this->messageStyle=$messageStyle;
    }

    public abstract function render();

    public function dump(){
        echo "<pre>";
        print_r($this);
        echo "</pre>";
    }
}