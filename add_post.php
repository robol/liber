<?php
echo "<html>";
echo "<head><title>New Post</title></head>";
echo "<body>";

echo '<form method="POST" action="write_changes.php">';




$xml=simplexml_load_file("contenuti.xml");

$posts=$xml->xpath("//post");


$pos=count($posts);

$date=mktime();

echo '<input type="hidden" name="pos" value="'.$pos.'">';
echo '<input type="hidden" name="date" value="'.$date.'">';

echo "<table>";
echo "<tr><td>Title</td>"; 
echo '<td><input type="text" size="30" name="title" value="'.$title.'"></td>';

echo "</tr></table>";
echo "<table>";
echo "<tr><td>Author</td>"; 
echo '<td><input type="text" size="30" name="author" value="'.$author.'"></td>';
echo "</tr></table>";


echo "<br><br>Post:<br>";
echo '<textarea rows="10" cols="50" name="body">';
echo $body;
echo "</textarea>";

echo "<table>";
echo "<tr><td>Tags</td>"; 
echo '<td><input type="text" size="30" name="tags" value="'.$tags.'"></td>';
echo "</tr></table>";


echo '<br><input type="submit" value="Save"></form>';
echo "</body></html>";
?>
