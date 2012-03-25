<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); 

require_once(APPPATH . 'libraries/cloudfiles/cloudfiles.php');

//
// Cloudmanic Labs Wrapper for Rackspace Cloudfiles API.
// 
class Rscfiles
{
	private $_CI;
	private $conn;
	
	//
	// Constructor ....
	//
	function __construct()
	{
		$this->_CI =& get_instance();
		$this->_CI->load->config('cloudfiles.php');
		
		log_message('debug', 'RS Cloudfiles Class Initialized');

		//authenticate connection
		$this->auth = new CF_Authentication($this->_CI->config->item('cf_username'), $this->_CI->config->item('cf_api'));
		$this->auth->authenticate();
		
		//create the connection
		$this->conn = new CF_Connection($this->auth);
	}

	//
	// Upload a file to a container....
	//
	function upload_file($container, $file, $file_name, $dbid = '')
	{
		$my_container = $this->conn->get_container($container);

		// move local file to server
		$my_object = $my_container->create_object($file_name);
		$my_object->load_from_filename($file);
    
    // Pass in the table row id of the file.        
		if(! empty($dbid))
		{
			$my_object->metadata = array("FilesId" => $dbid);
			$my_object->sync_metadata();
		}
	}
	
	//
	// Delete a file from a container...
	//
	function delete_file($container, $file_name)
	{
		$my_container = $this->conn->get_container($container);
		$my_container->delete_object($file_name);
	}
}

/* End Files */