<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Files Plugin
 *
 * Create a list of files
 *
 * @package		PyroCMS
 * @author		Marcos Coelho - PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
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
	 * {pyro:files:listing folder="home-slider" type="i"}
	 * 	// your html logic
	 * {/pyro:files:listing}
	 *
	 * The tags that are available to use from this method are listed below
	 *
	 * {id}
	 * {folder_id}
	 * {user_id}
	 * {type}
	 * {name}
	 * {filename}
	 * {description}
	 * {extension}
	 * {mimetype}
	 * {width}
	 * {height}
	 * {filesize}
	 * {date_added}
	 *
	 * @return	array
	 */
	function listing()
	{
		if ( ! $this->content())
		{
			return '';
		}

		$folder_identity	= $this->attribute('folder', ''); // Id or Path
		$limit				= $this->attribute('limit', '10');
		$offset				= $this->attribute('offset', '');
		$type				= $this->attribute('type', '');

		if ( ! empty($folder_identity) && (empty($type) || in_array($type, array('a','v','d','i','o'))))
		{
			if (is_numeric($folder_identity))
			{
				$folder = $this->file_folders_m->get($folder_identity);
			}
			elseif (is_string($folder_identity))
			{
				$folder = $this->file_folders_m->get_by_path($folder_identity);
			}
		}

		if (empty($folder))
		{
			return array();
		}

		$this->file_m->where('folder_id', $folder->id);

		$type AND $this->file_m->where('type', $type);
		$limit AND $this->file_m->limit($limit);
		$offset AND $this->file_m->limit($offset);

		$files = $this->file_m->get_all();
		$files AND array_merge($this->_files, assoc_array_prop($files));

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
		$type	= $type ? $type : $this->attribute('type');
		$type	= in_array($type, array('a','v','d','i','o')) ? $type : '';

		// get file
		if (isset($this->_files[$id]))
		{
			$file = $this->_files[$id];
		}
		else
		{
			$type AND $this->file_m->where('type', $type);

			$file = $this->file_m->get($id);
		}

		// file not found
		if ( ! $file OR ($type && $file->type !== $type))
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
			// size="100x75"
			if ( ! $size = strtr($this->attribute('size', ''), 'x', '/'))
			{
				// width="100" height="75"
				$size = implode('/', array_filter(array(
					$this->attribute('width',	''),
					$this->attribute('height',	'')
				)));
			}

			$uri = $size
				? 'files/thumb/' .  $file->id . '/' . $size
				: UPLOAD_PATH.'files/' . $file->filename;
		}
		else
		{
			$uri = UPLOAD_PATH.'files/' . $file->filename;
		}

		// return string
		if ($return)
		{
			return ($return == 'url' ? rtrim(site_url(), '/') . '/' : BASE_URI) . $uri;
		}

		$base = $this->attribute('base', 'url');

		// nothing to do
		if ($return && ! in_array($base, array('url', 'path')))
		{
			return '';
		}

		$attributes	= $this->attributes();

		foreach (array('base', 'size', 'id', 'title', 'type') as $key)
		{
			if (isset($attributes[$key]))
			{
				unset($attributes[$key]);
			}

			if (isset($attributes['tag_' . $key]))
			{
				$attributes[$key] = $attributes['tag_' . $key];

				unset($attributes['tag_' . $key]);
			}
		}

		// return an image tag html
		if ($type === 'i')
		{
			$this->load->helper('html');

			if (($index_page = (isset($size) && $size)) && strpos($size, '/')
				&& ! isset($attributes['width'], $attributes['height']))
			{
				list($attributes['width'], $attributes['height']) = explode('/', $size);
			}

			return $this->{'_build_tag_location_' . $base}($type, $uri, array(
				'attributes' => $attributes,
				'index_page' => isset($size) && $size
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

		return isset($this->_files[$id]) ? 1 : (int) $this->file_m->exists($id);
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

		$uri = BASE_URI . $uri;

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