<?php defined('BASEPATH') OR exit('No direct script access allowed');

function check_installed()
{
	// No database file? AAAGHHHH!
	if ( ! file_exists(APPPATH.'config/database'.EXT))
	{
		header('Location: '. BASE_URL.'installer/');
		exit;
	}
}