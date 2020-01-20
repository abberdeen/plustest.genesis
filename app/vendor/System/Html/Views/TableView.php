<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;
use System\Html\Views\TableView;


class  TableView extends FormView{
    public $rows=[];
    public $columns=[];
    public $columnStyle="";
    public $cellAlignment="left";
    public $headAlignment="left";
    public $marginBottom=20;
    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(FormViewStyle::DEFAULT_STYLE);
    }

    public function render(){
        switch(parent::getViewStyle()){
            case FormViewStyle::DEFAULT_STYLE:
                $r='';
                $r.="<style>";
                $r.=".igxThs{text-align:$this->headAlignment;}";
                $r.=".igxTrs{text-align:$this->cellAlignment;}";
                $r.="</style>";
                $r.="<table class='table' id='".$this->getId()."' style='margin-bottom:".$this->marginBottom.";'>";

                //table header (deprecated)
                if(count($this->columns)>0){
                    $r.="<tr>";
                    foreach($this->columns as $col){
                        $r.="<th class='igxThs' style='".$this->columnStyle."'>$col</th>";
                    }
                    $r.="</tr>";
                }

                //table rows
                foreach($this->rows as $row){

                    $rowStyle="";
                    if(isset($row['style'])){
                        $rowStyle=$row['style'];
                    }

                    $r.="<tr style='$rowStyle'>";
                    foreach($row['list'] as $cell){

                        $cellStyle="";
                        if(isset($cell['style'])){
                            $cellStyle=$cell['style'];
                        }

                        $cellClass="";
                        if(isset($cell['class'])){
                            $cellClass=$cell['class'];
                        }

                        $cellAttr="";
                        if(isset($cell['attr'])){
                            $cellAttr=$cell['attr'];
                        }

                        $cellValue="";
                        if(isset($cell['value'])){
                            $cellValue=$cell['value'];
                        }

                        $rowType="d";
                        if(isset($row['row-type'])){
                            $rowType=$row['row-type']=='head'?'h':'d';
                        }

                        $r.="<t".$rowType." class='igxTrs $cellClass' style='$cellStyle' $cellAttr>$cellValue</t".$rowType.">";
                    }
                    $r.="</tr>";
                }
                $r.="</table>";
                return $r;
                break;
        }
    }
}
/*
$table= new TableView('','','');
$table->columns=['A','B','C'];
$table->rows=[
    [
        'list'=>[
            [
                'value'=>1,
                'style'=>'color:red;',
                'class'=>''
            ],
            [
                'value'=>2,
                'style'=>''
            ],
            [
                'value'=>3,
                'style'=>''
            ],
        ],
        'style'=>'',
    ],
    [
        'list'=>[
            [
                'value'=>4,
                'style'=>''
            ],
            [
                'value'=>5,
                'style'=>''
            ],
            [
                'value'=>6,
                'style'=>''
            ],
        ],
        'style'=>'',
    ],
];
$table->cellAlignment='center';
$table->headAlignment='center';
*/