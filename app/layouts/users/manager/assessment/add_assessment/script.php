<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

use System\Html\Views\InputView;
use System\Html\Views\FormViewStyle;
use System\Html\Views\RadioView;
use System\Html\Views\ButtonView;



$name=new InputView('igxName','name','Ном');
$name->setType('text');
$name->setSize('small');
$name->setViewStyle(FormViewStyle::LABEL_BEFORE_INPUT);

$desc=new InputView('igxDesc','desc','Шарҳ');
$desc->setType('text');
$desc->setSize('small');
$desc->setViewStyle(FormViewStyle::LABEL_BEFORE_INPUT);

$date=new InputView('igxDate','date','Сана');
$date->setType('date');
$date->setSize('small');
$date->setViewStyle(FormViewStyle::LABEL_BEFORE_INPUT);

$time=new InputView('igxTime','time','Соат');
$time->setType('time');
$time->setSize('small');
$time->setViewStyle(FormViewStyle::LABEL_BEFORE_INPUT);

$enabledTrue=new RadioView('igxEnabledTrue','enabled','on');
$enabledTrue->setValue('1');
$enabledFalse=new RadioView('igxEnabledFalse','enabled','off');
$enabledFalse->setValue('0');

$visibleTrue=new RadioView('igxVisibleTrue','visible','true');
$visibleTrue->setValue('1');
$visibleFalse=new RadioView('igxVisibleFalse','visible','false');
$visibleFalse->setValue('0');

$btnSubmit=new ButtonView('','','Илова кардан');
$btnSubmit->setType('submit');
$btnSubmit->setSize('small');


