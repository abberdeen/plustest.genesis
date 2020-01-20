<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} 
use Adapter\App\KnowledgeBase\ArticleList;
use Adapter\App\KnowledgeBase\CategoryList;
use Adapter\App\KnowledgeBase\ArticleType;
require_once(APP_PATH."/vendor/WikiParser/wikiParser.php");
//
$articleTitle="";
if(isset($match['params']['title'])){
    $articleTitle=$match['params']['title'];
}
$articleLang="";
if(isset($match['params']['lang'])){
    $articleLang=$match['params']['lang'];
}

if(strpos($articleTitle,' ')>0){
    $articleTitle=str_replace(' ','_',$articleTitle);
    app::redirect($router->generate($match['name'],['lang'=>$articleLang,'title'=>$articleTitle]));
}

$articleExists=false;
$articleType=$match['target']['c'];
switch($articleType){
    case 'article':
        $articleExists=ArticleList::articleExists($_connection,$articleLang,$articleTitle);
        break;
    case 'category':
        $articleExists=CategoryList::categoryExists($_connection,$articleLang,$articleTitle);
        break;
    case 'news':
        break;
}

$content="";
$article=null;

if($articleExists){

    switch($articleType){
        case 'article':
            $article=ArticleList::getArticleByTitle($_connection,$articleLang,$articleTitle);
            break;
        case 'category':
            $article=CategoryList::getCategoryByTitle($_connection,$articleLang,$articleTitle);
            break;
        case 'news':
            break;
    }

    $articleUserType=$article->getUserType();

    $userType=isset($_user)?$_user->getType():null;

    if($articleUserType==0||$articleUserType==$userType){
        switch($article->getContentType()){
            case ArticleType::IGXM:

                $wp = new wikiParser();
                $content=$article->getContent();
                $content=$wp->parse($content);

                if($articleType=='category'){

                    $isOtherCat=false;
                    $cat=CategoryList::getCategoryByInter($_connection,$articleLang,3);
                    if(isset($cat)){
                        if(strtolower($articleTitle)==strtolower($cat->getTitle())){
                            $isOtherCat=true;
                        }
                    }

                    if($content!=='') $content.="<br><br>";

                    $subCategories=$article->getSubcategories();
                    $content.="<h2 class='article-title-l3'>Зеркатегорияҳо</h2>";
                    if(count($subCategories)>0){
                        $content.=outCategories($subCategories,$userType);
                    }
                    else{
                        if($isOtherCat){
                            $content.= outCategories($article->getOtherSubcategories(),$userType);
                        }
                        else{
                            $content.="<p><i>холӣ</i></p>";
                        }
                    }

                    $subArticles=$article->getArticles();
                    $content.="<h2 class='article-title-l3'>Мақолаҳо</h2>";
                    if(count($subArticles)>0){
                        $content.= outArticles($subArticles,$userType);
                    }
                    else{
                        if($isOtherCat){
                            $content.= outArticles($article->getOtherArticles(),$userType);
                        }
                        else{
                            $content.="<p><i>холӣ</i></p>";
                        }
                    }
                }
                break;
            case ArticleType::REDIRECT:
                if($articleTitle!==trim($article->getContent())){
                    app::redirect($router->generate($match['name'],['lang'=>$articleLang,'title'=>$article->getContent()]).'?redirect-from='.$articleTitle);
                }
                else{
                    $content= app::msg('','','Чунин '.articleTypeCaption($articleType).' мавҷуд нест.',true);
                }
                break;
            default:
                sys::fatal(false,'2203#1');
                break;
        }
    }
    else{
        $content=app::msg('','','Ин '.articleTypeCaption($articleType).' танҳо барои корбарони имтиёздор дастрас аст.',true);
    }
}
else{
    $content= app::msg('','','Чунин '.articleTypeCaption($articleType).' мавҷуд нест.',true);
}
$articleTitle=app::formatArticleTitle($articleTitle);






function outArticles($list,$userType){
    $r="";
    $k=0;
    if(count($list)>0){
        $r="<ul>";
        foreach($list as $c){
            $k++;
            if($c['user_type']==0||$c['user_type']==$userType)  $r.="<li>" . kb::article($c['lang'],$c['title']) . "</li>";
        }
        $r.="</ul>";
    }
    if($k==0) return '<p><i>холӣ</i></p>';
    return $r;
}

function outCategories($list,$userType){
    $r="";
    $k=0;
    if(count($list)>0){
        $r="<ul>";
        foreach($list as $c){
            $k++;
            if($c['user_type']==0||$c['user_type']==$userType) $r.="<li>" . kb::category($c['lang'],$c['title']) . "</li>";
        }
        $r.="</ul>";
    }
    if($k==0) return '<p><i>холӣ</i></p>';
    return $r;
}

function  articleTypeCaption($articleType){
    switch($articleType){
        case 'article':
            return "мақола";
            break;
        case 'category':
            return "категория";
            break;
        case 'news':
            return "хабар";
            break;
    }
    return "мақола";
}
