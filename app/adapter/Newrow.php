<?php
namespace Adapter;
use System\QueryAdapter;

class NewRow extends QueryAdapter{

    /**
     * @param $connection
     */
    public function __construct(&$connection){
        parent::__construct($connection,'','','');
    }

    /**
     * @param $policyId
     * @param $name
     * @param $desc
     * @param $date
     * @param $time
     * @param $enabled
     * @param $visible
     */
    public function newAssessment($policyId,$name,$desc,$date,$time,$enabled,$visible){
        $this->tableName='event';
        $this->insert(
            [
                'ev_pl_id' => $policyId,
                'ev_name' => $name,
                'ev_description' => $desc,
                'ev_date' => $date,
                'ev_time' => $time,
                'ev_enabled' => $enabled,
                'ev_visible' => $visible
            ]);
    }
}