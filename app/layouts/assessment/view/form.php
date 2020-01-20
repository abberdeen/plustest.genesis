<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<?php
use System\Enums\TaskType;
?>
<html><head>
    <title>Event | <?=APP_BRAND?></title>
    <?php
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
    <style>
        .task-content{
            font-family: Roboto, sans-serif;
            font-size: 100%;
        }
    </style>
    <script>
        function la_las(a,b){

        }
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
</head>
<body class="no-select">

<?php include app::templateLink("page/assessment_navbar");?>

<form action="<?=$router->generate('assessment_action')?>" method="post" class="hidden" name="pgTaskResponse">
    <input type="hidden" value="<?=$_SESSION[SS_FORM_TOKEN]?>" name="FORM_ID">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <?=UIControls::tokenBox();?>
            </div>
            <div id="pgTaskContent" class="col-md-8">
                <div style="background: #fffded;">
                    <?=$progressIndicator?>
                    <hr>
                    <?=$taskView->render()?>
                </div>
            </div>

            <div class="col-md-2">
            </div>
        </div>
    </div>
    <div style="bottom: 6rem;position: absolute;width: 100%;"></div>
    <div class="container">
        <div class="row" >
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <center>
                    <div style="width:100%; height:80px; ">
                        <?=$controlButtons?>
                    </div>
                </center>
            </div>
        </div>
    </div>
</form>
</body>

<?php include app::templateLink("page/assessment_footer");?>

</html>