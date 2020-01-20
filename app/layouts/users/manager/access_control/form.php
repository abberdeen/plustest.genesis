<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>Access Control | <?=APP_BRAND;?></title>
    <?php
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
</head>
<body>
<?php include app::templateLink("page/default_navbar");?>
<div class="container">
    <div class="row">
        <center>
            <div class="col-md-6">
                <form action="<?=$router->generate('man_check_access')?>" method="post">
                    <input name="igxForm" type="hidden" value="123"/>
                    <div class="modal-header">
                        <h5  id="exampleModalLiveLabel">Access control</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group row">
                                <label for="igxKey" class="col-sm-3 col-form-label form-control-sm">Enter key:</label>
                                <div class="col-sm-9">
                                    <input id="igxKey" name="igxKey" type="text"  class="form-control form-control-sm"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" href="<?=$router->generate('auth_exit')?>">Баргаштан</a>
                        <button id="igxAccess" type="submit" class="btn btn-primary"> Continue</button>
                    </div>
                </form>
            </div>
        </center>
    </div>
</div>
</body>
<?php include app::templateLink("page/_footer");?>
</html>