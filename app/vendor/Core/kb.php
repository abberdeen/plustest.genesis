<?php
/**
 * Class kb
 * Knowledge Base Extension
 */

use Adapter\App\KnowledgeBase\ArticleList;
class kb{

    static function article($lang,$title,$showtitle=null,$target=null){
        if($showtitle==null||trim($showtitle)==''){
            $showtitle=str_replace('_',' ',$title);
        }
        return "<a class='pgKB' ".(isset($target)?" target=\"".$target."\"":'')."href=\"".self::articleLink($lang,$title)."\">".$showtitle."</a>";
    }

    static function articleLink($lang,$title){
        global $router;
        $title=str_replace(' ','_',$title);
        $title=mb_strtoupper(mb_substr($title,0,1)).mb_substr($title,1);
        return $router->generate('art_view',['lang'=>$lang,'title'=>$title]);
    }

    static function articleLinkByInter($artLang,$artInterId){
        global $_connection;
        $art=ArticleList::getArticleByInter($_connection,$artLang,$artInterId);
        $artTitle="";
        if(isset($art)) $artTitle=$art->getTitle();
        return self::articleLink($artLang,$artTitle);
    }

    static function category($lang,$title,$showtitle=null){
        if($showtitle==null||trim($showtitle)==''){
            $showtitle=str_replace('_',' ',$title);;
        }
        return "<a href=\"".self::categoryLink($lang,$title)."\">".$showtitle."</a>";
    }

    static function categoryLink($lang,$title){
        global $router;
        $title=str_replace(' ','_',$title);
        $title=mb_strtoupper(mb_substr($title,0,1)).mb_substr($title,1);
        return $router->generate('cat_view',['lang'=>$lang,'title'=>$title]);
    }

    static function categoryLinkByInter($catLang,$catInterId){
        global $_connection;
        $cat=CategoryList::getCategoryByInter($_connection,$catLang,$catInterId);
        $catTitle="";
        if(isset($cat)) $catTitle=$cat->getTitle();
        return self::categoryLink($catLang,$catTitle);
    }

    /**
     * Returns article link
     * @param $lang
     * @param $title
     * @param null $showtitle
     * @return string
     */
    static function a($lang,$title,$showtitle=null,$target=null){
        return self::article($lang,$title,$showtitle,$target);
    }

}
