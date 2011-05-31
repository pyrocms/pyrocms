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
	 * 	{file_id}
	 * 	{folder_id}
	 * 	{gallery_id}
	 * 	{gallery_slug}
	 * 	{title}
	 * 	{order}
	 * 	{name}
	 * 	{filename}
	 * 	{description}
	 * 	{extension}
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

	public function image($return = '')
	{
		$id		= $this->attribute('id');
		$image	= isset($this->_files[$id])
			? $this->_files[$id]
			: $this->file_m->get_by(array(
				'id'	=> $id,
				'type'	=> 'i'
			));

		if ( ! $image OR $image->type !== 'i')
		{
			return '';
		}
		elseif ($this->content())
		{
			return $image;
		}

		if ($return === 'url')
		{
			$this->load->helper('url');

			$method = 'site_url';
		}
		else
		{
			$this->load->helper('html');

			$method = 'img';
		}

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
			? 'files/thumb/' .  $image->id . '/' . $size
			: 'uploads/files/' . $image->filename;

		return $method($uri);
	}

	public function image_url()
	{
		return $this->image('url');
	}

	public function file($return = '')
	{
		$id		= $this->attribute('id');
		$file	= isset($this->_files[$id])
			? $this->_files[$id]
			: $this->file_m->get($id);

		if ( ! $file)
		{
			return '';
		}
		elseif ($this->content())
		{
			return $file;
		}

		$this->load->helper('url');

		$method = $return === 'url' ? 'site_url' : 'anchor';

		return $method('uploads/files/' . $image->filename);
	}

	public function file_url()
	{
		return $this->file('url');
	}

	public function exists()
	{
		$id = $this->attribute('id');

		return isset($this->_files[$id]) ? 1 : (int) $this->file_m->exists($id);
	}
}

/* End of file plugin.php */