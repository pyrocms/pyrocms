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
	public function download($id = 0)
	{
		$this->load->model('file_m');
		$this->load->helper('download');

		$file = $this->file_m->get($id) OR show_404();

		// Read the file's contents
		$data = file_get_contents('uploads/files/' . $file->filename);

		force_download($file->name . $file->extension , $data);
	}

	public function thumb($id, $width = 100, $height = 100)
	{
		$this->load->model('file_m');

		$file = $this->file_m->get($id) OR show_404();

		// Path to image thumbnail
		$image_thumb = APPPATH . 'cache/' . $height . '_' . $width . '_' . $file->filename;

		if( ! file_exists($image_thumb))
		{
			// LOAD LIBRARY
			$this->load->library('image_lib');

			// CONFIGURE IMAGE LIBRARY
			$config['image_library']    = 'gd2';
			$config['source_image']     = 'uploads/files/' . $file->filename;
			$config['new_image']        = $image_thumb;
			$config['maintain_ratio']   = TRUE;
			$config['height']           = $height;
			$config['width']            = $width;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();
		}

		header('Content-type: '.$file->mimetype);
		readfile($image_thumb);
	}

}
