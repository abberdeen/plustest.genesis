<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title><?=$cmconfName?> | <?=APP_BRAND;?></title>
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
                <h3 class="article-title"><?=app::icon('icon8/User_Interface/horizontal_settings_mixer-48.png',32)?><?=$cmconfName?><span class="float-right small"><a href="">[edit]</a></span></h3>
                <?=$content;?>
            </div>
        </div>
        <div class="col-md-3">
            <?php include app::templateLink("page/manager_sidebar");?>
        </div>
</div>
</body>
<?php include app::templateLink("page/manager_footer");?>
<?=app::loadResource("js","plustest_genesis/ui.js")?>
<?=app::loadResource("js","plustest_genesis/ui_handler.js")?>
</html>