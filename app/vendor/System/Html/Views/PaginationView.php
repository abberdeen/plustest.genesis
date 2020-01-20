<?php
namespace System\Html\Views;
use System\Html\Views\FormView;


class PaginationView extends FormView{

    private $currentPage;
    private $filter;
    private $pageCount;
    private $limit;

    public $showLimits=true;
    public $showPrevLink=true;
    public $showNextLink=true;

    public function __construct($currentPage,$filter,$pageCount,$limit){
        parent::setId('');
        parent::setName('');
        parent::setText('');
        $this->currentPage=$currentPage;
        $this->filter=$filter;
        $this->pageCount=$pageCount;
        $this->limit=$limit;
    }

    public function render(){
        $pagination="<span><a href='?page=1&filter=$this->filter&limit=$this->limit'><<</a> ";

        if($this->showPrevLink) {
            if ($this->currentPage <= 1) {
                $pagination .= "<span>Prev</span> ";
            } else {
                $pagination .= "<a href='?page=" . ($this->currentPage - 1) . "&filter=$this->filter&limit=$this->limit'>Prev</a> ";
            }
        }

        $start=1;
        $end=$this->pageCount;
        if(($this->currentPage-2)>0){
            $start=$this->currentPage-2;
        }
        if(($this->currentPage+2)<=$this->pageCount){
            $end=$this->currentPage+2;
            if(($this->currentPage-2)<=0){
                $end+=(abs($this->currentPage-3));
            }
        }
        for($i=$start;$i<=$end;$i++){
            if($this->currentPage==$i){
                $pagination.="<span>$i</span> ";
            }
            else{
                $pagination.="<a href='?page=$i&filter=$this->filter&limit=$this->limit'>$i</a> ";
            }
        }

        if($this->showNextLink){
            if($this->currentPage >= $this->pageCount || $this->pageCount == 1){
                $pagination.="<span>Next</span>";
            }
            else{
                $pagination.="<a href='?page=".($this->currentPage+1)."&filter=$this->filter&limit=$this->limit'>Next</a>";
            }
        }


        $pagination.=" <a href='?page=$this->pageCount&filter=$this->filter&limit=$this->limit'>>></a> ";

        if($this->showLimits){
            $limitfx=function($limit){
                global $page,$filter;
                return "<a href='?page=".$page."&filter=$filter&limit=$limit'>$limit</a>";
            };
            $pagination.=" (".$limitfx(20)." | ".$limitfx(50)." | ".$limitfx(100)." | ".$limitfx(250)." | ".$limitfx(500).")";
        }


        return $pagination."</span>";
    }
}
?>
