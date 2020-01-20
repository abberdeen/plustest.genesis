<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title><?=APP_BRAND?></title>
    <?php
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    app::loadResource("css","collection/main.css");
    ?>
    <style>
        .frm-control{
            font-size: 0.9rem;
            font-family:  Roboto,"Helvetica Neue",Arial,sans-serif;
            width: 100%;
        }
        .frm-control-sm{
            height: 1.3rem;
        }
        .frm-control-label{
            padding-top: 0;
        }
    </style>
</head>
<body id="intro" class="main style1 dark fullscreen">
<?php include app::templateLink("page/navbar");?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <center style="margin-top: 4%;">
                <img src="/app/resources/files/brand_light.png" alt="" align="center" style="width: 6rem;">
                <h2 style="color:#fdfdfe;  text-shadow: 1px 1px 6px black; font-size: 3rem;" align="center"><?=APP_BRAND?></h2>
                <br>
                <a href="<?=$router->generate("auth_login");?>" class="btn btn-primary"
                       style="width: 120px;    box-shadow: 1px 1px 7px 0px #1f1f1f;">Даромадан</a>
            </center>
        </div>
    </div>
</div>
</body>

<?php include app::templateLink("page/_footer");?>
</html>