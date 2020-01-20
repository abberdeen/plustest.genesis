<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>Фиристодани мактуб | <?=APP_BRAND?></title>
    <?php
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
</head>
<body>
<?php  include app::templateLink("page/navbar");?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <span class="text-primary"><h5>Мактуб фиристода шуд.</h5></span>
            <hr/>
            <div class="col-md-6 row">
                <b>Ташаккур барои мактуб.</b>
                Мактубатон ҳатман дида баромада мешавад ва масъалаҳои қайд карда дар муддати аз ҳама кӯтоҳтарин ҳал карда мешаванд.<br/>
                <br/>
                Ҳаволаи доимӣ, барои пайбарии ҳолати мактуб: <input  id="igxPermanentLink" disabled type="text" class="form-control form-control-sm text-primary" value="<?=$constant_link?>"/>
                <input  id="igxCopyLink" value="Нусха" type="button"/>
                <script>
                    igxCopyLink.addEventListener('click',function copy(){
                        clipboardData.setData('text','igxPermanentLink.value');
                    })
                </script>
            </div>
        </div>
    </div>
</div>
</body>
<?php include app::templateLink("page/_footer");?>
</html>