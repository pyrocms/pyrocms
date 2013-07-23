<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Frontend controller for files and stuffs
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Controllers
 */
class Files_front extends Public_Controller
{
	private	$_path = '';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->config->load('files');
		$this->load->library('files/files');

		$this->_path = FCPATH.rtrim($this->config->item('files:path'), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
	}
	
	/**
	 * Download a file
	 */
	public function download($id = 0)
	{
		$this->load->helper('download');

		$file = $this->file_m->select('files.*, file_folders.location')
			->join('file_folders', 'file_folders.id = files.folder_id')
			->get_by('files.id', $id) OR show_404();

		// increment the counter
		$this->file_m->update($id, array('download_count' => $file->download_count + 1));

		// if it's cloud hosted then we send them there
		if ($file->location !== 'local')
		{
			redirect($file->path);
		}

		// Read the file's contents
		$data = file_get_contents($this->_path . $file->filename);

		// if it's the default name it will contain the extension. Otherwise we need to add the extension
		$name = (strpos($file->name, $file->extension) !== false ? $file->name : $file->name . $file->extension);

		force_download($name , $data);
	}

	public function thumb($id = 0, $width = 100, $height = 100, $mode = null)
	{
		// is it a 15 char hash with no file extension or is it an old style numeric id with no file extension?
		if ((strlen($id) === 15 and strpos($id, '.') === false) or (is_numeric($id) and strpos($id, '.') === false))
		{
			$file = $this->file_m->get($id);
		}
		
		// it's neither a legacy numeric id nor a new hash id so they've passed the filename itself
		else
		{
			$data = getimagesize($this->_path.$id) OR show_404();
			
			$ext = '.'.end(explode('.', $id));
			
			$file->width 		= $data[0];
			$file->height 		= $data[1];
			$file->filename 	= $id;
			$file->extension 	= $ext;
			$file->mimetype 	= $data['mime'];
		}

		if ( ! $file)
		{
			set_status_header(404);
			exit;
		}

		$cache_dir = $this->config->item('cache_dir') . 'image_files/';

		is_dir($cache_dir) or mkdir($cache_dir, 0777, true);

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
					$height	= empty($width) ? null : $width;
				}
				else
				{
					$height	= null;
				}

				if ( ! empty($width))
				{
					if (($pos = strpos($width, 'x')) !== false)
					{
						if ($pos === 0)
						{
							$height = substr($width, 1);
							$width	= null;
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
					$height	= empty($width) ? null : $width;
				}

				foreach (array('height' => 'width', 'width' => 'height') as $var1 => $var2)
				{
					if (${$var1} === 0 or ${$var1} === '0')
					{
						${$var1} = null;
					}
					elseif (empty(${$var1}) or ${$var1} === 'auto')
					{
						${$var1} = (empty(${$var2}) OR ${$var2} === 'auto' OR ! is_null($mode)) ? null : 100000;
					}
				}
				break;
		}

		// Path to image thumbnail
		$thumb_filename = $cache_dir . ($mode ? $mode : 'normal');
		$thumb_filename .= '_' . ($width === null ? 'a' : ($width > $file->width ? 'b' : $width));
		$thumb_filename .= '_' . ($height === null ? 'a' : ($height > $file->height ? 'b' : $height));
		$thumb_filename .= '_' . md5($file->filename) . $file->extension;

		$expire = 60 * Settings::get('files_cache');
		if ($expire)
		{
			header("Pragma: public");
			header("Cache-Control: public");
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expire) . ' GMT');
		}

		$source_modified = filemtime($this->_path . $file->filename);
		$thumb_modified = filemtime($thumb_filename);

		if ( ! file_exists($thumb_filename) or ($thumb_modified < $source_modified))
		{
			if ($mode === $modes[1])
			{
				$crop_width		= $width;
				$crop_height	= $height;

				$ratio		= $file->width / $file->height;
				$crop_ratio	= (empty($crop_height) OR empty($crop_width)) ? 0 : $crop_width / $crop_height;
				
				if ($ratio >= $crop_ratio and $crop_height > 0)
				{
					$width	= $ratio * $crop_height;
					$height	= $crop_height;
				}
				else
				{
					$width	= $crop_width;
					$height	= $crop_width / $ratio;
				}

				$width	= ceil($width);
				$height	= ceil($height);
			}

			if ($height or $width)
			{
				// LOAD LIBRARY
				$this->load->library('image_lib');

				// CONFIGURE IMAGE LIBRARY
				$config['image_library']    = 'gd2';
				$config['source_image']     = $this->_path.$file->filename;
				$config['new_image']        = $thumb_filename;
				$config['maintain_ratio']   = is_null($mode);
				$config['height']           = $height;
				$config['width']            = $width;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				if ($mode === $modes[1] && ($crop_width !== null && $crop_height !== null))
				{
					$x_axis = floor(($width - $crop_width) / 2);
					$y_axis = floor(($height - $crop_height) / 2);

					// CONFIGURE IMAGE LIBRARY
					$config['image_library']    = 'gd2';
					$config['source_image']     = $thumb_filename;
					$config['new_image']        = $thumb_filename;
					$config['maintain_ratio']   = false;
					$config['width']			= $crop_width;
					$config['height']			= $crop_height;
					$config['x_axis']			= $x_axis;
					$config['y_axis']			= $y_axis;
					$this->image_lib->initialize($config);
					$this->image_lib->crop();
					$this->image_lib->clear();
				}
			}

			else
			{
				$thumb_modified = $source_modified;
				$thumb_filename = $this->_path.$file->filename;
			}
		}
		else if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
			(strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $thumb_modified) && $expire )
		{
			// Send 304 back to browser if file has not beeb changed
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $time).' GMT', true, 304);
			exit;
		}

		header('Content-type: ' . $file->mimetype);
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($thumb_filename)) . ' GMT');
		ob_end_clean();
		readfile($thumb_filename);
	}

	public function large($id)
	{
		return $this->thumb($id, null, null);
	}

	public function cloud_thumb($id = 0, $width = 75, $height = 50, $mode = 'fit')
	{
		$file = $this->file_m->select('files.*, file_folders.location')
			->join('file_folders', 'file_folders.id = files.folder_id')
			->get_by('files.id', $id);

		// it is a cloud file, we will return the thumbnail made when it was uploaded
		if ($file and $file->location !== 'local')
		{
			$thumb_filename = config_item('cache_dir').'/cloud_cache/'.$file->filename;

			if ( ! file_exists($thumb_filename))
			{
				$thumb_filename = APPPATH.'modules/files/img/no-image.jpg';
			}

			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
			(strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($thumb_filename)))
			{
				// Send 304 back to browser if file has not been changed
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($thumb_filename)).' GMT', true, 304);
				exit();
			}

			ob_end_clean();
			header('Content-type: ' . $file->mimetype);
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($thumb_filename)) . ' GMT');
			readfile($thumb_filename);
		}
		// it's a local file, output a thumbnail like we normally do
		elseif ($file)
		{
			return $this->thumb($id, $width, $height, $mode);
		}
	}
}

/* End of file files.php */
