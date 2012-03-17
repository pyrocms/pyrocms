<?php defined('BASEPATH') OR exit('No direct script access allowed');

//
// Company: Cloudmanic Labs, http://cloudmanic.com
// By: Spicer Matthews, spicer@cloudmanic.com
// Date: 9/17/2011
// Description: An abstract class for interfacing with different
//							cloudstorage solutions. 
//

class Storage 
{
	protected $_CI;
	protected $_driver = FALSE;
	protected $_config = array();
	
	//
	// Constructor …
	//
	function __construct()
	{
		$this->_CI =& get_instance();
		$this->_config = $this->_CI->config->item('storage');
	}
	
	//
	// Set wich driver we are going to use for this
	// instance of the Storage class.
	//
	function load_driver($driver)
	{
		switch(strtolower($driver))
		{
			case 'amazon-s3': 
				$this->_CI->load->library('amazon_s3_driver');
				$this->_driver = 'amazon_s3_driver';
				log_message('debug', 'Amazon S3 Class Initialized');
			break;
			
			case 'rackspace-cf':
				$this->_CI->load->library('rackspace_cf_driver');
				$this->_driver = 'rackspace_cf_driver';
				log_message('debug', 'Racespace Cloudfiles Class Initialized');
			break;
		}
		
		return 0;
	}
	
	//
	// Create a container.
	//
	function create_container($cont, $acl = 'private')
	{
		return $this->_CI->{$this->_driver}->create_container($cont, $acl);	
	}

	//
	// Delete a container.
	//
	function delete_container($cont)
	{
		return $this->_CI->{$this->_driver}->delete_container($cont);	
	}

	//
	// Get a container
	//
	function get_container($cont)
	{
		return $this->_CI->{$this->_driver}->get_container($cont);
	}
	
	//
	// List all containers.
	//
	function list_containers()
	{
		return $this->_CI->{$this->_driver}->list_containers();
	}
	
	//
	// List all files.
	//
	function list_files($cont)
	{
		return $this->_CI->{$this->_driver}->list_files($cont);
	}
	
	//
	// Upload file.
	//
	function upload_file($cont, $path, $name, $type = NULL, $acl = 'private', $metadata = array())
	{
		return $this->_CI->{$this->_driver}->upload_file($cont, $path, $name, $type, $acl, $metadata);
	}
	
	//
	// Delete file.
	//
	function delete_file($container, $file)
	{
		return $this->_CI->{$this->_driver}->delete_file($container, $file);		
	}
	
	//
	// Get private url to a file. This is a url with a session hash.
	// The URL expires after a short period of time.
	//
	function get_authenticated_url($cont, $file, $seconds)
	{
		return $this->_CI->{$this->_driver}->get_authenticated_url($cont, $file, $seconds);
	}
}

/* End File */