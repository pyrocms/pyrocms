<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @name 	Widgets Library
 * @author 	Yorick Peterse
 * @link	http://www.yorickpeterse.com/	
 * @version 0.5a1
 * @license	MIT License
 * 
 * Copyright (c) 2009 Yorick Peterse
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */
class Widgets {
	
	public $CI;
	
	/**
	 * Core functions
	 *
	 * Functions that are required in order to run the Widgets library
	 *
	 */
	
	function Widgets()
	{
		$this->CI =& get_instance();
	}

	
	// Get a list of all the plugins that are currently activated and execute them
	public function area($area)
	{		
		// Create the query to fetch the names of all activated widgets
		$this->CI->db->select(array('name','area'));
		$this->CI->db->like('area',$area);
		$query = $this->CI->db->get_where('widgets',array('active' => 'true'));
		
		// Verify the results
		if($query->num_rows() > 0)
		{
			// Store the results
			$widgets = $query->result_array();
			
			// Execute each widget
			foreach($widgets as $widget)
			{
				$areas = explode(",",$widget['area']);
				
				// Only run the widgets for the current area
				if(in_array($area,$areas))
				{
					$this->load($widget['name']);
				}			
			}
		}
		else
		{
			return false;
		}
	}
	
	
	// Function to run a widget based on the name, by default it will run all widgets
	private function load($name = null)
	{		
		// Verify if the file exists at all
		if(file_exists(APPPATH . "widgets/$name/$name.php") == true)
		{
			// Open the widget
			require_once(APPPATH . "widgets/$name/$name.php");
			
			// First letter needs to be uppercase, in case the user forgets this
			$class  = ucfirst($name);

			// Create the widget class
			$widget = new $class();			
			
			// Verify if we can actually call the function at all
			if(is_object($widget))
			{		
				// Execute the run() function with the specified arguements
				return $widget->run();
			}
			else
			{
				// Show an error
				show_error("The run function of the $name widget could not be executed, please verify that the function exists.");
				
				// Log the results
				log_message('error',"Widgets Library - The run function of the $name widget could not be executed.");
				
				// Prevent any other code from being executed
				exit();				
			}
		}
		else
		{
			// Show an error
			show_error("The $name widget couldn't be loaded, please verify that the file exists.");
			
			// Log the results
			log_message('error',"Widgets Library - The $name widget could not be loaded.");
				
			// Prevent any other code from being executed
			exit();
		}
	}
	
	// Function to display a widget's view file. All variables should contain the widget_ prefix in order to prevent name collisions
	public function display($widget_name,$widget_view,$widget_data = array())
	{		
		// Verify the view file
		if(file_exists(APPPATH . "widgets/$widget_name/views/$widget_view.php"))
		{
			// Load the view file
			$view_file = $this->CI->load->view('../widgets/'.$widget_name.'/views/'.$widget_view, $widget_data,true);
			echo '<li>'.$view_file.'</li>';
			
		}
		else
		{
			// Show an error
			show_error("The view file for the $widget_name widget could not be loaded, please verify that the file exists.");
			
			// Log the results
			log_message('error',"Widgets Library - The view file for the $widget_name widget could not be laoded.");
			
			// Prevent any other code from being executed
			exit();
		}		
	}
	
	
	/**
	 * Data handling functions
	 *
	 * Functions can be user as a simplified way of updating or retrieving database data. 
	 *
	 */
	
	
	// Function to retrieve the widget data from the body field (MUST BE JSON!!)
	public function get_data($name,$key = '0')
	{		
		// Create the query
		$this->CI->db->select('body');		
		$query = $this->CI->db->get_where('widgets',array('name' => $name));		
		
		// Return the results
		$results = $query->result_array();
		
		// Turn the results into a single array
		foreach($results as $row)
		{

			// Decode the JSON string into an associative array
			$array 	= json_decode($row['body'],true);						

			// Do we want to return all settings, or just a single one ?				
			return $array[$key];
		}
	}
	
	
	/*
	 * Information functions
	 * 
	 * These function can be used to retrieve widget information, such as the author, description, etc
	 */
	
	
	// Function to parse the widgets.json file in each widget directory
	public function get_widget_info($name,$key = 'all')
	{
		if(!empty($name))
		{
			// Does the file exist ?
			if(file_exists(APPPATH ."widgets/$name/widget.json"))
			{
				// Get the JSON string
				$json_string = file_get_contents(APPPATH ."widgets/$name/widget.json");
				
				// Decode it
				$decode = json_decode($json_string,true);
				
				if($key !== 'all')
				{
					// Get the single key
					return $decode[$key];
				}
				else
				{
					// Return the results
					return $decode;
				}				
			}
			else
			{
				// Show an error
				show_error('The widget.json file does not exist!');
				
				// Load the error
				log_message('error','Widgets Library - The widget.json file does not exist!');
				exit();
			}
		}
		else
		{
			// Show an error
			show_error('No widget name has been specified!');
			
			// Log the error
			log_message('error','Widgets Library - No widget name has been specified!');
			exit();
		}
	}
	
	
	// Function to get a list of all available areas that are defined in the areas.json file
	function get_areas($path = null)
	{
		if($path != null)
		{
			// Get the json file
			$json_string = file_get_contents(APPPATH.$path);	
			
			// Decode it	
			$decode = json_decode($json_string,true);
			
			// Return it	
			return $decode;
		}
		else
		{
			// Show an error
			show_error('The areas.json file could not be found!');
			
			// Log the error
			log_message('error','WIdgets Library - Areas.json could not be found');
		}
		
	}
	

