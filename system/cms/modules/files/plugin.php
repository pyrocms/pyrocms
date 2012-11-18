<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Files Plugin
 *
 * Create a list of files
 *
 * @author		Marcos Coelho
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Plugins
 */
class Plugin_Files extends Plugin
{
	private $_files = array();

	public function __construct()
	{
		$this->load->model(array(
			'file_m',
			'file_folders_m'
		));
	}

	/**
	 * Files listing
	 *
	 * Creates a list of files
	 *
	 * Usage:
	 *
	 * {{ files:listing folder="home-slider" type="i" fetch="subfolder|root" }}
	 * 	// your html logic
	 * {{ /files:listing }}
	 *
	 * 
	 * Alternate Usage:
	 * 
	 * {{ files:listing folder="home-slider" tagged="sunset|hiking|mountain" }}
	 * 	// your html logic
	 * {{ /files:listing }}
	 *
	 * The tags that are available to use from this method are listed below
	 *
	 * {{ id }}
	 * {{ folder_id }}
	 * {{ user_id }}
	 * {{ type }}
	 * {{ name }}
	 * {{ filename }}
	 * {{ description }}
	 * {{ extension }}
	 * {{ mimetype }}
	 * {{ width }}
	 * {{ height }}
	 * {{ filesize }}
	 * {{ date_added }}
	 *
	 * @return	array
	 */
	public function listing()
	{
		if ( ! $this->content())
		{
			return '';
		}

		$folder_id	= $this->attribute('folder', ''); // Id or Path
		$tags		= $this->attribute('tagged', false);
		$limit		= $this->attribute('limit', '10');
		$offset		= $this->attribute('offset', '');
		$type		= $this->attribute('type', '');
		$fetch		= $this->attribute('fetch');
        $order_by   = $this->attribute('order-by');

		if ( ! empty($folder_id) && (empty($type) || in_array($type, array('a','v','d','i','o'))))
		{
			if (is_numeric($folder_id))
			{
				$folder = $this->file_folders_m->get($folder_id);
			}
			elseif (is_string($folder_id))
			{
				$folder = $this->file_folders_m->get_by_path($folder_id);
			}
		}

		if (isset($folder) and $folder)
		{
			// we're getting the files for an entire tree
			if (in_array($fetch, array('root', 'subfolder')))
			{
				$fetch_id = ($fetch === 'root' ? $folder->root_id : $folder->id);

				$subfolders = $this->file_folders_m->folder_tree($fetch_id);

				if ($subfolders)
				{
					$ids = array_merge(array((int) $folder->id), array_keys($subfolders));
					$this->db->select('files.*, files.id as file_id, file_folders.location')
						->join('file_folders', 'file_folders.id = files.folder_id')
						->where_in('folder_id', $ids);
				}
			}
			// just the files for one folder
			else
			{
				$this->db->select('files.*, files.id as file_id, file_folders.location')
					->join('file_folders', 'file_folders.id = files.folder_id')
					->where('folder_id', $folder->id);
			}
		}
		// no restrictions by folder so we'll just be getting files by their tags. Set up the join
		elseif ( ! isset($folder))
		{
			$this->db->select('files.*, files.id as file_id, file_folders.location')
				->join('file_folders', 'file_folders.id = files.folder_id');
		}
		else
		{
			return array();
		}

		$type 		and $this->db->where('type', $type);
		$limit 		and $this->db->limit($limit);
		$offset 	and $this->db->offset($offset);
        $order_by 	and $this->db->order_by($order_by);

        if ($tags)
        {
			$files = $this->file_m->get_tagged($tags);
        }
        else
        {
			$files = $this->file_m->get_all();
		}

		$files and array_merge($this->_files, (array) $files);

		return $files;
	}

