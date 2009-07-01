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
		function get_page_by_data_tmpl($template, $data)
		{
			
			// Single lines are useful when parsing!
			$lines = explode("\n" , $template );
			
			// Get the tags to look for
			$tags = array_keys($data);
			
			// Remove posts, because they are not standard tags
			for($i=0; $i<sizeof($tags); $i++)
			{
				if($tags[$i] == "posts")
					unset($tags[$i]);
			}
			$tags = array_values($tags);
			
			// Initialize vars
			$in_posts = False;
			$output = "";
						
			// Start parsing the template file
			foreach ($lines as $line)
			{
				// Check if we need to start postlist
				if (preg_match("/<%([ \t])*begin_posts([ \t])*%>/",$line))
				{		
   				$line = preg_replace("/<%([ \t])*begin_posts([ \t])*%>/", '', $line);
   				$in_posts = True;
   			}
   			
   			// Check if we need to end postlist
   			if (preg_match("/<%([ \t])*end_posts([ \t])*%>/",$line))
   			{
   				$line = preg_replace("/<%([ \t])*end_posts([ \t])*%>/", '', $line);
   				$post_struct = $post_struct.$line;
   				$in_posts = False;
   				// Generate the posts...
   				foreach( $data["posts"] as $post )
   				{
   					$output .= $this->get_page_by_data_tmpl($post_struct, $post);
   				}
   			}
   			
   			if( $in_posts )
   			{
   				$post_struct .= $line . "\n"; // We are scanning postlist
   			}
   			else
   			{
					// This does standard substitutions
					for($i=0; $i<sizeof($tags); $i++) 
					{ 
						$line = preg_replace("/<%([ \t])*$tags[$i]([ \t])*%>/", $data[$tags[$i]], $line); 
					}
					$output .= $line . "\n";
				}
			}
			
			return $output;
		}
		
		
		function get_page_by_data_type($type, $data)
		{
			
			$handle = fopen($this->tmpl_dir . "/$type.tmpl" , 'r');
			if(!$handle)
				return -1; // I haven't been able to find the right template
				
			$buf = fread($handle, 255000); // Read the whole file
			fclose($handle);
			
			return $this->get_page_by_data_tmpl($buf, $data);
		}
		
	}
?>
