<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

use System\Html\Views\ButtonView;
use System\Html\Views\FormViewStyle;


$btnChangePass=new ButtonView('','','');
$btnChangePass->setSize('small');
$btnChangePass->outline=false;
$btnChangePass->link="";
$btnChangePass->setText('Иваз кардан');

$btnLater=new ButtonView('','','');
$btnLater->setSize('small');
$btnLater->setViewStyle(FormViewStyle::BUTTON_SECONDARY);
$btnLater->outline=false;
$btnLater->link="";
$btnLater->setText('Баъдтар');





