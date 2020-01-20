<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;
use System\Html\Views\FormMsgStyle;


class RadioView extends FormView{

    public $checked=false;

    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(FormViewStyle::RADIO_STACKED);
    }

    public function render(){
        switch(parent::getViewStyle()){
            case FormViewStyle::RADIO_STACKED:
                return '<div class="form-check '.(FormMsgStyle::getClass(parent::getMessageStyle(),'has-')).'"><label for="'.parent::getId().'" class="custom-control custom-radio" style="width:100%;background:#f7f7f7;border: 1px solid #e6e6e6; padding:5px;margin:0;">'.
                                '<input '.($this->checked?'checked ':'').'id="'.parent::getId().'" name="'.parent::getName().'" type="radio" class="custom-control-input" value="'.parent::getValue().'" align="center">'.
                                '<span class="custom-control-indicator"></span>'.
                                '<span class="custom-control-description" id="'.parent::getId().'d" style="margin-left: 30px;">'.parent::getText().'</span>'.
                            '</label></div>';
                break;
            case FormViewStyle::DEFAULT_STYLE:
            case FormViewStyle::RADIO_CLASSIC:
                return '<div class="form-check '.(FormMsgStyle::getClass(parent::getMessageStyle(),'has-')).'"><label class="form-check-label" >'.
                            '<input '.($this->checked?'checked ':'').'id="'.parent::getId().'" name="'.parent::getName().'" class="form-check-input" type="radio"   value="'.parent::getValue().'"> '.
                                parent::getText().'</label></div>';
                break;
        }
    }
}