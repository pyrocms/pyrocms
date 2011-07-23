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

	public function thumb($id, $width = 100, $height = 100, $mode = NULL)
	{
		$this->load->model('file_m');

		$file = $this->file_m->get($id) OR show_404();
		$cache_dir = $this->config->item('cache_dir') . 'image_files/';

		if ( ! is_dir($cache_dir))
		{
			mkdir($cache_dir, 0777, TRUE);
		}

		$modes = array('fill', 'fit');

		$args = func_num_args();
		$args = $args > 3 ? 3 : $args;
		$args = $args === 3 && in_array($height, $modes) ? 2 : $args;

		switch ($args)
		{
			case 2:
				if (in_array($width, $modes))
				{
					$mode	= $width;
					$width	= $height; // 100

					continue;
				}
				elseif (in_array($height, $modes))
				{
					$mode	= $height;
					$height	= empty($width) ? NULL : $width;
				}
				else
				{
					$height	= NULL;
				}

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
				if (in_array($height, $modes))
				{
					$mode	= $height;
					$height	= empty($width) ? NULL : $width;
				}

				foreach (array('height' => 'width', 'width' => 'height') as $var1 => $var2)
				{
					if (${$var1} === 0 OR ${$var1} === '0')
					{
						${$var1} = NULL;
					}
					elseif (empty(${$var1}) OR ${$var1} === 'auto')
					{
						${$var1} = (empty(${$var2}) OR ${$var2} === 'auto' OR ! is_null($mode)) ? NULL : 100000;
					}
				}
				break;
		}

		// Path to image thumbnail
		$image_thumb = $cache_dir . ($mode ? $mode : 'normal');
		$image_thumb .= '_' . ($width === NULL ? 'a' : ($width > $file->width ? 'b' : $width));
		$image_thumb .= '_' . ($height === NULL ? 'a' : ($height > $file->height ? 'b' : $height));
		$image_thumb .= '_' . md5($file->filename) . $file->extension;

		if ( ! file_exists($image_thumb) OR (filemtime($image_thumb) < filemtime($this->_path . $file->filename)))
		{
			if ($mode === $modes[1])
			{
				$ratio = $file->width / $file->height;

				$crop_width	 = $width;
				$crop_height = $height;

				if ($crop_width > $crop_height)
				{
					$width	= $crop_width;
					$height	= $crop_width / $ratio;
				}
				else
				{
					$width	= $crop_height * $ratio;
					$height	= $crop_height;
				}

				$width	= ceil($width);
				$height	= ceil($height);
			}

			// LOAD LIBRARY
			$this->load->library('image_lib');

			// CONFIGURE IMAGE LIBRARY
			$config['image_library']    = 'gd2';
			$config['source_image']     = $this->_path . $file->filename;
			$config['new_image']        = $image_thumb;
			$config['maintain_ratio']   = is_null($mode);;
			$config['height']           = $height;
			$config['width']            = $width;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();

			if ($mode === $modes[1] && ($crop_width !== NULL && $crop_height !== NULL))
			{
				$x_axis = floor(($width - $crop_width) / 2);
				$y_axis = floor(($height - $crop_height) / 2);

				// CONFIGURE IMAGE LIBRARY
				$config['image_library']    = 'gd2';
				$config['source_image']     = $image_thumb;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = FALSE;
				$config['width']			= $crop_width;
				$config['height']			= $crop_height;
				$config['x_axis']			= $x_axis;
				$config['y_axis']			= $y_axis;
				$this->image_lib->initialize($config);
				$this->image_lib->crop();
				$this->image_lib->clear();
			}
		}

		header('Content-type: ' . $file->mimetype);
		readfile($image_thumb);
	}

	public function large($id)
	{
		return $this->thumb($id, NULL, NULL);
	}
}

/* End of file files.php */
/* Location: ./system/pyrocms/modules/files/controllers/files.php */