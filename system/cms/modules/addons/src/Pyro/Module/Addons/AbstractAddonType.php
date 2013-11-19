<?php namespace Pyro\Module\Addons;

use Illuminate\Support\Str;
use Pyro\Module\Addons\AddonTypeManager;

abstract class AbstractAddonType
{
	/**
	 * Assets
	 * @var array
	 */
	protected $assets = array();

	/**
	 * The type object
	 * @var object
	 */
	protected $type = null;

	/**
	 * Version
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * Set type
	 * @param object $type
	 */
	public function setType($type = null)
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * Get the type
	 * @return object 
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Add a type CSS file
	 */
	public function css($file, $type = null)
	{
		$type = $type ? $type : AddonTypeManager::getType($this->slug);

		$html = '<link href="'.base_url($type->path_css.$file).'" type="text/css" rel="stylesheet" />';

		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Add a type JS file
	 */
	public function js($file, $type = false)
	{
		$type = $type ? $type : AddonTypeManager::getType($this->slug);

		$html = '<script type="text/javascript" src="'.base_url($type->path_js.$file).'"></script>';

		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Append etadata
	 */
	public function appendMetadata($html)
	{
		ci()->template->append_metadata($html);

		ci()->assets[] = $html;
	}

	/**
	 * Load a view from a type
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 */
	public function view($view_name, $data = array(), $type = null)
	{
		$type = $type ? $type : $this->slug;

		if ($type != $this->slug)
		{
			$type = AddonTypeManager::getType($type);
		}
		else
		{
			$type = $this;
		}

		$paths = ci()->load->get_view_paths();

		ci()->load->set_view_path($type->path_views);

		$view_data = ci()->load->_ci_load(array('_ci_view' => $view_name, '_ci_vars' => $this->objectToArray($data), '_ci_return' => true));

		ci()->load->set_view_path($paths);

		return $view_data;
	}

	/**
	 * Object to Array
	 *
	 * Takes an object as input and converts the class variables to array key/vals
	 *
	 * From CodeIgniter's Loader class - moved over here since it was protected.
	 *
	 * @param	object
	 * @return	array
	 */
	protected function objectToArray($object)
	{
		return (is_object($object)) ? get_object_vars($object) : $object;
	}

	/**
	 * Get a property of me
	 * @param  string $key 
	 * @return mixed
	 */
	public function getProperty($key)
	{
		$method = 'get'.Str::studly($key).'Property';

		if (method_exists($this, $method))
		{
			return $this->$method($key);
		}

		return null;
	}
}
