<?php


echo '[<a href="list_posts.php">list posts</a>]<br /><br />';

$pos=(int)$_GET["pos"];

$xml=simplexml_load_file("contenuti.xml");
$xml=simplexml_load_file("contenuti.xml");


$title=$xml->post[$pos]->title;
$body=$xml->post[$pos]->body;
$date=$xml->post[$pos]->date;
$tags=$xml->post[$pos]->tags;
$author=$xml->post[$pos]->author;

echo "<b>".$title."</b><br />";    
echo "<p>".$body."</p>";
$date_formatted=date('Y-m-d',intval($date));              
echo "<i>".$author."</i> - <i>".$date_formatted."</i> - <i>".$tags."</i><br />";
echo "<p>".$comments."</p><br />";




?>