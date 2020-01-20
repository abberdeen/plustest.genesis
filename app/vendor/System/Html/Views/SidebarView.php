<?php
namespace System\Html\Views;
use System\Html\Views\FormView;
use System\Html\Views\FormViewStyle;


class SidebarView extends FormView{
    private $items=[];
    public $link='';
    public function __construct($id,$name,$text,$items){
        parent::setId($id);
        parent::setName($name);
        parent::setText($text);
        parent::setViewStyle(FormViewStyle::SIDEBAR_SIMPLE);
        $this->items=$items;

    }

    public function setItems($items){
        $this->items=$items;
    }

    public function render(){
        switch($this->getViewStyle()){
            case FormViewStyle::DEFAULT_STYLE:
            case FormViewStyle::SIDEBAR_SIMPLE:
                return $this->_SIDEBAR_SIMPLE();
                break;
            case FormViewStyle::SIDEBAR_LIST_GROUP:
                return $this->_SIDEBAR_LIST_GROUP();
                break;
        }
    }

    private function _SIDEBAR_SIMPLE(){
        $r='<div class="bd-sidebar" style="border-left: 1px solid rgba(0, 0, 0, 0.11);height: 90vh;"><nav class="bd-links" id="'.$this->getId().'" style="padding-bottom:20px;">';
        foreach($this->items as $item){
            $r.='<div class="bd-toc-item active-open '.($item['active']||$item['link']==$this->link?'active':'').'">';
            $r.='<a class="bd-toc-link" href="'.$item['link'].'">'.$item['text'].'</a>';
            $r.='<ul class="nav bd-sidenav">';
            foreach($item['subitems'] as $subitem){
                $r.='<li class="'.($subitem['active']||$subitem['link']==$this->link?'active bd-sidenav-active':'').'"><a href="'.$subitem['link'].'">'.$subitem['text'].'</a></li>';
            }
            $r.='</ul>';
            $r.='</div>';
        }
        $r.='</nav></div>'."\n";
        return $r;
    }
    private function _SIDEBAR_LIST_GROUP(){
        $r='<div class="list-group" id="'.$this->getId().'" style="border-left: 1px solid rgba(0, 0, 0, 0.11);height: 90vh;padding-bottom:20px;">';
        foreach($this->items as $item){
            $r.='<a style="font-weight: 500;" class="list-group-item list-group-item-action '.(($item['active']||$item['link']==$this->link)?'active':'').'" href="'.$item['link'].'">'.$item['text'].'</a>';
            foreach($item['subitems'] as $subitem){
                $r.='<a class="list-group-item list-group-item-action '.(($subitem['active']||$subitem['link']==$this->link)?'active':'').'" href="'.$subitem['link'].'">'.$subitem['text'].'</a>';
            }
        }
        $r.='</div>'."\n";
        return $r;
    }
}
/*
    * Sidebar list data sample:
    $sidebarItems=[
        [
            'text' => 'Getting started',
            'link'=>'xxx',
            'active'=>false,
            'subitems' =>
                [
                    [
                        'text' =>'Introduction',
                        'link' => 'www',
                        'active'=>false
                    ],
                    [
                        'text' =>'Download',
                        'link' => 'www',
                        'active'=>false
                    ],
                    [
                        'text' =>'Contents',
                        'link' => 'www',
                        'active'=>false
                    ],
                ]
        ],
    ];
*/?>