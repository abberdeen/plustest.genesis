<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;
use System\Html\Views\FormMsgStyle;


class ButtonView extends FormView{
    private $type="button";
    public $outline=false;
    public $link='';
    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(FormViewStyle::BUTTON_PRIMARY);
    }

    public function setType($type){
        $this->type=$type;
    }

    public function render(){
        $_outline='';
        if($this->outline){
            $_outline='outline-';
        }
        $_size=null;
        if($this->size=='large'||$this->size=='lg') $_size='btn-lg';
        if($this->size=='small'||$this->size=='sm') $_size='btn-sm';
        $_viewStyle='';
        switch(parent::getViewStyle()){
            case FormViewStyle::BUTTON_PRIMARY:
            case FormViewStyle::BUTTON_SECONDARY:
            case FormViewStyle::BUTTON_LINK:
                $_viewStyle='btn-'.$_outline.FormViewStyle::getClass(parent::getViewStyle());
                break;
        }
        switch(parent::getMessageStyle()){
            case FormMsgStyle::INFO:
            case FormMsgStyle::WARNING:
            case FormMsgStyle::DANGER:
            case FormMsgStyle::SUCCESS:
                $_viewStyle='btn-'.$_outline.FormMsgStyle::getClass(parent::getMessageStyle());
                break;
        }
        if(strlen($this->link)>0){
            return '<a class="btn '.$_viewStyle.' '.$_size.' '.$this->addClass.'" href="'.$this->link.'" role="button">'.parent::getText().'</a>';
        }
        return '<button id="'.parent::getId().
                        '" name="'.parent::getName().
                        '" type="'.$this->type.
                        '" class="btn '.$_viewStyle.
                                (isset($_size)?' '.$_size:'').
                                (isset($this->addClass)?' '.$this->addClass:'').
                '">'.parent::getText().'</button>';

    }
}