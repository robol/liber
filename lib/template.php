<?php
	// This class provides method to get HTML pages from a template file(s) and raw data
	// usually obtained with the db class.
	
	// There should not be anything really liber-specific, so you are free to reuse it for
	// you own website (even without db class), because it is release under the GPL v2 or higher
	
	class template {
	
		private $tmpl_dir;
	
		// This function takes the DIR where templates file are stored;
		function __construct($tmpl_dir)
		{
			if(!is_dir($tmpl_dir))
			{
				return -1; // This means you haven't been honest with us...
			}
				
			$this->tmpl_dir = $tmpl_dir;
		}
		
		
		// This function provides a page giving the type (of the template) and the data.
		// This class assumes that the file $tmpl_dir/$type.tmpl exists and that every tag
		// in it that looks like "<% identifier%>" refer to an element of the array $data that
		// will be placed in there;
		function get_page_by_data($type, $data)
		{
			$handle = fopen($this->tmpl_dir . "/$type.tmpl" , 'r');
			if(!$handle)
				return -1; // I haven't been able to find the right template
				
			$buf = fread($handle, 255000); // Read the whole file
				
			fclose($handle);
			
			// Ora devo determinare tutti i tag che mi interessano
			preg_match_all("/<%(\w|[ \t])*%>/", $buf, $matches);
			$tags = $matches[0];
			
			// Piccola funzioncina per togliere le parentesi angolate dai tag
			function strip_tag($tag) { return trim( preg_replace("/(<%|%>)/", "", $tag) ); }
			$el = array_map("strip_tag", $tags);
			
			// TODO: Inserire una verifica della presenza dei tag in $data
			
			for($i=0; $i<sizeof($tags); $i++)
			{
				$buf = preg_replace("/$tags[$i]/", $data[$el[$i]], $buf);
			}
			
			return $buf;
		}
		
	}
?>
