<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <?php       include app::templateLink("page/_meta");
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
<?php include app::templateLink("page/navbar");?>
<div class="nb-error">
    <h3 class="font-bold">Гузарвожаи Шумо хатарнок аст</h3>
    <br/>
    <div class="error-desc">
        Барои бехатар гардондани аккаунти худ, лутфан гузарвожаи ҳозираро ба гузарвожаи душвортар иваз намоед.
        <?=$btnLater->render()?><?=$btnChangePass->render()?>
    </div>
</div>
</body>
<?php   include app::templateLink("page/_footer");
?>
</html>