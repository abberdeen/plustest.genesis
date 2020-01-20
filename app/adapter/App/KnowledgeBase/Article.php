<?php

namespace Adapter\App\KnowledgeBase;


class Article extends  ArticleBase{
    public function getCategories(){
        return $this->connection->Query("SELECT
                                              art_language lang,
                                              art_title title
                                            FROM
                                              kb_article,
                                              kb_relation
                                            WHERE rel_type = 'article/category'
                                              /*
                                                `rel_parent_art_id` in this case is category and `rel_art_id`  is article (article/category relation)
                                              */
                                              AND rel_parent_art_id = art_id
                                              AND rel_art_id = '".$this->articleId."';");
    }
}
