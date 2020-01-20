<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 

$cmconfName=$match['params']['item'];
$cmconf=AdapterGen::getCMConfByName($_connection,$cmconfName);

$content="";
//CMConf not exists then out msg else out rule table grouped by credit ...
if($cmconf->getId()==0||$cmconf->getId()==null){
    $content=app::msg('','CM Conf not exists.','You may create CM Conf: <a href="'.$router->generate('man_cm_conf_add').'?n='.$cmconfName.'">'.$cmconfName.'.</a>',true);
}
else{
    $content.="<p>";
    $content.="<span class=\"float-right\">";

    $policy_name=$cmconf->getPolicy()->getName();
    $content.="<a href=\"".$router->generate('man_policy_item',['item'=>$policy_name])."\">".
                    app::icon('icon8/Finance/purchase_order-48.png',20) . $policy_name."</a> | ";

    $cm_type_name=$cmconf->getControlMechanism()->getName();
    $content.="<a href=\"".$router->generate('man_cm_type_item',['item'=>$cm_type_name])."\">".
                    app::icon('icon8/Very_Basic/settings-48.png',20) . $cm_type_name."</a>";

    $content.="</span>";
    $content.="<span>".$cmconf->getDescription()."</span>";
    $content.="</p>";

    $content.="<h4>Rule table</h4>";

    $creditList=$_connection->Query("SELECT
                                      cr_id id,
                                      cr_name name
                                    FROM
                                      c_cm_rule
                                      LEFT OUTER JOIN sd_credit
                                        ON cmrule_cr_id = cr_id
                                    WHERE cmrule_cmconf_id=".$cmconf->getId()."
                                    GROUP BY cmrule_cr_id;");



    $ruleTable=new TableView('','','');

    if(count($creditList)>0){

        $ruleTable=new TableView('','','');
        $ruleTable->columns=[ 'Form of test','Time limit','Out max point','Edit'];
        foreach($creditList as $credit){
            $ruleTable->rows[]=[
                'list'=>[
                    [
                        'value'=>"<span style='font-weight:600;'>Credit: <a href='".$router->generate('man_credit_item',['item'=>$credit['name']])."'>".$credit['name']."</a></span>",
                        'attr'=>'colspan="5"',
                    ],
                ],
                'style'=>'background-color: #f7f7f9;',
            ];
            $rules=$_connection->Query("SELECT
                                          cmrule_id,
                                          ft_name,
                                          cmrule_out_max_point,
                                          cmrule_pick_method_id,
                                          cmrule_total_time,
                                          cmrule_spec_rules
                                        FROM
                                          c_cm_rule
                                          LEFT OUTER JOIN sd_forms_of_tests
                                            ON cmrule_ft_id = ft_id
                                        WHERE cmrule_cmconf_id =".$cmconf->getId()."  AND
                                              cmrule_cr_id=".$credit['id']."
                                        ORDER BY ft_id;");

            foreach($rules as $row){
                $ruleTable->rows[]=[
                    'list'=>[
                        [
                            'value'=>"<a href='".$router->generate('man_task_type_view',['item'=>$row['ft_name']])."'>".str_replace("_" ," ",$row['ft_name'])."</a>",
                        ],
                        [
                            'value'=>$row['cmrule_total_time'],
                        ],
                        [
                            'value'=>$row['cmrule_out_max_point'],
                        ],
                        [
                            'value'=>"<a href='".$router->generate('man_cm_rule_item',['cmrule_id'=>$row['cmrule_id']])."'>edit</a>",
                        ],
                    ],
                    'style'=>'',
                ];
            }

        }

    }
    else{
        $content.=app::msg('','Table is empty','But you can fill it.',true);
    }



    $content.=$ruleTable->render();

    $content.="\n<p><span class='badge badge-primary'>Object browser</span></p>";
    $content.=ViewExt::RouteGen($router,$cmconf->toHtml());
}



