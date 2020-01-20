<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

/**
 * Created by PhpStorm.
 * User: Abdurahim
 * Date: 29.01.18
 * Time: 21:00
 */
$cmrule_id=null;
if(isset($match['params']['cmrule_id'])){
    $cmrule_id=$match['params']['cmrule_id'];
}
else{
    die("");
}


$igxPickMethod=app::POST('igxPickMethod');
$igxThemeOrder=app::POST('igxThemeOrder');
$outMaxPoint=app::POST('outMaxPoint');
$totalTime=app::POST('totalTime');
$specRules=app::POST('specRules');

$_connection->Execute("UPDATE
                          c_cm_rule
                        SET
                          cmrule_out_max_point = '$outMaxPoint',
                          cmrule_pick_method_id = '$igxPickMethod',
                          cmrule_themes_order_method_id = '$igxThemeOrder',
                          cmrule_total_time = '$totalTime',
                          cmrule_spec_rules = '$specRules'
                        WHERE cmrule_id = '$cmrule_id' ;");
//
$customRulesStr=app::POST('customRules');
$customRulesStr=str_replace(" ","",$customRulesStr);
$customRulesStr=str_replace("\n","",$customRulesStr);
$customRulesStr=str_replace("\r","",$customRulesStr);

$m=preg_match_all("/theme_id=(.*?),.*?level_in_theme=(.*?),.*?task_count=(.*?)(,|])/",$customRulesStr,$matches);

$insertPrep="";
if($m){
    for($i=0;$i<count($matches[0]);$i++){
        if($i>0) $insertPrep=$insertPrep.',';
        $insertPrep.='('.$cmrule_id.','.intval($matches[1][$i]).','.intval($matches[2][$i]).','.intval($matches[3][$i]).','.$_user->getId().',NOW())';
    }
}
$_connection->Execute("DELETE FROM c_cm_subrule WHERE subrule_cmrule_id= '$cmrule_id'");

$_connection->Execute("INSERT INTO  c_cm_subrule (
                            subrule_cmrule_id,
                            subrule_theme_id,
                            subrule_level_in_theme,
                            subrule_task_count,
                            subrule_creator_us_id,
                            subrule_creation_datetime
                        )
                        VALUES $insertPrep;");

app::redirect($router->generate('man_cm_rule_item',['cmrule_id'=>$cmrule_id]));



