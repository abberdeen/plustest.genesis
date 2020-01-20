<?php

namespace Adapter\App\KnowledgeBase;    
use System\QueryAdapter;
use Adapter\App\KnowledgeBase\Category;



class CategoryList extends QueryAdapter{

    static  function  getCategoryByTitle(&$connection,$category_lang,$category_title){
        $category_title=str_replace(' ','_',$category_title);
        $r=$connection->Query("SELECT art_id
                                         FROM kb_article
                                         WHERE art_title LIKE '".$category_title."'
                                            AND art_language='".$category_lang."'
                                            AND art_type='category';");
        if(count($r)>0){
            return new Category($connection,$r[0]['art_id']);
        }
        return null;
    }

    static function getCategoryByInter(&$connection,$category_lang,$category_inter_id){
        $r=$connection->Query("SELECT art_id FROM kb_article
                                WHERE art_inter_id='".$category_inter_id."'
                                      AND art_language='".$category_lang."'
                                      AND art_type='category';");
        if(count($r)>0){
            return new Category($connection,$r[0]['art_id']);
        }
        return null;
    }

    static  function categoryExists(&$connection,$category_lang,$category_title){
        $category_title=str_replace(' ','_',$category_title);
        $r=$connection->Query("SELECT COUNT(*) > 0 AS r FROM kb_article
                                WHERE art_title LIKE '".$category_title."'
                                  AND art_language = '".$category_lang."'
                                  AND art_type='category';");
        return ($r[0]['r']==1);
    }

    static function categoryInterLang(&$connection,$category_lang,$category_title){
        $category_title=str_replace(' ','_',$category_title);
        return $connection->Query("SELECT
                                  art_language lang,art_title title
                                FROM
                                  kb_article
                                WHERE art_inter_id = (
                                        SELECT art_inter_id
                                        FROM kb_article
                                        WHERE art_title LIKE '".$category_title."' AND art_language='".$category_lang."' AND   art_type='category' )
                                        ORDER BY lang;");

    }
}
