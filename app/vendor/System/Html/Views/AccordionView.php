<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;


class  Accordion extends FormView{
    private $items=[];
    public function __construct($id,$name,$text){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(FormViewStyle::DEFAULT_STYLE);
    }

    public function setItems($items){
        $this->items=$items;
    }

    public function addItem($head,$content,$active=false){
          $this->items[]=['head'=>$head,'content'=>$content,'active'=>$active];
    }

    public function render(){
        $items="";
        $id=rand()*10000;
        parent::setId($this->getId().$id);
        foreach($this->items as $item){
            $id++;
            $items.=$this->card($item['head'],$item['content'],$item['active'],$id);
        }
        return "<div id='accordion".$this->getId()."' role='tablist' aria-multiselectable='true'>".$items."</div>";
    }

    private function card($head,$content,$active,$id){
        return "<div class=\"card\">".
            "<div class=\"card-header\" role=\"tab\" id=\"heading$head\">".
                "<h5 class=\"mb-0\" style='widht:100%'>".
                    "<a data-toggle=\"collapse\" data-parent=\"#accordion$id\" href=\"#collapse$id\" aria-expanded=\"true\" aria-controls=\"collapse$id\">".
                        "$head".
                    "</a>".
                "</h5>".
            "</div>".

            "<div id=\"collapse$id\" class=\"collapse".($active?' show':'')."\" role=\"tabpanel\" aria-labelledby=\"heading$id\">".
                "<div class=\"card-block\">".
                    "$content".
                "</div>".
            "</div>".
        "</div>";
    }
}
/*
    private $items=[
        [
            'head'  => 'Introduction',
            'content'  => 'www',
            'active'=> false
        ],
    ];
*/