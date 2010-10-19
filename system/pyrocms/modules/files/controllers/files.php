<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		libraries
 * @author			Phil Sturgeon
 *
 * Frontend controller for files and stuffs
 */
class Files extends Public_Controller
{
	function download($id = 0)
	{
		// Do they have this feature?
//		$this->features->libraries OR show_404();

		$this->load->model('file_m');
		$this->load->helper('download');

		$file = $this->file_m->get($id) OR show_404();

		// Read the file's contents
		$data = file_get_contents('uploads/files/' . $file->filename);

		force_download($file->name . '.' . $file->extension , $data);
	}
}
