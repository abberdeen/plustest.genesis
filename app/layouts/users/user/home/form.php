<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>Welcome to <?=APP_BRAND;?></title>
    <?php
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
</head>
<body>
<?php include app::templateLink("page/user_navbar");?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-3">
                <div style="background: url(<?=app::resourceLink('files/IMG_3010.JPG')?>);
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat; height: 180px;"></div>
                <div class="card-block">
                    <h4 class="card-title">Маркази Тестӣ</h4>
                    <p class="card-text">Маркази Тестии (МТ) ДПДТТХ бо мақсади ташкили гузаронидани имтиҳонҳои
                        маъмурии марказонидашуда таъсис ёфтааст. Низоми уникалии имтиҳонҳои маъмурӣ якумин дар
                        байни Мактабҳои олии Тоҷикистон ташкил гардида аст. </p>
                    <p class="card-text"><small class="text-muted"><?=kb::a("tg","Маркази_Тестӣ","Муфассалтар")?></small></p>
                </div>
            </div>
            <?=$eventLink?>
        </div>
        <div class="col-md-3">
            <?php include app::templateLink("page/user_sidebar");?>
        </div>
    </div>
</div>
</body>
<?php include app::templateLink("page/_footer");?>
</html>