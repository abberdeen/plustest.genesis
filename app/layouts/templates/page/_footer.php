<?php
use System\Culture\Lang;
?>
<div id="pgSpace" style="height: 80px;"></div>
<!--Footer-->
<?app::loadResource("css","collection/footer.css")?>
<footer class="footer text-muted"><div class="container"><?
        ?><div class="row"><?
            ?><div class="col-md-8">
                <ul class="footer-links"><?
                    ?><li><a href="https://www.facebook.com/pas.dpdtt" target="_blank">Facebook</a></li><?
                    ?><li><a href="<?=kb::articleLinkByInter($_app_lang,6)?>">Маълумот</a></li><?
                    ?><li><a href="<?=$router->generate('cpl_shared')?>">Шикоят/Пешниҳод</a></li><?
                    ?></ul><?
                ?></div><style>.igxLangSelector{height: 19px;min-width: 140px;vertical-align: middle;}</style><?
            ?><div class="col-md-4"><?
                ?><ul class="footer-links" style="text-align: right;"><li><?
                        ?><form action="<?=$router->generate('app_lang')?>" method="post" name="igxFormLangSelect" onchange="submit()"><?
                            ?><?=app::icon('icon8/Maps/globe-white-48.png',22,false,'0');?><select name="igxLangSelector" class="igxLangSelector"><?php
                                foreach(Lang::$list as $lang){
                                if($lang['active']){
                                echo "<option value=\"".$lang['code']."\"".($lang['code']==$_app_lang?' selected':'').">".$lang['label']." (".$lang['code'].")</option>";
                                }
                                }
                                ?></select></form></li></ul></div></div><p><?php echo str_replace("\n","</p><p>",APP_COPYRIGHT);?></p></div>
</footer>
<!--Script-->
<?="<script>window.jQuery || document.write('<script src=\"".(app::resourceLink("jquery/js/jquery.min.191.js"))."\"><\\/script>')</script>\n"?>
<?app::loadResource("js","tether/js/tether.min.js")?>
<?app::loadResource("js","bootstrap/js/bootstrap.min.js")?>
<?app::loadResource("js","plustest_genesis/igx_request.js")?>
<script type="text/javascript" src="<?=$router->generate('app_igx_request_lib')?>" async=""></script>
