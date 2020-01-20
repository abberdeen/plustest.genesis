<?php

namespace Adapter\App\KnowledgeBase;    
use System\QueryAdapter;
use Adapter\App\KnowledgeBase\Article;


class ArticleList extends QueryAdapter{
    private static $artTypeCond=" art_type IN('article','article/announcement') ";
    static  function  getArticleByTitle(&$connection,$article_lang,$article_title){
        $article_title=str_replace(' ','_',$article_title);
        $r=$connection->Query("SELECT art_id
                                         FROM kb_article
                                         WHERE art_title LIKE '".$article_title."'
                                            AND art_language='".$article_lang."'
                                            AND ".self::$artTypeCond.";");
        if(count($r)>0){
            return new Article($connection,$r[0]['art_id']);
        }
        return null;
    }

    static function getArticleByInter(&$connection,$article_lang,$article_inter_id){
        $r=$connection->Query("SELECT art_id FROM kb_article
                                WHERE art_inter_id='".$article_inter_id."'
                                      AND art_language='".$article_lang."'
                                      AND ".self::$artTypeCond.";");
        if(count($r)>0){
            return new Article($connection,$r[0]['art_id']);
        }
        return null;
    }

    static  function articleExists(&$connection,$article_lang,$article_title){
        $article_title=str_replace(' ','_',$article_title);
        $r=$connection->Query("SELECT COUNT(*) > 0 AS r FROM kb_article
                                WHERE art_title LIKE '".$article_title."'
                                  AND art_language = '".$article_lang."'
                                  AND ".self::$artTypeCond.";");
        return ($r[0]['r']==1);
    }

    static function articleInterLang(&$connection,$article_lang,$article_title){
        $article_title=str_replace(' ','_',$article_title);
        return $connection->Query("SELECT
                                      art_language lang,art_title title
                                    FROM
                                      kb_article
                                    WHERE art_inter_id = (
                                            SELECT art_inter_id
                                            FROM kb_article
                                            WHERE art_title LIKE '".$article_title."' AND art_language='".$article_lang."' AND art_type IN ('article','article/announcement') )
                                    ORDER BY lang;");

    }
}
