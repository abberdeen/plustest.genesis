<?php

namespace Adapter\Event;
use System\QueryAdapter;
use Adapter\ControlMechanism\Policy;
use Adapter\User\User;
use Adapter\Event\EventItems;



class Event extends QueryAdapter{

    private $eventId;
    private $connection;

    public function  __construct(&$connection,$eventId){
        $this->eventId=$eventId;
        $this->connection=&$connection;
        parent::__construct($connection,'e_event','ev_',$eventId);
    }

    public function getId(){
        return $this->eventId;
    }

    public function getName(){
        return $this->getValue("ev_name");
    }

    public function getTitle(){
        $title=$this->getValue("ev_title");
        if(isset($title) && strlen($title)>0){
            return $title;
        }
        return "-";
    }

    public function getDescription(){
        return $this->getValue("ev_description");
    }

    /**
     * @return Policy
     */
    public function getPolicy(){
        return new Policy($this->connection,$this->getValue("ev_policy_id"));
    }

    public function getStartDatetime(){
        return $this->getValue("ev_start_datetime");
    }

    public function getEndDatetime(){
        return $this->getValue("ev_end_datetime");
    }

    /**
     * @return bool
     */
    public function enabled(){
        return $this->getValue("ev_enabled")=='1'?true:false;
    }

    /**
     * @return bool
     */
    public function visible(){
        return $this->getValue("ev_visible")=='1'?true:false;
    }

    /**
     * @return bool
     */
    public function controlByDatetime(){
        return $this->getValue("ev_control_by_datetime")=='1'?true:false;
    }

    public function getCreationDatetime(){
        return $this->getValue("ev_creation_datetime");
    }

    /**
     * @return User
     */
    public function getCreator(){
        return new User($this->connection,$this->getValue("ev_creator_us_id"));
    }

    /**
     * List of event items (Assessments)
     * @return EventItems
     */
    public function items(){
        return new EventItems($this->connection,$this->eventId);
    }
}