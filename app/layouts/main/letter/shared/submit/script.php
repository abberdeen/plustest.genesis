<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

use Adapter\App\AppLetter;

if(!isset($_SESSION['cpl_shared_post'])){
    app::redirect($router->generate('cpl_shared'));
    die();
}
unset($_SESSION['cpl_shared_post']);

$appLetter=new AppLetter($_connection);
$type=app::POST('igxCplLetterType');
$theme=app::POST('igxCplTheme');
$caption=app::POST('igxCplCaption');
$text=app::POST('igxCplContent');



if(strlen($text)>20){
    $appLetter->addLetter($type,$theme,$caption,$text);
}
else{
    app::redirect($router->generate('cpl_shared'));
    die();
}

$constant_link=$_SERVER['HTTP_HOST'].$router->generate('cpl_letter_view',
                                                            ['hash'=>$appLetter->letterHash($caption,$text)]
                                                          );



