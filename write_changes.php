<?php
$xml=simplexml_load_file("contenuti.xml");

$pos=(int)$_POST["pos"];




$title=$xml->post[$pos]->title;
$body=$xml->post[$pos]->body;
$date=$xml->post[$pos]->date;
$tags=$xml->post[$pos]->tags;
$author=$xml->post[$pos]->author;



$xml->post[$pos]->title=$_POST["title"];

$xml->post[$pos]->body=$_POST["body"];
$xml->post[$pos]->date=$_POST["date"];
$xml->post[$pos]->tags=$_POST["tags"];
$xml->post[$pos]->author=$_POST["author"];




$xml->asXML("contenuti.xml");

echo  'Done! <br /><br />';

include 'list_posts.php';


?>