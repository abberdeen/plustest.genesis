<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>404 | <?=APP_BRAND?></title>
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
<?php include app::templateLink("page/navbar");?>
<div class="nb-error">
    <div class="error-code">404</div>
    <h3 class="font-bold">Саҳифаро пайдо карда натавонистем..</h3>
    <br/>
    <div class="error-desc">
        Афсӯс, аммо саҳифаи ҷустуҷӯ кардаи Шумо пайдо нашуд ё мавҷуд нест.<br/>
       <!--<ul class="list-inline text-center text-sm">
            <li class="list-inline-item"><a href="http://nextbootstrap.com" class="text-muted">Go to App</a>
            </li>
            <li class="list-inline-item"><a href="http://nextbootstrap.com" class="text-muted">Login</a>
            </li>
            <li class="list-inline-item"><a href="http://nextbootstrap.com" class="text-muted">Register</a>
            </li>
        </ul>-->
    </div>
</div>
</body>
<?php   include app::templateLink("page/_footer");
?>
</html>