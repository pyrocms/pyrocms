<?php defined('BASEPATH') OR exit('No direct script access allowed');

//
// Company: Cloudmanic Labs, http://cloudmanic.com
// By: Spicer Matthews, spicer@cloudmanic.com
// Date: 9/17/2011
// Description: Driver class for Amazon S3
//

class Amazon_S3_Driver extends Storage
{	
	//
	// Constructor …
	//
	function __construct()
	{
		parent::__construct();
		
		// Make sure we have amazon keys.
		if(empty($this->_config['s3_access_key']) || empty($this->_config['s3_secret_key']))
		{
			show_error('Storage: In order to load the Amazon S3 Driver you must have an access and secret key set.');	
		}
		
		// Load libraries
		$this->_CI->load->library('s3');
		$this->_CI->s3->start($this->_config['s3_access_key'], $this->_config['s3_secret_key'], true);

		// S3 made no good way to change this properly so here ya go...
		S3::$host = preg_replace('@http(.*?)\/\/@', '', rtrim(Settings::get('files_s3_url'), '/'));
		S3::$geographic_location = (Settings::get('files_s3_geographic_location') === 'EU') ? 'EU' : false;
	}

	//
	// Create a new bucket at S3.
	//
	function create_container($cont, $acl = 'private')
	{
		switch(strtolower($acl))
		{	
			case 'private':
				return $this->_CI->s3->putBucket($cont, S3::ACL_PRIVATE);
			break;
			
			case 'public':
				return $this->_CI->s3->putBucket($cont, S3::ACL_PUBLIC_READ);
			break;
		}
	}

	//
	// Get information about a bucket
	// The Rackspace version of this actually does something useful :P
	//
	function get_container($cont)
	{
		$objects = $this->_CI->s3->getBucket($cont);

		return array(
			'name' 					=> $cont,
			'object_count'			=> count($objects),
			'cdn_enabled'			=> '',
			'cdn_uri'				=> '',
			'cdn_ttl'				=> '',
			'cdn_log_retention'		=> '',
			'cdn_acl_user_agent'	=> '',
			'cdn_acl_referrer'		=> ''
		);
	}

	//
	// Delete a S3 bucket.
	//
	function delete_container($cont)
	{
		return $this->_CI->s3->deleteBucket($cont);	
	}

	//
	// Return a list of buckets (ie. containers. 
	//
	function list_containers()
	{
		return $this->_CI->s3->listBuckets();
	}
	
	//
	// List all files in a bucket
	//
	function list_files($cont)
	{
		$data = array();
		$d = $this->_CI->s3->getBucket($cont);
		
		foreach($d AS $key => $row)
		{
			$row['http'] = '';
			$row['https'] = '';
			$data[] = $row;
		}
		
		return $data;
	}
	
	//
	// Upload a file to a bucket.
	//
	function upload_file($cont, $path, $name, $type = NULL, $acl = 'private', $metadata = array())
	{
		$input = array('file' => $path);
		
		// Set type.
		if(! is_null($type))
		{
			$input['type'] = $type;
		}
		
		// Remap ACL name;
		if($acl == 'public')
		{
			$acl = 'public-read';
		}
	
		$this->_CI->s3->putObject($input, $cont, $name, $acl, array(), $metadata);
	}
	
	//
	// Delete file from a bucket. (s3 object)
	//
	function delete_file($container, $file)
	{
		$this->_CI->s3->deleteObject($container, $file);
	}
	
	//
	// Get private url to a file. This is a url with a session hash.
	// The URL expires after a short period of time.
	//
	function get_authenticated_url($cont, $file, $seconds)
	{
		return $this->_CI->s3->getAuthenticatedURL($cont, $file, $seconds, false, true);
	}
}


/* End File */