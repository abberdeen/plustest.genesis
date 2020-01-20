<?php

$encrypted_asm_id=app::GET('a');
if(strlen($encrypted_asm_id)>0){
    $asm_id=security::decrypt($encrypted_asm_id);
    $asm_id=intval($asm_id);
    $rows=$_connection->Query("SELECT asm_ev_id
                                FROM e_event, e_assessment
                                WHERE asm_id=".$asm_id."
                                AND asm_ev_id=ev_id LIMIT 1");
    if(count($rows)==1){
        $_SESSION[SS_EVENT_ID]=$rows[0]["asm_ev_id"];
        $_SESSION[SS_ASSESSMENT_ID]=$asm_id;
        app::redirect($router->generate('assessment_view'));
    }
    throw new AppException('Requested assessment doesn\'t exists. AsmId:'.$asm_id.';',2603);
}