	public function file($return = '', $type = '')
	{
		// nothing to do
		if ($return && ! in_array($return, array('url', 'path')))
		{
			return '';
		}

		// prepare file params
		$id		= $this->attribute('id');
		$type	= $type && in_array($type, array('a','v','d','i','o')) ? $type : '';

		// get file
		if (isset($this->_files[$id]))
		{
			$file = $this->_files[$id];
		}
		else
		{
			$type AND $this->file_m->select('files.*, file_folders.location')
						->join('file_folders', 'file_folders.id = files.folder_id')
						->where('type', $type);

			$file = $this->file_m->get_by('files.id', $id);
		}

		// file not found
		if ( ! $file or ($type && $file->type !== $type))
		{
			return '';
		}
		// return file fields array
		elseif ( ! $return && $this->content())
		{
			return (array) $file;
		}

		// make uri
		if ($type === 'i')
		{
			if ($size = $this->attribute('size', ''))
			{
				strpos($size, 'x') === false AND $size .= 'x';

				list($width, $height) = explode('/', strtr($size, 'x', '/'));
			}
			else
			{
				$width	= $this->attribute('width', '');
				$height	= $this->attribute('height', '');
			}

			is_numeric($width) OR $width = 'auto';
			is_numeric($height) OR $height = 'auto';

			if ($width === 'auto' && $height === 'auto')
			{
				$dimension = '';
			}
			else
			{
				$mode = $this->attribute('mode', '');
				$mode = in_array($mode, array('fill', 'fit')) ? $mode : '';

				$dimension = trim($width . '/' . $height . '/' . $mode, '/');
			}

			if ($file->location === 'local' and $dimension)
			{
				$uri = sprintf('files/thumb/%s/%s', $file->filename, $dimension);
			}
			// we can't just return the path on this because they may not want an absolute url
			elseif ($file->location === 'local')
			{
				$uri = 'files/large/' . $file->filename;
			}
			else
			{
				$uri = $file->path;
			}
		}
		else
		{
			$uri = ($file->location === 'local') ? 'files/download/' . $file->id : $file->path;
		}

		// return string
		if ($return)
		{
			// if it isn't local then they are getting a url regardless what they ask for
			if ($file->location !== 'local')
			{
				return $file->path;
			}

			return ($return === 'url') ? site_url($uri) : BASE_URI . $uri;
		}

		$attributes	= $this->attributes();

		foreach (array('base', 'size', 'id', 'title', 'type', 'mode', 'width', 'height') as $key)
		{
			if (isset($attributes[$key]) && ($type !== 'i' or ! in_array($key, array('width', 'height'))))
			{
				unset($attributes[$key]);
			}

			if (isset($attributes['tag-' . $key]))
			{
				$attributes[$key] = $attributes['tag-' . $key];

				unset($attributes['tag-' . $key]);
			}
		}

		$base = $this->attribute('base', 'url');
		
		// alt tag is named differently in db to prevent confusion with "alternative", so need to do check for it manually
		$attributes['alt'] = isset($attributes['alt']) ? $attributes['alt'] : $file->alt_attribute;
		
		// return an image tag html
		if ($type === 'i')
		{
			$this->load->helper('html');

			if (strpos($size, 'x') !== false && ! isset($attributes['width'], $attributes['height']))
			{
				list($attributes['width'], $attributes['height']) = explode('x', $size);
			}

			return $this->{'_build_tag_location_' . $base}($type, $uri, array(
				'attributes' => $attributes,
				'index_page' => true
			));
		}

		// return an file anchor tag html
		$title = $this->attribute('title');

		return $this->{'_build_tag_location_' . $base}($type, $uri, compact('title', 'attributes'));
	}

	public function image()
	{
		return $this->file('', 'i');
	}

	public function image_url()
	{
		return $this->file_url('i');
	}

	public function image_path()
	{
		return $this->file_path('i');
	}

	public function file_url($type = '')
	{
		return $this->file('url', $type);
	}

	public function file_path($type = '')
	{
		return $this->file('path', $type);
	}

	public function exists()
	{
		$id = $this->attribute('id');

		$exists = (bool) (isset($this->_files[$id]) ? true : $this->file_m->exists($id));

		return $exists && $this->content() ? $this->content() : $exists;
	}
	
	public function folder_exists()
	{
		return $this->file_folders_m->exists($this->attribute('slug'));
	}

	private function _build_tag_location_url($type = '', $uri = '', $extras = array())
	{
		extract($extras);

		if ($type === 'i')
		{
			$attributes['src'] = $uri;

			return img($attributes, $index_page);
		}

		return anchor($uri, $title, $attributes);
	}

	private function _build_tag_location_path($type = '', $uri = '', $extras = array())
	{
		extract($extras);

		// unset config base_url
		$base_url = $this->config->item('base_url');
		$this->config->set_item('base_url', '');

		// generate tag
		if ($type === 'i')
		{
			$attributes['src'] = $uri;

			$tag = img($attributes, $index_page);
		}
		else
		{
			$tag = anchor($uri, $title, $attributes);
		}

		// set config base_url
		$base_url = $this->config->set_item('base_url', $base_url);

		return $tag;
	}
}

/* End of file plugin.php */
