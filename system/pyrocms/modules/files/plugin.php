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
	 * {/pyro:listing:all}
	 * 
	 * The following is a list of tags that are available to use from this method
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

		$folder_identity	= $this->attribute('folder_id');
		$limit				= $this->attribute('limit', '10');
		$type				= $this->attribute('type', '');

		if (is_numeric($folder_identity))
		{
			$folder_method = 'get';
		}
		elseif (is_string($folder_identity = $this->attribute('folder_path', '')) && $folder_identity)
		{
			$folder_method = 'get_by_path';
		}

		if ( ! isset($folder_method)													/* valid: folder identity */
			OR ($type && ! in_array($type, array('a','v','d','i','o')))					/* valid: file type filter */
			OR ! ($folder = $this->file_folders_m->{$folder_method}($folder_identity)))	/* valid: folder exists */
		{
			return array();
		}

		$this->file_m->where('folder_id', $folder->id);

		if ($type)
		{
			$this->file_m->where('type', $type);
		}

		if ($limit)
		{
			$this->file_m->limit($limit);
		}

		$files = assoc_array_prop($this->file_m->get_all());

		return array_merge($this->_files, $files);
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
		// return fields array
		elseif ( ! $return && $this->content())
		{
			return (array) $file;
		}

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
				: 'uploads/files/' . $file->filename;
		}
		else
		{
			$uri = 'uploads/files/' . $file->filename;
		}

		if ($return)
		{
			return ($return == 'url' ? rtrim(site_url(), '/') . '/' : BASE_URI) . $uri;
		}

		$index_page	= FALSE;
		$base		= $this->attribute('base');

		if ($type === 'i')
		{
			$this->load->helper('html');
		}
		else
		{
			$title		= $this->attribute('title');
			$attributes	= $this->attributes();

			foreach (array('base', 'id', 'title', 'type') as $key)
			{
				if (isset($attributes[$key]))
				{
					unset($attributes[$key]);
				}
			}
		}

		if ( ! file_exists(BASE_URI . $uri));
		{
			$index_page = TRUE;
		}

		if ($base === 'path')
		{
			$uri = BASE_URI . $uri;

			// unset config base_url
			$base_url = $this->config->item('base_url');
			$this->config->set_item('base_url', '');

			// generate tag
			if ($type === 'i')
			{
				$tag = img($uri, $index_page);
			}
			else
			{
				$tag = anchor($uri, $title, $attributes);
			}

			// set config base_url
			$base_url = $this->config->set_item('base_url', $base_url);

			return $tag;
		}

		return $type === 'i' ? img($uri, $index_page) : anchor($uri, $title, $attributes);
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
}

/* End of file plugin.php */