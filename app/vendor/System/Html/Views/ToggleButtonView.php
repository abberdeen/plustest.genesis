<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;
use System\Html\Views\ButtonView;
use System\Html\Views\FormMsgStyle;


class ToggleButtonView extends FormView{
    public $enabled=false;
    public $enabledText="Yes";
    public $disabledText="No";
    public function __construct($id='',$name='',$text=''){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(FormViewStyle::DEFAULT_STYLE);
    }

    public function render(){
        $btnOn=new ButtonView($this->getId(),$this->getText(),'');
        $btnOn->setSize('small');
        $this->enabled?$btnOn->setMessageStyle(FormMsgStyle::SUCCESS):$btnOn->setViewStyle(FormViewStyle::BUTTON_SECONDARY);
        $btnOn->outline=false;
        $btnOn->setText($this->enabledText);

        $btnOff=new ButtonView('','','');
        $btnOff->setSize('small');
        $this->enabled==false?$btnOff->setMessageStyle(FormMsgStyle::DANGER):$btnOff->setViewStyle(FormViewStyle::BUTTON_SECONDARY);
        $btnOff->outline=false;
        $btnOff->setText($this->disabledText);

        return "<div class=\"btn-group mr-2\" role=\"group\">".
                    $btnOff->render().
                    $btnOn->render().
                "</div>";
    }
}