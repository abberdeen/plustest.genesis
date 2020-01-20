<?php

namespace Adapter\Event;



class EventItems{

    private $connection;
    private $eventId;

    public function  __construct(&$connection,$eventId){
        $this->connection=&$connection;
        $this->eventId=$eventId;
    }

    public function exists($assessmentId){
        return $this->connection->GetValue("SELECT '1'
                                            FROM  e_assessment
                                            WHERE asm_ev_id='$this->eventId'
                                            AND asm_id='$assessmentId'")=='1'?true:false;
    }

    public function idList(){
        $rows=$this->connection->Query("SELECT asm_id
                                            FROM  e_assessment
                                            WHERE asm_ev_id='$this->eventId'");
        $arr=[];
        foreach($rows as $row){
            $arr[]=$row['asm_id'];
        }
        return $arr;
    }
}