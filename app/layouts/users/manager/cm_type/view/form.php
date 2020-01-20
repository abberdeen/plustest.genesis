<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>Control mechanism type | <?=APP_BRAND;?></title>
    <?php       include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
</head>
<body>
<?php include app::templateLink("page/manager_navbar");?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <?=$breadcrumb->render()?>
            <div class="form-group">
                <h3 class="article-title"><?=app::icon('icon8/Very_Basic/settings-48.png',32)?><?=$cmName?></h3>
                <hr/>
                <?php                   if($cmExists){
                    echo "<p><span class='badge badge-primary'>Object browser</span></p>";
                    echo ViewExt::RouteGen($router,$cm->toHtml());
                }
                else{
                    app::msg('','Control mechanism not exists.','You may create control mechanism <a href="'.$router->generate('man_cm_type_add').'?n='.$cmName.'">'.$cmName.'</a>');
                }
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <?php include app::templateLink("page/manager_sidebar");?>
        </div>
    </div>
</div>
</body>
<?php include app::templateLink("page/manager_footer");?>
<?=app::loadResource("js","plustest_genesis/ui.js")?>
<?=app::loadResource("js","plustest_genesis/ui_handler.js")?>
</html>