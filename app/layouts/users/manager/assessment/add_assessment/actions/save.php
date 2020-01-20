<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}


use Adapter\NewRow;

//Array ( [name] => adas [desc] => asd [date] => 2018-02-01 [time] => 03:03 [enabled] => 0 [visible] => 0 )
$n=new NewRow($_connection);
$n->newAssessment(
    '',
    app::POST('name'),
    app::POST('desc'),
    app::POST('date'),
    app::POST('time'),
    app::POST('enabled'),
    app::POST('visible')
);
app::redirect($router->generate('man_assessment_items'));



