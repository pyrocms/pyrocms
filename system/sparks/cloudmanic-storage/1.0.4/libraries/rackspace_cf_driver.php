<?php defined('BASEPATH') OR exit('No direct script access allowed');

//
// Company: Cloudmanic Labs, http://cloudmanic.com
// By: Spicer Matthews, spicer@cloudmanic.com
// Date: 9/17/2011
// Description: Driver class for Rackspace Cloud Files
//

class Rackspace_Cf_Driver extends Storage
{	
	private $_auth;
	private $_conn;
	
	//
	// Constructor …
	//
	function __construct()
	{
		parent::__construct();
		
		// Make sure we have amazon keys.
		if(empty($this->_config['cf_username']) || empty($this->_config['cf_api_key']))
		{
			show_error('Storage: In order to load the Rackspace CF Driver you must have an username and api key set.');	
		}
		
		// Load libraries & Connection
		$this->_CI->load->library('CF_Authentication');
		$this->_auth = new CF_Authentication($this->_config['cf_username'], $this->_config['cf_api_key']);
		$this->_auth->authenticate();
		$this->_conn = new CF_Connection($this->_auth);
	}
	
	//
	// Create a new container at Rackspace.
	//
	function create_container($cont, $acl = 'private')
	{	
		switch(strtolower($acl))
		{	
			case 'private':
				$this->_conn->create_container($cont);
			break;
			
			case 'public':
				$public_container = $this->_conn->create_container($cont);
				return $public_container->make_public(86400 / 2); // 12 hours (86400 seconds/day)
			break;
		}
	}

	//
	// Get the info for a container
	//
	function get_container($cont)
	{
		$my_container = $this->_conn->get_container($cont);

		return array(
			'name' 					=> $my_container->name,
			'object_count'			=> $my_container->object_count,
			'cdn_enabled'			=> $my_container->cdn_enabled,
			'cdn_uri'				=> $my_container->cdn_uri,
			'cdn_ttl'				=> $my_container->cdn_ttl,
			'cdn_log_retention'		=> $my_container->cdn_log_retention,
			'cdn_acl_user_agent'	=> $my_container->cdn_acl_user_agent,
			'cdn_acl_referrer'		=> $my_container->cdn_acl_referrer
		);
	}
	
	//
	// Delete a container.
	//
	function delete_container($cont)
	{
		return $this->_conn->delete_container($cont);	
	}
	
	//
	// List all containers.
	//
	function list_containers()
	{
		return $this->_conn->list_containers();
	}

	//
	// Upload file to a container. At this point $acl and $metadata does not do anything.
	//
	function upload_file($cont, $path, $name, $type = NULL, $acl = 'private', $metadata = array())
	{
		$my_container = $this->_conn->get_container($cont);

		// move local file to server		
		$my_object = $my_container->create_object($name);
		
		// If we pass in a type we don't try to guess the type.
		if(! is_null($type))
		{
			$my_object->content_type = $type;
		}
		
		$my_object->load_from_filename($path);

		return ($my_object->container->cdn_enabled) ? $my_object->container->cdn_uri . '/' . $my_object->name : $my_object->name;
	}
	
	//
	// Delete a file from a container...
	//
	function delete_file($container, $file_name)
	{
		$my_container = $this->_conn->get_container($container);
		$my_container->delete_object($file_name);
	}
	
	//
	// List all files.
	//
	function list_files($cont)
	{
		$data = array();
		$my_container = $this->_conn->get_container($cont);
		$objs = $my_container->get_objects();
		foreach($objs AS $key => $row)
		{
			$tmp['name'] = $row->name;
			$tmp['time'] = strtotime($row->last_modified);
			$tmp['size'] = $row->content_length;
			$tmp['hash'] = $row->getETag();
			$tmp['http'] = ''; 
			$tmp['https'] = '';
			$data[] = $tmp; 
		}
		
		return $data;
	}
	
	//
	// Rackspace does not support this feature. So we allow
	// you to set a custom library / method to call to build 
	// your own custom url. You set this in the storage.php 
	// config file.  Often times you wil create your own custom 
	// controller that has some sort of authentication in front 
	// of it. This function calls your custom library your 
	// custom code should return a url. Returns blank if you
	// do not have a custom library / method set.
	//
	function get_authenticated_url($cont, $file, $seconds)
	{
		if((! empty($this->_config['cf_auth_url']['library'])) &&
				(! empty($this->_config['cf_auth_url']['method'])))
		{
			$lib = $this->_config['cf_auth_url']['library'];
			$meth = $this->_config['cf_auth_url']['method'];
			$this->_CI->load->library($lib);
			return $this->_CI->{$lib}->{$meth}($cont, $file, $seconds);
		}
	
		return '';
	}
}

/* End File */