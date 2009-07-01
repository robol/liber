<?php
$xml=simplexml_load_file("contenuti.xml");



$pos=(int)$_POST["pos"];


$author_comment=$_POST["author"];
$new_comment=$_POST["comment"];



$comments=$xml->post[$pos]->comments;
$comments=$comments."<p>".$author_comment." wrote: ".$new_comment."</p>";



$xml->post[$pos]->comments=$comments;


$xml->asXML("contenuti.xml");

echo  'Comment saved! <br /><br />';

include 'read_xml.php';


?>