<?php


namespace Adapter\User;
use Adapter\Assessment\Assessment;
use System\QueryAdapter;
use System\Enums\UserType;
use System\Html\Views\TableView;
use System\Html\Views\Accordion;

class UserEvents  extends QueryAdapter{
    private $userId;

    public function __construct(&$connection,$user_id){
        $this->userId=$user_id;
        parent::__construct($connection,'xd_users','us_',$user_id);
    }

    /**
     * @return bool
     */
    public function isUserHaveUnfinishedEvent(){
        $rows=$this->connection()->Query("SELECT COUNT(1) c
                                            FROM e_assessment, e_event
                                            WHERE asm_us_id=".$this->userId."
                                            AND asm_ev_id=ev_id AND ev_visible=1 AND asm_state_id <> 3
                                            GROUP BY ev_id");
        if(count($rows)==0) return false;
        return $rows[0]["c"] > 0;
    }

    public function isUserHaveSartedEvent(){
        $rows=$this->connection()->Query("SELECT COUNT(1) c
                                            FROM e_assessment, e_event
                                            WHERE asm_us_id=".$this->userId."
                                            AND asm_ev_id=ev_id AND ev_visible=1 AND asm_state_id = 1
                                            GROUP BY ev_id");
        if(count($rows)==0) return false;
        return $rows[0]["c"] > 0;
    }
    /**
     * Return user event id list, that can be shown for user
     * @return array
     */
    public function getEventIdList(){
        $rows=$this->connection()->Query("SELECT ev_id `event_id`
                                            FROM e_assessment, e_event
                                            WHERE asm_us_id=".$this->userId."
                                            AND asm_ev_id=ev_id AND ev_visible=1
                                            GROUP BY ev_id");
        $arr=[];
        foreach($rows as $row){
            $arr[]=$row['event_id'];
        }
        return $arr;
    }


}