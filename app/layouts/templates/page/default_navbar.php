<!--Navbar-->
<header class="navbar navbar-light bg-faded navbar-toggleable-md bd-navbar" style="margin-bottom: 40px;border-top: 3px solid #0275d8;box-shadow: 0 1px 0 rgba(12,13,14,0.1), 0 1px 6px rgba(59,64,69,0.1);"><?
    ?><nav class="container"><?
        ?><img src="<?=app::resourceLink('files/brand_light.png')?>" width="" height="32" class="d-inline-block align-top" alt="" style="margin-right: 5px;"><a class="navbar-brand" href="/"><?=APP_BRAND?></a><?
        ?><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bd-main-nav" aria-controls="bd-main-nav" aria-expanded="false" aria-label="Toggle navigation"><?
            ?><span class="navbar-toggler-icon"></span><?
            ?></button><?
        ?><div class="collapse navbar-collapse" id="bd-main-nav"><?
            ?><ul class="navbar-nav mr-auto"><?
                ?><li class="nav-item active"><?
                    ?><a class="nav-item nav-link" href="/"></a><?
                    ?></li><?
                ?></ul><?
            ?><ul class="navbar-nav"><?
                ?><?='<li class="nav-item active">'.
                '<a class="nav-item nav-link" href="'.$router->generate('auth_login').'">Даромадан</a>'.
                '</li>'?><?
                ?></ul><?
            ?></div></nav></header>
<!--Form-->
