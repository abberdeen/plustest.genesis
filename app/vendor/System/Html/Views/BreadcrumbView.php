<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;


class  BreadcrumbView extends FormView{
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

    public function render(){
        switch(parent::getViewStyle()){
            case FormViewStyle::DEFAULT_STYLE:
                $r='<nav class="breadcrumb">';
                foreach($this->items as $item){
                    if($item['active']){
                        $r.='<span class="breadcrumb-item active">'.$item['text'].'</span>';
                    }
                    else{
                        $r.='<a class="breadcrumb-item" href="'.$item['link'].'">'.$item['text'].'</a>';
                    }
                }
                $r.='</nav>';
                return $r;
                break;
        }
    }
}
/*
    private $list=[
        [
            'text'  => 'Introduction',
            'link'  => 'www',
            'active'=> false
        ],
    ];
*/