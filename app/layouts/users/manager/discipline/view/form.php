<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>View user | <?=APP_BRAND;?></title>
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
                <h3 class="article-title"><?=$dcpName?></h3>
                <hr/>
                <p><h5>List of materials:</h5></p>
                <?php
                if($dcpExists){
                    echo $table->render();
                }
                else{
                    app::msg('','Discipline not exists.','');
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
<?include app::templateLink("page/manager_footer");?>
<?app::loadResource("js","plustest_genesis/ui.js")?>
<?app::loadResource("js","plustest_genesis/ui_handler.js")?>
</html>