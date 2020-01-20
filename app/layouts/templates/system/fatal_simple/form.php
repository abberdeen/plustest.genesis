<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<?php
if(DEBUG_MODE_ENABLED){
   exit;
}
?>
<html><head>
    <title>INTERNAL ERROR | <?=APP_BRAND?></title>
    <?php
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
    <style>
        .nb-error {
            margin: 0 auto;
            text-align: center;
            max-width: 480px;
            padding: 60px 30px;
        }

        .nb-error .error-code {
            color: #2d353c;
            font-size: 96px;
            line-height: 100px;
        }

        .nb-error .error-desc {
            font-size: 12px;
            color: #647788;
        }
        .nb-error .input-group{
            margin: 30px 0;
        }
    </style>
</head>
<body>
<div class="nb-error">
    <h3 class="font-bold text-default">NEVERMIND!</h3>
    <br/>
    <div class="error-desc">
        Хатогие ба вуқӯъ омад, ки аз паси он давом додани амалиёти дархост намуда ғайриимкон аст.<br>
        Лутфан ба нозир ё маъмурияти системаи имтиҳонот хабар диҳед.
    </div>
    <br/>
    <hr/>
    <div class="font-bold text-danger">INTERNAL ERROR | CODE: <?=$error_code?></div>
    <hr/>
</div>
</body>
</html>