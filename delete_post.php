<?php


$pos=(int)$_GET["pos"];



$xml=simplexml_load_file("contenuti.xml");





unset($xml->post[$pos]);




$xml->asXML("contenuti.xml");

echo  'Done! <br /><br />';

include 'list_posts.php';

?>
