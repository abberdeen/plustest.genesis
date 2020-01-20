<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}?> 
<html>
<head>
    <title>{page-title} | <?=APP_BRAND;?></title>
	<?php
    app::templateLink("page/_meta");
    app::templateLink("page/_links");
    ?>
</head>
<body>
<?php include app::templateLink("page/navbar");?>
<div class="container">
    <div class="row">
        <div class="col-md-9">

        </div>
        <div class="col-md-3">
            <?php include app::templateLink("page/_sidebar");?>
        </div>
    </div>
</div>
</body>
<?php include app::templateLink("page/_footer");?>
</html>
