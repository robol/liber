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


foreach ($dates as $k => $value) {
	echo "<b>".$titles[$k]."</b><br />";	
	echo "<p>".$bodies[$k]."</p>";
	$date_formatted=date('Y-m-d',intval($value));		   
	echo "<i>".$authors[$k]."</i> - <i>".$date_formatted."</i> - <i>".$tags[$k]."</i><br />";
	echo "<p>".$comments[$k]."</p><br />";
		
}



//$date_unix=mktime();	

//echo $date_unix."</br>";

//$date_default=date('Y-m-d H:i:s',$date_unix);
//echo $date_default;

//echo count($titoli)."<br />";


//print_r($dates);

?>