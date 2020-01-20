<?php
namespace System\Html\Views\TaskView;

use System\Html\Views\TaskView\TaskViewStyle;
use System\Html\Views\View;
use System\Assessment\Items\Type\MatchingType;

class MatchingTypeView extends View{
    private $data;

    public $matches=[];
    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(TaskViewStyle::MATCHING_DRAG_AND_DROP);
        $this->data=new MatchingType("","",0,array());
    }

    //Property Data
    public function getData(){
        return $this->data;
    }

    public function setData(MatchingType $data){
        $this->data=$data;
    }

    public function render(){
        $r="";
        switch(parent::getViewStyle()){
            case TaskViewStyle::MATCHING_DRAG_AND_DROP:
                $left="";
                $right="";
                for($i=0;$i<count($this->getData()->variants);$i++){
                    $id=$i;
                    if($this->getData()->variantByIndex($i)->getLeft()!="") {
                        $lcv=$this->getData()->variantByIndex($i)->getLeft();

                        $value="";
                        if(isset($this->matches[$i])){
                            $value="r".$this->matches[$i];
                        }

                        $left=$left.MatchingTypeDNDView::leftColumnView($id,$this->getName(),$lcv,$value);
                    }
                    if($this->getData()->variantByIndex($i)->getRight()!=""){
                        $rcv=$this->getData()->variantByIndex($i)->getRight();
                        $right=$right.MatchingTypeDNDView::rightColumnView($id,$rcv);
                    }
                }
                $r="<h4 style='margin-top: 0px;' class='no-select '>".MatchingTypeDNDView::formatContent($this->getData()->getText())."</h4>".
                "<p>".
                    "<button type='button' class='btn btn-sm btn-outline-secondary' onclick='sortByMatch();'>
                ".\app::icon('icon8/data/list-48.png',18,false,'0 0 0 0')."
                </button>".
                "<button type='button' class='btn btn-sm btn-outline-secondary' onclick='sortByNumber();'>
                ".\app::icon('icon8/data/numerical_sorting_12-48.png',18,false,'0 0 0 0')."
                </button></p>".
                    "<div class='row'>".
                        "<div id='left' class='col-5' >".
                            "$left".
                        "</div>".
                        "<div id='OMG' class='no-select' style='width:20px; '>".
                            "&nbsp;".
                        "</div>".
                        "<div id='right' class='col-6'>".
                            "$right".
                        "</div>".
                    "</div>".
                    \app::getResource("css","matchbox/css/matching.css").
                    \app::getResource("js","matchbox/js/g.js").
                    \app::getResource("js","matchbox/js/h.js").
                    \app::getResource("js","matchbox/js/my.js");

                break;
        }
        return $r;
    }
}

class MatchingTypeDNDView{
    static function leftColumnView($id,$parentName,$content,$value){
        $x=['A','B','C','D'];
        return
            "<div id='l$id' class='column no-select cl$id' >".
                "<input id='li$id' name='".$parentName."_".$id."' type='hidden' value='$value'/>".
                "<table style='width:100%;min-height:50px;' >".
                    "<tr>".
                        "<td class='content-format' id='lcContent$id'>".(self::formatContent($content))."</td>".
                        "<td align='right'>".
                            "<div id='lc$id' class='connector left clb$id' draggable='true' onmouseover='mouseover(this)' onmouseout='mouseleave(this)' onclick=\"mouseclick('l$id')\">".
                            $x[$id].
                            "</div>".
                        "</td>".
                    "</tr>".
                "</table>".
            "</div>";
    }
    static function rightColumnView($id,$content){
        return
            "<div id='container$id'><div id='r$id' class='column no-select right'>".
            "<input id='ri$id' type='hidden' value=''/>".
                "<table style='min-height:50px;'  >".
                    "<tr>".
                        "<td align='left'  >".
                            "<div id='rc$id' class='connector right free' draggable='true' onclick=\"mouseclick('l$id')\">".
                        ($id+1)."</div>".
                        "</td>".
                        "<td class='content-format' id='rcContent$id'>".(self::formatContent($content))."</td>".
                    "</tr>".
                "</table>".
            "</div></div>";
    }

    static function formatContent($str){
        $str=str_replace(chr(9)," ",$str);

        $str=str_replace("  "," ",$str);

        $str=str_replace("  "," ",$str);

        $str=str_replace("\n","",$str);
        return $str;
    }
}
