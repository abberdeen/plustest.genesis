<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>View policy | <?=APP_BRAND;?></title>
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
                <h3 class="article-title"><?=app::icon('icon8/Finance/purchase_order-48.png',32)?><?=$policyName?></h3>
                <hr/>
                <?php                   if($policyExists){
                    echo "<ul>";
                    echo "<li>1</li>";
                    echo "</ul>";
                    echo "<hr/><p><span class='badge badge-primary'>Object browser</span></p>";
                    echo ViewExt::RouteGen($router,$policy->toHtml());
                }
                else{
                    app::msg('','Policy not exists.','You may create policy <a href="'.$router->generate('man_policy_add').'?n='.$policyName.'">'.$policyName.'</a>');
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
<?app::loadResource("js","plustest_genesis/ui.js");?>
<?app::loadResource("js","plustest_genesis/ui_handler.js");?>
</html>