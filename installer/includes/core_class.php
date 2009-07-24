<?php
/**
 * @name 	Core class
 * @author 	Yorick Peterse
 * @link 	http://www.yorickpeterse.com
 *
 */
class Core {
	// Function to validate the post data
	function validate_post($data)
	{
		// Counter variable
		$counter = 0;
		
		// Validate the hostname
		if(isset($data['hostname']) AND !empty($data['hostname']))
		{
			$counter++;
		}
		// Validate the username
		if(isset($data['username']) AND !empty($data['username']))
		{
			$counter++;
		}
		// Validate the password
		if(isset($data['password']) AND !empty($data['password']))
		{
		}
		// Validate the database
		if(isset($data['database']) AND !empty($data['database']))
		{
			$counter++;
		}
		
		// Check if all the required fields have been entered
		if($counter == '3')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	// Function to show an error
	function show_message($type,$message)
	{
		return "<div id=\"$type\" class=\"message\">$message</div>";
	}
	
	
	// Function to write the config file
	function write_config($data)
	{
		// Config path
		$template_path 	= 'config/database.php';
		$output_path 	= '../application/config/database.php';
		
		// Open the file
		$database_file = file_get_contents($template_path);
		
		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['username'],$new);
		$new  = str_replace("%PASSWORD%",$data['password'],$new);
		$new  = str_replace("%DATABASE%",$data['database'],$new);
		
		// Write the new database.php file
		$handle = fopen($output_path,'w+');
		
		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);
		
		// Verify file permissions
		if(is_writable($output_path))
		{
			// Write the file
			if(fwrite($handle,$new))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	// Function to clean Pyro's cache
	function clean_cache($cache_dir)
	{		
		// Check if it is a directory
		if(is_dir($cache_dir))
		{
			// Open the directory and set the $handle variable
			$handle = opendir($cache_dir);
			
			// Loop through each file
			while (FALSE !== ($item = readdir($handle)))
			{
				// Ignore the current directory or the parent directory
				if($item != '.' AND $item != '..')
				{
					// Set the full file path
					$file_path = $cache_dir . "/" . $item;
					
					// Check to see if the file is a directory, if so recall this function
					if(is_dir($file_path))
					{
						$this->clean_cache($file_path);
					}
					// It's a file
					else
					{
						// Remove the file
						unlink($file_path);
					}					
				}
			}
			
			// Close the directory handle
			closedir($handle);
			
			// Delete the directory
			if(!rmdir($cache_dir))
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	// Function to recreate the cache directory
	function create_cache_dir($directory)
	{
		// Create the directory
		if(mkdir($directory))
		{
			// Chmod the dir to 777
			chmod($directory,0777);
			
			// Create the index.html file
			$template = file_get_contents("cache_files/index.html");
			$new_file = $directory."/index.html";
			
			// Create the file
			$handle = fopen($new_file,'w+');
			
			// Write the file
			if(fwrite($handle,$template))
			{
				return true;
			}
			else
			{
				return false;
			}		
		}
		else
		{
			return false;
		}
	}
}
?>