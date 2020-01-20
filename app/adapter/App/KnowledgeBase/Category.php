<?php

namespace Adapter\App\KnowledgeBase;    
use Adapter\App\KnowledgeBase\ArticleBase;



class Category extends  ArticleBase{
    public function getCategories(){
        /*
         * `rel_parent_art_id` in this case is parent category and `rel_art_id`  is sub category (category/category relation)
         */
        return $this->getItems("rel_type = 'category/category'
                                AND rel_parent_art_id = art_id
                                AND rel_art_id = '".$this->articleId."';");
    }

    public function getSubcategories(){
        /*
         * `rel_parent_art_id` in this case is parent category and `rel_art_id`  is sub category (category/category relation)
         */
        return $this->getItems("rel_type = 'category/category'
                                AND rel_art_id = art_id
                                AND rel_parent_art_id = '".$this->articleId."';");
    }

    public function  getOtherSubcategories(){
        return $this->connection->Query("SELECT
                                            art_language lang,
                                            art_title title,
                                            art_ut_id user_type
                                        FROM
                                          kb_article
                                          LEFT OUTER JOIN kb_relation
                                            ON rel_art_id = art_id
                                            AND rel_type = 'category/category'
                                        WHERE art_language = '".$this->getLanguage()."'
                                          AND art_type IN (
                                            'category'
                                          )
                                          AND art_title NOT IN ('Root')
                                          AND art_content_type NOT IN ('text/redirect') AND rel_id IS NULL");
    }

    /**
     * Returns category (sub)articles
     */
    public function getArticles(){
        /*
         * `rel_parent_art_id` in this case is parent category and `rel_art_id`  is sub category (category/category relation)
         */
        return $this->getItems("rel_type = 'article/category'
                                AND rel_art_id = art_id
                                AND rel_parent_art_id = '".$this->articleId."';");
    }

    /**
     * Returns articles with no category relation
     */
    public function getOtherArticles(){
        return $this->connection->Query("SELECT
                                            art_language lang,
                                            art_title title,
                                            art_ut_id user_type
                                        FROM
                                          kb_article
                                          LEFT OUTER JOIN kb_relation
                                            ON rel_art_id = art_id
                                            AND rel_type = 'article/category'
                                        WHERE art_language = '".$this->getLanguage()."'
                                          AND art_type IN (
                                            'article',
                                            'article/announcement'
                                          )
                                          AND art_content_type NOT IN ('text/redirect') AND rel_id IS NULL");
    }

    private function getItems($relCondition){
        return $this->connection->Query("SELECT
                    art_language lang,
                    art_title title,
                    art_ut_id user_type
                FROM
                    kb_article,
                    kb_relation
                WHERE art_language = '".$this->getLanguage()."' AND " . $relCondition);
    }

}