	// Function to get the names of all widgets, either activated or deactivated
	function get_widget_names($activated = null)
	{
		if($activated !== null)
		{
			// Active or not ?
			if($activated == 'activated')
			{
				$activated = 'true';
			}
			else
			{
				$activated = 'false';				
			}

			// Query time
			$this->CI->db->select('name');
			$query = $this->CI->db->get_where('widgets',array('active' => $activated));
			
			if($query->num_rows() > 0)
			{
				// Set the $results variable
				$results = $query->result_array();
				
				// Create an empty array
				$names = array();
				
				// Loop through each row
				foreach($results as $row)
				{
					$names[] .= $row['name'];
				}
				
				// Return the results
				return $names;				
			}
		}
		else
		{
			// Show an error
			show_error('The widget state(activated/deactivated) is not specified!');
			
			// Load the error
			log_message('error','Widgets Library - The widget state(activated/deactivated) is not specified!');
			exit();
		}
	}
	
	
	/**
	 * Maintenance functions
	 *
	 * The functions below will install the widget or activate/deactivate it.
	 *
	 */
	
	
	// Function to install a widget, should only be triggered once
	public function install_widget($name,$body)
	{
		// Set the fields
		$data['id']		= 'id';
		$data['name'] 	= strtolower($name);
		$data['body'] 	= json_encode($body);
		$data['active'] = 'false';
		
		// Query to create the row for the widget
		$this->CI->db->insert('widgets',$data);
		
		// Log the results
		log_message('info',"Widgets Library - The following widget has been installed : $name");
	}
	
	
	// Function to uninstall a widget
	public function uninstall_widget($name)
	{
		// Delete the widget's table row
		$this->CI->db->delete('widgets',array('name' => strtolower($name)));
		
		// Log the results
		log_message('info',"Widgets Library - The following widget has been uninstalled : $name");
	}
	
	
	// Function to activate a widget (after it has been installed)
	public function activate_widget($name)
	{		
		// Update it
		$this->CI->db->where('name',strtolower($name));
		$this->CI->db->update('widgets',array('active' => 'true'));
		
		// Log the results
		log_message('info',"Widgets Library - The following widget has been activated : $name");
	}
	
	
	// Function to deactivate a widget (after it has been activated)
	public function deactivate_widget($name)
	{
		// Update it
		$this->CI->db->where('name',strtolower($name));
		$this->CI->db->update('widgets',array('active' => 'false'));
		
		// Log the results
		log_message('info',"Widgets Library - The following widget has been deactivated : $name");
	}
	
}
?>