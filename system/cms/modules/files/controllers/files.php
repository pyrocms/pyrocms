<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Files
 * @author			Phil Sturgeon
 * @modified		Edi Mange
 *
 * Frontend controller for files and stuffs
 */
class Files extends Public_Controller
{
	private	$path = '';
	
	public function __construct()
	{	
		parent::__construct();
		
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
		$color = ($file->i_color === NULL ? NULL : '#'.$file->i_color);
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
		$image_thumb .= '_' . $color;
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

			// LOAD Image_Moo LIBRARY. Created by Matthew at http://www.matmoo.com/digital-dribble/codeigniter/image_moo/
			$this->load->library('image_moo');
			//If color is null, crop without padding.
			if ($color == NULL && $width != NULL && $height != NULL){
				$this->image_moo
					->load($this->_path . $file->filename)
					->resize($width, $height, FALSE)
					->save($image_thumb, TRUE);
			}
			//If not the full sized imaage
			else if($width != NULL && $height != NULL){
			// CONFIGURE IMAGE LIBRARY
			$this->image_moo
					->load($this->_path . $file->filename)
					->set_background_colour($color)
					->resize($width, $height, TRUE)
					->save($image_thumb, TRUE);
			}
			else{
			//If it is the full sized image, grab the original and save in cache with nothing but a file rename.
			//Fixes imaage load issues.
			$this->image_moo
					->load($this->_path . $file->filename)
					->save($image_thumb, TRUE);	
			}

			if ($mode === $modes[1] && ($crop_width !== NULL && $crop_height !== NULL))
			{
				// CONFIGURE IMAGE LIBRARY
				$this->image_moo
					->load($image_thumb)
					->resize_crop($crop_width, $crop_height)
					->save($image_thumb, TRUE);
			}
		}
		else if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
			(strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($image_thumb)) &&
				$expire )
		{
			// Send 304 back to browser if file has not beeb changed
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($image_thumb)).' GMT', true, 304);
			exit();
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