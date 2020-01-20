<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title><?=$cmconf_name . '/' . $cmrule_id?> | <?=APP_BRAND;?></title>
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
            <form action="<?=$router->generate('man_cm_rule_save_edits',['cmrule_id'=>$cmrule_id])?>" method="post">
                <div class="form-group">
                    <h3 class="article-title">
                        <?=app::icon('icon8/User_Interface/horizontal_settings_mixer-48.png',32)?>
                        <?="<a href='".$router->generate('man_cm_conf_item',['item'=>$cmconf_name])."'>".$cmconf_name."</a>";?> / <?=$cmrule_id?></h3>
                    <br/>
                    <div class="form-group row ">
                        <label class="col-2 col-form-label col-form-label-sm" for="igxPickMethod">(task) pickMethod</label>
                        <span class="col-10">
                            <select name="igxPickMethod" id="igxPickMethod"  class="form-control form-control-sm">
                                <option value="0"></option>
                                <?php                                   foreach(PickMethod::getList() as $key=>$method){
                                    echo "<option value=\"".$key."\" ".($key==$pickMethod?'selected':'').">".$method['label']."</option>";
                                }
                                ?>

                            </select>
                        </span>
                    </div>
                    <div class="form-group row ">
                        <label class="col-2 col-form-label col-form-label-sm" for="igxThemeOrder">themesOrder</label>
                        <span class="col-10">
                            <select name="igxThemeOrder" id="igxThemeOrder"  class="form-control form-control-sm">
                                <option value="1">ASC</option>
                                <option value="2">DESC</option>
                                <option value="3">RAND</option>
                            </select>
                        </span>
                    </div>
                    <?=$outMaxPoint->render()?>
                    <?=$totalTime->render()?>
                    <div class="form-group row ">
                        <label class="col-2 col-form-label col-form-label-sm" for="">specRules</label>
                        <span class="col-10">
                            <textarea name="specRules" id="" cols="" rows="5" style="width: 100%;" class="form-control form-control-sm"><?=$cmrule[0]['cmrule_spec_rules']?></textarea>
                        </span>
                    </div>
                    <div class="form-group row ">
                        <label class="col-2 col-form-label col-form-label-sm" for="">creator</label>
                        <a href="<?=$router->generate('man_user_view',['item'=>$cmrule[0]['us_name']])?>" class="col-10"><?=$cmrule[0]['us_name']?></a>
                    </div>
                    <div class="form-group row ">
                        <label class="col-2 col-form-label col-form-label-sm" for="">creationDateTime</label>
                        <span class="col-10"><?=$cmrule[0]['cmrule_creation_datetime']?></span>
                    </div>

                    <h4>Custom pick rule</h4>
                    <p>Enabled if pick method is "Manual"</p>
                    <p>
                        <b>Params:</b><br>
                        Theme Id, <br>
                        Level in theme,<br>
                        Task count // task in theme with indicated level value<br>
                        Example: <i>[theme_id = X, level_in_theme = Y, task_count =  Z,], ...</i>
                    </p>
                    <textarea name="customRules" id="" cols="" rows="20" style="width: 100%;"  class="form-control form-control-sm"><?=$customRules?></textarea>
                    <br/><button type="submit">Save changes</button>
                </div>
            </form>
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