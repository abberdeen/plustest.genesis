<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <?php
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
    <title>Даромад | <?=APP_BRAND?></title>
</head>
<body>
<?php  include app::templateLink("page/navbar");?>
<div class="container"><div class="row justify-content-center">
        <div class="col-md-4"><?
            ?><form action="<?=$router->generate('auth_check')?>" method="post" name="<?=md5(time())?>"><input type="hidden" name="_CSRF" value=""/><?
                ?><?=$usernameView->render();?><?
                ?><?=$passwordView->render();?><?
                ?><div class="form-group"><?
                    ?><?=$submitView->render();?></div><?
                ?></form><?
            ?></div><?
        ?><div class="col-md-8" style="margin-top:3rem;"><center><?php
                if(isset($_SESSION['already_leave'])){
                echo "<h2>Аллакай меравед?</h2> <h2>Боз биёед!</h2>";
                unset($_SESSION['already_leave']);
                }
                elseif(isset($_SESSION['cauth_saygoodbye'])){
                echo "<h2>Хуш бошед, боз биёед!</h2>";
                unset($_SESSION['cauth_saygoodbye']);
                }
                else{
                }
                ?></center></div>
    </div>
</div>
</body>
<?php include app::templateLink("page/_footer");?>

<?php app::loadResource("js","collection/js/IACShortcut.js");?></html>