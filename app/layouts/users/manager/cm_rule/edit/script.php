<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}



use System\Html\Views\InputView;
use System\Html\Views\FormViewStyle;

$cmrule_id=null;
if(isset($match['params']['cmrule_id'])){
    $cmrule_id=$match['params']['cmrule_id'];
}
else{
    die("");
}

$cmrule=$_connection->Query("SELECT
                                  cmconf_name,
                                  cmrule_out_max_point,
                                  cmrule_pick_method_id,
                                  cmrule_total_time,
                                  cmrule_spec_rules,
                                  us_name,
                                  cmrule_creation_datetime
                                FROM
                                  c_cm_rule
                                  LEFT OUTER JOIN c_cm_conf
                                    ON cmrule_cmconf_id=cmconf_id
                                  LEFT OUTER JOIN xd_users
                                    ON cmrule_creator_us_id=us_id
                                WHERE
                                  cmrule_id=".$cmrule_id.";");

if(count($cmrule)<=0){
    sys::_404();
    die();
}

$cmconf_name=$cmrule[0]['cmconf_name'];


$outMaxPoint=new InputView('','outMaxPoint','outMaxPoint');
$outMaxPoint->setType('text');
$outMaxPoint->setSize('small');
$outMaxPoint->setViewStyle(FormViewStyle::LABEL_BEFORE_INPUT);
$outMaxPoint->setValue($cmrule[0]['cmrule_out_max_point']);

//PickMethod; use select control
$pickMethod=$cmrule[0]['cmrule_pick_method_id'];

$totalTime=new InputView('','totalTime','totalTime');
$totalTime->setType('text');
$totalTime->setSize('small');
$totalTime->setViewStyle(FormViewStyle::LABEL_BEFORE_INPUT);
$totalTime->setValue($cmrule[0]['cmrule_total_time']);


$customRulesQ=$_connection->Query("SELECT
                                      subrule_id,
                                      subrule_theme_id,
                                      subrule_level_in_theme,
                                      subrule_task_count
                                    FROM
                                       c_cm_subrule
                                    WHERE subrule_cmrule_id=".$cmrule_id.";");

$customRules="";
foreach($customRulesQ as $row){
    $customRules.="[ theme_id = ".$row['subrule_theme_id'].", level_in_theme = ".$row['subrule_level_in_theme'].", task_count =  ".$row['subrule_task_count'].",],\n";
}

