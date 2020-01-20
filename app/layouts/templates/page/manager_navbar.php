<?php
use System\Enums\AuthenticationState;
?>
<!--Manager Navbar-->
<header class="navbar sticky-top navbar-inverse   navbar-toggleable-sm" style="background-color: #1d1d1d;box-shadow: 0 1px 0 rgba(12,13,14,0.1), 0 2px 6px rgba(59,64,69,0.1);"><nav class="container"><?
        ?><a class="navbar-brand" href="/"><?
            ?><img src="<?=app::resourceLink('files/oam_logo.png')?>" width="" height="32" class="d-inline-block align-top" alt=""> <?=APP_BRAND?></a><?
        ?><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bd-main-nav" aria-controls="bd-main-nav" aria-expanded="false" aria-label="Toggle navigation"><?
            ?><span class="navbar-toggler-icon"></span><?
            ?></button><?
        ?><div class="collapse navbar-collapse" id="bd-main-nav"><?
            ?><ul class="navbar-nav mr-auto"><?
                ?><li class="nav-item active">
                    <a class="nav-item nav-link" href="/"></a>
                </li><?php
                if($_user_auth->AuthenticationState()==AuthenticationState::SUCCESS){
                    $nav_items=[
                        'man_home'=>'Саҳифаи асосӣ',
                    ];
                    foreach($nav_items as $key=>$value){
                        echo '<li class="nav-item">'.
                            '<a class="nav-item nav-link'.($match["name"]==$key?" active":"").'" href="'.$router->generate($key).'">'.$value.'</a>'.
                            '</li>';
                    }
                }
                ?>
            </ul><ul class="navbar-nav"><?php
                if($_user_auth->AuthenticationState()==AuthenticationState::SUCCESS){
                    echo
                        '<li class="nav-item dropdown">'.
                        '<a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                        $_user->getDisplayName().
                        '</a>'.
                        '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">'.
                        '<a class="dropdown-item" href="'.$router->generate('auth_exit').'"> Баромадан</a>'.
                        '</div>'.
                        '</li>';
                }
                else{
                    echo
                        '<li class="nav-item active">'.
                        '<a class="nav-item nav-link" href="'.$router->generate('auth_login').'">Даромадан</a>'.
                        '</li>';
                }
                ?></ul></div></nav>
</header>
<div style="margin-bottom: 40px;"></div>
<!--Form-->

