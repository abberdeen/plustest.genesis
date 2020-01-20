<?php 	if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<?php
use Adapter\App\KnowledgeBase\ArticleList;
use Adapter\App\KnowledgeBase\CategoryList;
use Adapter\App\KnowledgeBase\ArticleType;
use System\Culture\Lang;
?><html><head>
    <title><?=$articleTitle?> | <?=APP_BRAND?></title>
    <?php
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
    <style>

        .article-title{
            padding-bottom: 0.25rem;
            border-bottom: 1px solid #d5d5d5;
            margin-bottom: 0.1rem;
            font-size: 1.8em;
        }

        .article-title-l3{
            padding-bottom: 0.25rem;
            border-bottom: 1px solid #d5d5d5;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .article-content{
            font-family: sans-serif;
            font-size: 0.890rem;
            line-height: 1.5;
        }

        .article-categories{
            margin-top:2rem;
            width: 100%;
        }

        .article-content ul,p{
            margin: 7px 0 0 0;
        }

        h1,h2,h3,h4,h5,h6 {
            color: #000;
            background: none;
            font-weight: normal;
            margin: 0;
            padding-top: 0.5em;
            padding-bottom: 0.25rem;
        }

        .article-content h2 {
            font-size: 1.5em;
            margin-top: 1em;
            border-bottom: 1px solid #d5d5d5;
        }

        .article-content h3,.article-content h4,.article-content h5,.article-content h6 {
            line-height: 1.6;
            margin-top: 0.3em;
            margin-bottom: 0;
            padding-bottom: 0
        }

        .article-content h3 {
            font-size: 1.2em
        }

        .article-content h3,.article-content h4,.article-content h5{
            font-weight: bold;
        }

        .article-content h4,.article-content h5{
            font-size: 100%
        }

    </style>
</head>
<body>
<?php  include app::templateLink("page/navbar");?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="article-title">
                <span><?php
                    switch($articleType){
                        case 'article':
                            break;
                        case 'category':
                            echo 'Категория:';
                            break;
                        case 'news':
                            echo 'Хабар:';
                            break;
                    }
                    echo $articleTitle;?></span>
                <span class="float-right" style="font-weight: normal;vertical-align: middle; font-size: 0.85rem;"><?php
                    if($articleExists){
                        echo ' Забон: <select name="igxArticleLang" style="height: 19px;min-width: 140px;" onchange="location.href=this.value;">';

                        $interLangList=[];
                        switch($articleType){
                            case 'news':
                            case 'article':
                                $interLangList=ArticleList::articleInterLang($_connection,$articleLang,$articleTitle);
                                break;
                            case 'category':
                                $interLangList=CategoryList::categoryInterLang($_connection,$articleLang,$articleTitle);
                                break;
                        }

                        if(count($interLangList)<=0) $interLangList[]=['lang'=>$articleLang,'title'=>$articleTitle];
                        foreach($interLangList as $a){
                            $link="";
                            switch($articleType){
                                case 'article':
                                    $link=kb::articleLink($a['lang'],$a['title']);
                                    break;
                                case 'category':
                                    $link=kb::categoryLink($a['lang'],$a['title']);
                                    break;
                                case 'news':
                                    break;
                            }
                            echo "<option value='".$link."'". //article link

                                ($a['lang']==$articleLang?' selected':'').">". //is selected lang

                                Lang::getLangByCode($a['lang'])['label'].' ('.$a['lang'].")</option>";
                        }
                        echo '</select>';
                    }
                    ?>

                </span>
            </h3>
            <p class="small"><i><?=APP_BRAND_EN?> Knowledge Base</i></p>
            <div class="article-content">
                <?=$content?><?php
                if(isset($article)){
                    $articleCategories=$article->getCategories();
                    if(count($articleCategories)>0){
                        echo "".'<p class="article-categories breadcrumb">Категорияҳо: ';
                        if($articleExists){
                            $k=0;
                            foreach($articleCategories as $c){
                                $k++;
                                if($k>1) echo " | ";
                                echo kb::category($c['lang'],$c['title']);
                            }
                        }
                        echo '</p>';
                    }
                    else{
                        if(strtolower($articleTitle)!=='root'){
                            echo "".'<p class="article-categories breadcrumb">Категорияҳо: ';
                            $cat=CategoryList::getCategoryByInter($_connection,$articleLang,3);
                            if(isset($cat)){
                                echo kb::category($articleLang,$cat->getTitle());
                            }
                            echo '</p>';
                        }
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>
</body>
<?php include app::templateLink("page/_footer");?>
</html>