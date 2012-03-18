<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//
// Company: Cloudmanic Labs, http://cloudmanic.com
// By: Spicer Matthews, spicer@cloudmanic.com
// Date: 9/17/2011
// Description: Example controller using the different cloud storage services. 
//

class Example extends CI_Controller 
{
	//
	// Test out using Rackspace cloud files.
	//
	function Rackspace()
	{
		$this->load->spark('cloudmanic-storage/1.0.1');
		$this->storage->load_driver('rackspace-cf');
		$this->_test();		
	}

	//
	// Test out using Amazon's s3.
	//
	function Amazon()
	{
		$this->load->spark('cloudmanic-storage/1.0.0');
		$this->storage->load_driver('amazon-s3');
		$this->_test();
	}
	
	//
	// Run through the different methods of the storage library.
	//
	private function _test()
	{
		// Create a test container. 
		$container = 'cm-storage-' . time();
		echo '<h1>Create test container.</h1>';
		$this->storage->create_container($container, 'private');
		echo "New container: <b>$container</b><br /><br />";
		echo '<hr />';

		// List all containers.
		echo '<h1>Listing all containers.</h1>';
		$list = $this->storage->list_containers();
		echo '<pre>' . print_r($list, TRUE) . '</pre>';
		echo '<br /><hr />';

		// Upload a test file to the new container.
		echo "<h1>Uploading file to $container container and getting authenticated URL.</h1>";
		$file = file_get_contents('http://graphics8.nytimes.com/images/2011/09/18/us/18reno-span/18reno-span-articleLarge.jpg');
		file_put_contents('/tmp/test01.jpg', $file);
		$this->storage->upload_file($container, '/tmp/test01.jpg', 'test01.jpg');
		unlink('/tmp/test01.jpg');
		
		$url = $this->storage->get_authenticated_url($container, 'test01.jpg', 60);
		echo $url . '<br /><br /><b>(URL will not work because you are deleting the file below)</b><br /><br />';
		echo '<br /><hr />';
	
		// List all files in container.
		echo "<h1>Listing all files in the $container container.</h1>";
		$files = $this->storage->list_files($container);
		echo '<pre>' . print_r($files, TRUE) . '</pre>';
		echo '<br /><hr />';

		// Delete the file we just uploaded
		echo "<h1>Deleting test file.</h1>";
		$files = $this->storage->delete_file($container, 'test01.jpg');
		echo "Deleted file: <b>test01.jpg</b><br />";
		echo '<br /><hr />';
	
		// List all files in a container.
		echo "<h1>Listing all files in the $container container.</h1>";
		$files = $this->storage->list_files($container);
		echo '<pre>' . print_r($files, TRUE) . '</pre>';
		echo '<br /><hr />';
		
		// Delete Container
		echo '<h1>Delete test container.</h1>';
		$this->storage->delete_container($container);
		echo "Deleted container: <b>$container</b><br />";
		echo '<br /><hr />';
		
		// List all containers.
		echo '<h1>Listing all containers.</h1>';
		$list = $this->storage->list_containers();
		echo '<pre>' . print_r($list, TRUE) . '</pre>';
		echo '<br /><hr />';
	}
}

/* End File */