<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * CodeIgniter - Rackspace Cloudfiles API
 *
 * Description:
 * This library helps you use the Rackspace Cloudfiles API more efficiently.
 *
 * For installation and usage: https://bitbucket.org/modomg/codeigniter-rackspace-cloudfiles/
 *
 * @copyright	Copyright (c) 2011 Modo Media Group
 * @version 	1.0
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
 **/
class Cfiles {
    
    private $CI;                                   // CodeIgniter instance
	private $auth;                                 // Store authentication
	private $conn;                                 // Store connection

	// Cloud API parameters
	private $cf_username;                          // Cloud Username
	private $cf_api;                               // Cloud API Key
	
	// Main Variables
	var $cf_container;                             // Container to use
	var $cf_folder;                                // Folder to use
   
	function __construct($params = array())
	{
		$this->CI =& get_instance();
		$this->CI->load->config('cloudfiles.php');
		
		log_message('debug', 'RS Cloudfiles Class Initialized');

		$this->initialize($params);
	}
	
	// Initializes the library parameters
	public function initialize($params = array())
	{
		// Set API preferences from the config file if they are not passed in the $params array
		foreach (array('cf_username', 'cf_api') as $key)
		{
			$this->$key = (isset($params[$key])) ? $params[$key] : $this->CI->config->item($key);
		}
        
        require_once($this->CI->config->item('third_party_directory') . 'libraries/cloudfiles.php');
        
        //authenticate connection
		$this->auth = new CF_Authentication($this->cf_username, $this->cf_api);
		$this->auth->authenticate();
		
		//create the connection
		$this->conn = new CF_Connection($this->auth);
	}
	
	public function do_container($action='a')
	{
		if($action == 'a') //add
		{
			//Create a remote Container
			$new_container = $this->conn->create_container($this->cf_container);
            
            if($new_container->name)
            {
                //enable logs
    			$new_container->log_retention(TRUE);
    			
    			//publish and return URI
    			return $new_container->make_public();
            }
            else
            {
                return FALSE;                
            }
		}
		elseif($action == 'd') //delete
		{
			$my_container = $this->conn->get_container($this->cf_container);
			
			//get all objects
			$all_objects = $my_container->get_objects();
			foreach($all_objects as $object)
			{
				$object = str_replace($this->cf_container.'/', '', $object);
				
				//delete object
				$this->do_object('d', $object);
			}
			
			//delete container
			$this->conn->delete_container($this->cf_container);
		}
    }
	
	public function do_object($action='a', $file_name='', $file_location='', $original_file='')
	{
		$my_container = $this->conn->get_container($this->cf_container);
		
		if($action == 'a') //add
		{
			//move local file to server
			$my_object = $my_container->create_object($this->cf_folder.$file_name);
			$my_object->load_from_filename($file_location.$file_name);
            
            if($original_file != '')
            {
                $my_object->metadata = array("original" => $original_file);
                $my_object->sync_metadata();
            }
		}
		elseif($action == 'd') //delete
		{
			//delete file
			$my_container->delete_object($this->cf_folder.$file_name);
		}
    }
	
	public function container_info()
	{
		$my_container = $this->conn->get_container($this->cf_container);
		return $my_container;
	}
	
	public function get_objects()
	{
		$my_container = $this->conn->get_container($this->cf_container);
		return $my_container->get_objects(0, NULL, NULL, $this->cf_folder);
	}
	
	public function get_object($name)
	{
		$my_container = $this->conn->get_container($this->cf_container);
		return $my_container->get_object($name);
	}
    
    public function download_object($current_name, $new_name, $location)
    {
        $my_container = $this->conn->get_container($this->cf_container);
		$my_file = $my_container->get_object($current_name);
        $my_file->save_to_filename($location.$new_name);
    }
}

/* End of file cfiles.php */
/* Location: ./application/libraries/cfiles.php */