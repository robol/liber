<?php 

$xml=simplexml_load_file("contenuti.xml");

//arrays
$dates=$xml->xpath("//date");
$titles=$xml->xpath("//title");
$bodies=$xml->xpath("//body");
$authors=$xml->xpath("//author");
$tags=$xml->xpath("//tags");
$comments=$xml->xpath("//comments");	


arsort($dates, SORT_NUMERIC);

echo '[<a href="read_xml.php">blog</a>]';
echo '[<a href="add_post.php">new post</a>]<br /><br />';

echo '<table width="800">';
foreach ($dates as $k => $value) {
	echo "<tr>";
	$date_formatted=date('Y-m-d',intval($value));
	echo "<td>".$date_formatted."</td>";	
	echo "<td>".$titles[$k]."</td>";
	echo "<td>".$authors[$k]."</td>";
	echo "<td>".$tags[$k]."</td>";
	$view='[<a href="show_post.php?pos='.$k.'">view</a>]';
	echo "<td>$view</td>";
	$modify='[<a href="modify_post.php?pos='.$k.'">modify</a>]';
	echo "<td>$modify</td>";
	$delete='[<a href="delete_post.php?pos='.$k.'">delete</a>]';
	echo "<td>$delete</td>";
	echo "</tr>";

		
}

echo "</table>";

//$date_unix=mktime();	

//echo $date_unix."</br>";

//$date_default=date('Y-m-d H:i:s',$date_unix);
//echo $date_default;

//echo count($titoli)."<br />";


//print_r($dates);

?>