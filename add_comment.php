
<?php
echo "<html>";
echo "<head><title>New Comment</title></head>";
echo "<body>";

$pos=$_GET["pos"];

echo '<form method="POST" action="save_comment.php">';




echo '<input type="hidden" name="pos" value="'.$pos.'">';

echo "<table>";
echo "<tr><td>Your name</td>";
echo '<td><input type="text" size="30" name="author"></td>';
echo "</tr></table>";



echo "<br><br>Comment:<br>";
echo '<textarea rows="10" cols="50" name="comment">';

echo "</textarea>";




echo '<br><input type="submit" value="Save Comment"></form>';
echo "</body></html>";
?>
