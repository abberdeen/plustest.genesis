<?php

require_once(dirname(__FILE__) . '/../wikiParser.php');

$test = new wikiParser();

//echo ($test->parse(file_get_contents(dirname(__FILE__) . '/example.wiki')));
echo ($test->parse(file_get_contents(dirname(__FILE__) . '/betty.mediawiki')));

?>