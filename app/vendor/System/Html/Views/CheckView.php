<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;


class CheckView extends FormView{

    public $checked=false;

    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(FormViewStyle::CHECKBOX_STACKED);
    }

    public function render(){
        switch(parent::getViewStyle()){
            case FormViewStyle::CHECKBOX_STACKED:
                return '<div class="form-check">'.
                            '<label class="custom-control custom-checkbox" style="width:100%; background: #f7f7f9;margin:0 0 1px 0;">'.
                              '<input  '.($this->checked?'checked ':'').' type="checkbox" class="custom-control-input '.$this->addClass.'" value="'.parent::getValue().'" name="'.parent::getName().'" id="'.parent::getId().'">'.
                              '<span class="custom-control-indicator"></span>'.
                              '<span class="custom-control-description">'.parent::getText().'</span>'.
                            '</label>'.
                        '</div>';
                break;
            case FormViewStyle::CHECKBOX_CLASSIC:
                return '<div class="form-check" style="padding:0;margin:0 0 1px 0;">'.
                            '<label class="form-check-label" style="width:100%; background: #f7f7f9;">'.
                                '<input  '.($this->checked?'checked ':'').' class="form-check-input '.$this->addClass.'" type="checkbox" value="'.parent::getValue().'" name="'.parent::getName().'" id="'.parent::getId().'">'.
                                parent::getText().
                            '</label>'.
                        '</div>';
                break;
        }
    }
}