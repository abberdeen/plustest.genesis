<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;


use System\Html\Views\FormMsgStyle;

class InputView extends FormView{
    private $textMuted="";
    private $feedback="";
    private $type="text";
    public  $enabled="";

    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(FormViewStyle::DEFAULT_STYLE);
        parent::setMessageStyle(FormMsgStyle::DEFAULT_STYLE);
    }

    public function setTextMuted($text){
        $this->textMuted=$text;
    }
    public function setFeedback($text){
        $this->feedback=$text;
    }
    public function setType($type){
        $this->type=$type;
    }
    public function render(){
        $_size='';
        if($this->size=='large'||$this->size=='lg') $_size='form-control-lg';
        if($this->size=='small'||$this->size=='sm') $_size='form-control-sm';
        switch(parent::getViewStyle()){
            case FormViewStyle::DEFAULT_STYLE:
                return '<div class="form-group '.FormMsgStyle::getClass(parent::getMessageStyle(),'has-').'">'.
                        '<label class="form-control-label" for="'.parent::getId().'">'.parent::getText().'</label>'.
                        '<input type="'.$this->type.'" class="form-control '.FormMsgStyle::getClass(parent::getMessageStyle(),'form-control-').' '.$this->addClass.
                        (parent::getId()<>''?'" id="'.parent::getId():'').'" name="'.parent::getName().'" value="'.parent::getValue().'">'.
                        (strlen($this->feedback)>0?'<div class="form-control-feedback">'.$this->feedback.'</div>':'').
                        (strlen($this->textMuted)>0?'<small class="form-text text-muted">'.$this->textMuted.'</small>':'').'</div>';
                break;
            case FormViewStyle::LABEL_BEFORE_INPUT:
                return '<div class="form-group row '.FormMsgStyle::getClass(parent::getMessageStyle(),'has-').'">'.
                        '<label class="col-2 col-form-label col-form-label-sm" for="'.parent::getId().'">'.parent::getText().'</label>'.
                        '<div class="col-10">'.
                        '<input type="'.$this->type.'" class="form-control '.$_size.' '.FormMsgStyle::getClass(parent::getMessageStyle(),'form-control-').
                        (parent::getId()<>''?'" id="'.parent::getId():'').
                        (parent::getName()<>''?'" name="'.parent::getName():'').'"
                         value="'.parent::getValue().''.$this->enabled.'">'.
                        '</div>'.
                        (strlen($this->feedback)>0?'<div class="form-control-feedback">'.$this->feedback.'</div>':'').
                        (strlen($this->textMuted)>0?'<small class="form-text text-muted">'.$this->textMuted.'</small>':'').'</div>';
                break;
        }
    }
}