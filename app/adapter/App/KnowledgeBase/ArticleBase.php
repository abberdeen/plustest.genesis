<?php

namespace Adapter\App\KnowledgeBase;    
use System\QueryAdapter;
use Adapter\App\KnowledgeBase\ArticleType;



abstract class ArticleBase extends QueryAdapter{

    protected  $connection;
    protected $articleId;

    public function __construct(&$connection,$article_id){
        $this->connection=&$connection;
        $this->articleId=$article_id;
        parent::__construct($connection,'kb_article','art_',$article_id);
    }

    public function getContentType(){
        $x=$this->getValue('art_content_type');
        switch($x){
            case ArticleType::IGXM:
                return ArticleType::IGXM;
                break;
            case ArticleType::REDIRECT:
                return ArticleType::REDIRECT;
                break;
            default:
                return ArticleType::UNDEFINED;
                break;
        }
    }

    public function getUserType(){
        return $this->getValue('art_ut_id');
    }

    public function getTitle(){
        return $this->getValue('art_title');
    }

    public function getContent(){
        return $this->getValue('art_content');
    }

    public function getLanguage(){
        return $this->getValue('art_language');
    }


    abstract public function  getCategories();

}