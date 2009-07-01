<?php 

include 'config.php';

$flag=0;
$post_struct="";

$xml=simplexml_load_file("contenuti.xml");

//arrays
$dates=$xml->xpath("//date");
$titles=$xml->xpath("//title");
$bodies=$xml->xpath("//body");
$authors=$xml->xpath("//author");
$tags=$xml->xpath("//tags");
$comments=$xml->xpath("//comments");	


arsort($dates, SORT_NUMERIC);




$lines=file($template, FILE_SKIP_EMPTY_LINES);

   

foreach($lines as $line){



if (preg_match("/<%blog_title%>/",$line))
   {$line=preg_replace("/<%blog_title%>/",$blog_title,$line);}

if (preg_match("/<%begin_posts%>/",$line)){		
   $line=preg_replace("/<%begin_posts%>/", '', $line);
   $flag=1;
   }




if (preg_match("/<%end_posts%>/",$line)){
   $line=preg_replace("/<%end_posts%>/", '', $line);
   $post_struct=$post_struct.$line;
   $flag=0;
   foreach ($dates as $k => $value) {
   $post=preg_replace("/<%title%>/",$titles[$k] , $post_struct);
   $post=preg_replace("/<%author%>/",$authors[$k] , $post);
   $post=preg_replace("/<%body%>/",$bodies[$k] , $post);
   $post=preg_replace("/<%tags%>/",$tags[$k] , $post);
   $date_formatted=date('Y-m-d',intval($value));
   $post=preg_replace("/<%date%>/",$date_formatted , $post);
   $post=preg_replace("/<%comments%>/",$comments[$k] , $post);
   echo $post;
   }


   }


if ($flag==1){
   $post_struct=$post_struct.$line;
   $line="";
   }





else {echo $line;}

}



?>