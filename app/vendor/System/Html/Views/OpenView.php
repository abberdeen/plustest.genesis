<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;


class  OpenView extends FormView{

    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(FormViewStyle::NUMERIC_CLASSIC);
    }

    public function render(){
        switch(parent::getViewStyle()){
            case FormViewStyle::NUMERIC_CLASSIC:
                return '<div class="form-group">'.
                            '<label for="'.parent::getId().'" style="margin:0px;">'.parent::getText().'</label>'.
                            '<input type="text" class="form-control form-control-sm" value="'.parent::getValue().'" name="'.parent::getName().'" id="'.parent::getId().'" style="width:200px;">'.
                        '</div>';
                break;
        }
    }
}