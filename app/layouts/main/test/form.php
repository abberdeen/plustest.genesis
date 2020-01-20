<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>Test | <?=APP_BRAND?></title>
    <?php
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
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
<body>
<?php include app::templateLink("page/navbar");?>
<div class="container">
    <div class="col-md-12">
        <?php
            $mch=new MultipleChoiceView(1,1,'');
            $mch->setData($asm->iterator()->current()->getTask());
            echo '<div class="card"><div class="card-block">';
            echo $mch->render();
            echo '</div></div><br>
<a href="?c=prev">&Lt;prev</a> <a href="?c=next">next &Gt;</a>';
        ?>
    </div>
</div>
</body>
<?php include app::templateLink("page/_footer");?>
</html>