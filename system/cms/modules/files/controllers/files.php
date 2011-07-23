<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Files
 * @author			Phil Sturgeon
 *
 * Frontend controller for files and stuffs
 */
class Files extends Public_Controller
{
	private	$path = '';
	
	public function __construct()
	{	
		parent::Public_Controller();
		
		$this->config->load('files');
		$this->_path = FCPATH . $this->config->item('files_folder') . DIRECTORY_SEPARATOR;
	}
	
	public function download($id = 0)
	{
		$this->load->model('file_m');
		$this->load->helper('download');

		$file = $this->file_m->get($id) OR show_404();

		// Read the file's contents
		$data = file_get_contents($this->_path . $file->filename);

		force_download($file->name . $file->extension , $data);
	}

	public function thumb($id, $width = 100, $height = 100)
	{
		$this->load->model('file_m');

		$file = $this->file_m->get($id) OR show_404();
		$cache_dir = $this->config->item('cache_dir') . 'image_files/';

		if ( ! is_dir($cache_dir))
		{
			mkdir($cache_dir, 0777, TRUE);
		}

		$args = func_num_args();

		switch ($args)
		{
			case 2:
				$height	= NULL;
				if ( ! empty($width))
				{
					if (($pos = strpos($width, 'x')) !== FALSE)
					{
						if ($pos === 0)
						{
							$height = substr($width, 1);
							$width	= NULL;
						}
						else
						{
							list($width, $height) = explode('x', $width);
						}
					}
				}
			case 2:
			case 3:
				foreach (array('height' => 'width', 'width' => 'height') as $var1 => $var2)
				{
					if (${$var1} === 0 OR ${$var1} === '0')
					{
						${$var1} = NULL;
					}
					elseif (empty(${$var1}))
					{
						${$var1} = empty(${$var2}) ? NULL : 100000;
					}
				}
				break;
		}

		// Path to image thumbnail
		$image_thumb = $cache_dir . $width . '_' . $height . '_' . md5($file->filename) . $file->extension;

		if ( ! file_exists($image_thumb))
		{
			// LOAD LIBRARY
			$this->load->library('image_lib');

			// CONFIGURE IMAGE LIBRARY
			$config['image_library']    = 'gd2';
			$config['source_image']     = $this->_path . $file->filename;
			$config['new_image']        = $image_thumb;
			$config['maintain_ratio']   = TRUE;
			$config['height']           = $height;
			$config['width']            = $width;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();
		}

		header('Content-type: ' . $file->mimetype);
		readfile($image_thumb);
	}

	public function large($id)
	{
		return $this->thumb($id, NULL, NULL);
	}
}
