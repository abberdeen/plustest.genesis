<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>Welcome to <?=APP_BRAND;?> Management</title>
    <?php       include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
</head>
<body>
<?php include app::templateLink("page/manager_navbar");?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <center>
                <div class="card" style="width: 280px;">
                    <img src="<?=app::resourceLink('files/OAM.png')?>" alt="" width="280" align="center"/>
                </div>
                <br/>
                <span class="badge  badge-info" style="width: 280px;vertical-align: middle; ">
                    <h4 style="margin-bottom: 5px;color:black; vertical-align: middle;"><?=app::icon('icon8/Military/us_airborne-48.png',26).$_user->getName().'<span style="margin-left:5px;">'.app::icon('icon8/Military/us_airborne-right-48.png',26)?></span></h4>
                </span>
            </center>
        </div>
        <div class="col-md-3">
            <?php include app::templateLink("page/manager_sidebar");?>
        </div>
    </div>
</div>
</body>
<?php include app::templateLink("page/manager_footer");?>
</html>