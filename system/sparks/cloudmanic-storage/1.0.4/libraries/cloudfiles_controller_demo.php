<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed'); 
class Cloudfiles extends Controller{
	
	public function __construct()
	{
		parent::__construct();
        
        $this->load->library('cloudfiles/cfiles');
	}
	
	public function index()
	{
		die('Nothing here');
	}
	
	public function create_container()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
		$container_url = $this->cfiles->do_container('a');
        
        if($container_url)
        {
            die('Your new CDN URL is: '.$container_url);
        }
        else
        {
            die('Sorry, something went wrong!');
        }
	}
	
	public function add_local_file()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
        
		$file_location = '/assets/images/';
		$file_name = 'logo.jpg';
        
		$this->cfiles->do_object('a', $file_name, $file_location);
        
        die('Image Added!');
	}
	
	public function add_uploaded_file()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
        
		$file_location = '/assets/uploads/';
        
		$original_name = 'product_image.jpg';
		$file_name = '5a4794335cd2387a2280f1a1581ea45b.jpg';
        
		$this->cfiles->do_object('a', $file_name, $file_location, $original_name);
        
        /**
         * This is how it would look with the CI upload class
         * 
         * if($this->upload->do_upload('my_uploaded_file') === false)
         * {
         *      //do something with errors
         * }
         * else
         * {
         *      $data = $this->upload->data();
         *      
         *      $this->cfiles->do_object('a', $data['file_name'], $file_location, $data['orig_name']);
         * 
         *      //delete local file here
         * }
         */
        
        die('Image Added!');
	}
	
	public function add_local_file_folder()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
        $this->cfiles->cf_folder = 'images/';
        
		$file_location = '/assets/images/';
		$file_name = 'logo.jpg';
        
		$this->cfiles->do_object('a', $file_name, $file_location);
        
        die('Image Added!');
	}
	
	public function container_info()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
		$container_info = $this->cfiles->container_info();
    echo '<pre>' . print_r($container_info, TRUE) . '</pre>';    
        /**
         * [name]
         * [object_count]
         * [bytes_used]
         * [cdn_enabled]
         * [cdn_uri]
         * [cdn_ttl]
         * [cdn_log_retention]
         * [cdn_acl_user_agent] 
         * [cdn_acl_referrer] 
         */
	}
	
	public function container_objects()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
		$objects = $this->cfiles->get_objects();
        
        foreach($objects as $object)
        {
            //do something
            /**
             * [name]
             * [last_modified]
             * [content_type]
             * [content_length]
             * [metadata] => Array
             * (
             *      [Original]
             * )
             * 
             * metadata will only be available if you originally put it in
             */
        }
	}
	
	public function container_objects_folder()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
        $this->cfiles->cf_folder = 'images/';
		$objects = $this->cfiles->get_objects();
        
        foreach($objects as $object)
        {
            //do something
            /**
             * [name]
             * [last_modified]
             * [content_type]
             * [content_length]
             * [metadata] => Array
             * (
             *      [Original]
             * )
             * 
             * metadata will only be available if you originally put it in
             */
        }
        
        echo "<pre>";
        print_r($objects);
        echo "</pre>";
	}
	
	public function get_object()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
		$file_name = 'logo.jpg';
        
		$object = $this->cfiles->get_object($file_name);
        
        /**
         * [name]
         * [last_modified]
         * [content_type]
         * [content_length]
         * [metadata] => Array
         * (
         *      [Original]
         * )
         * 
         * metadata will only be available if you originally put it in
         */
	}
	
	public function download_object()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
		$cloud_file_name = 'logo.jpg';
		$local_file_name = 'downloaded_logo.jpg';
		$file_location = '/assets/images/';
        
		$this->cfiles->download_object($cloud_file_name, $local_file_name, $file_location);
        
        die('Image Saved!');
	}
	
	public function delete_file()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
		$file_name = 'logo.jpg';
        
		$this->cfiles->do_object('d', $file_name);
        
        die('Image Deleted!');
	}
	
	public function delete_file_folder()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
        $this->cfiles->cf_folder = 'images/';
        
		$file_name = 'logo.jpg';
        
		$this->cfiles->do_object('d', $file_name);
        
        die('Image Deleted!');
	}
	
	public function delete_container()
	{
		$this->cfiles->cf_container = 'rs_cloud_test';
		$this->cfiles->do_container('d');
        
        die('Container Deleted!');
	}
}

/* End of file cloudfiles.php */
/* Location: ./application/controllers/cloudfiles.php */