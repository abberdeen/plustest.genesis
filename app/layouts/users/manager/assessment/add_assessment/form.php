<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>Add assessment | <?=APP_BRAND;?></title>
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
            <form action="<?=$router->generate('man_save_new_assessment')?>" method="post">
                <?=$name->render()?>
                <?=$desc->render()?>
                <?=$date->render()?>
                <?=$time->render()?>
                <div class="form-group row">
                    <div class="col-2"><p class="col-form-label-sm">Ҳолат</p></div>
                    <div class="col-10">
                        <?=$enabledTrue->render()?>
                        <?=$enabledFalse->render()?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-2"><p class="col-form-label-sm">Намоиш</p></div>
                    <div class="col-10">
                        <?=$visibleTrue->render()?>
                        <?=$visibleFalse->render()?>
                    </div>
                </div>
                <?=$btnSubmit->render()?>
            </form>
        </div>
        <div class="col-md-3">
            <?php include app::templateLink("page/manager_sidebar");?>
        </div>
    </div>
</div>
</body>
<?php include app::templateLink("page/manager_footer");?>
</html>