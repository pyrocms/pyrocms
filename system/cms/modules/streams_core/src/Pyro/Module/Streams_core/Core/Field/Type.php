<?php namespace Pyro\Module\Streams_core\Core\Field;

/**
 * PyroStreams Core Field Type Library
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Libraries
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Type
{
	/**
	 * We build up these assets for the footer
	 *
	 * @var		array
	 */
	protected $assets = array();

	/**
	 * Places where our field types may be
	 *
	 * @var		array
	 */
	protected $addon_paths = array();

	protected $types = array();

	protected static $instance = null;

	/**
	 * Get instance (singleton)
	 * @return [type] [description]
	 */
    public static function getLoader()
    {
		ci()->load->helper('directory');
		ci()->load->config('streams_core/streams');

		// Get Lang (full name for language file)
		// This defaults to english.
		$langs = ci()->config->item('supported_languages');

		// Needed for installer
		if ( ! class_exists('Settings')) {
			ci()->load->library('settings/Settings');
		}

		if( ! isset(self::$instance))
		{
	    	$instance = new static;
	    }
	    else
	    {
	    	$instance = self::$instance;
	    }

		// Set our addon paths
	    $instance->addon_paths = array(
			'core' 			=> APPPATH.'modules/streams_core/field_types/',
			'addon' 		=> ADDONPATH.'field_types/',
			'addon_alt' 	=> SHARED_ADDONPATH.'field_types/'
		);

		// Add addon paths event. This is an opportunity to
		// add another place for addons.
		if ( ! class_exists('Module_import')) {
			\Events::trigger('streams_core_add_addon_path', $instance);
		}

	    return $instance;
	}

	public function setAddonPath($key, $path)
	{
		$this->addon_paths[$key] = $path;
	}

	public function getAddonPaths()
	{
		return $this->addon_paths;
	}

	public function registerType()
	{
		// @todo - starting an idea for a PSR field loader for 3.0/develop
	}

	public function getType($type = null, $gather_types = false)
	{
		return isset($this->types[$type]) ? $this->types[$type] : $this->loadSingleType($type, $gather_types);
	}

	public function getAllTypes()
	{
		$this->gatherTypes();

		return new \Pyro\Module\Streams_core\Core\Model\Collection\FieldTypeCollection($this->types);
	}

	public function updateTypes()
	{
		Events::trigger('streams_core_add_addon_path', $this);

		// Go ahead and regather our types
		return static::gatherTypes();
	}

	/**
	 * Get the types together as a big object
	 *
	 * @return	void
	 */
	public function gatherTypes()
	{
		foreach ($this->getAddonPaths() as $raw_mode => $path)
		{
			$mode = ($raw_mode == 'core') ? 'core' : 'addon';

			$this->loadTypesFromFolder($path, $mode);
		}
	}

	/**
	 * Load field types from a certain folder.
	 *
	 * Mostly used by this library, but can be used in
	 * a pinch if you need to bring in some field types
	 * from a custom location.
	 *
	 * @param	array
	 * @param	string
	 * @return	void
	 */
	public function loadTypesFromFolder($addon_path, $mode = 'core')
	{
		if ( ! is_dir($addon_path)) {
			return;
		}

		$types_files = directory_map($addon_path, 1);

		foreach ($types_files as $type) {

			$type = basename($type);

			if ($type == 'index.html') {
				continue;
			}

			// Is this a directory w/ a field type?
			if (is_dir($addon_path.$type) and is_file("{$addon_path}{$type}/field.{$type}.php")) {
				$this->types[$type] = $this->loadType(
					$addon_path,
					$addon_path.$type.'/field.'.$type.'.php',
					$type,
					$mode
				);
			} elseif (is_file("{$addon_path}field.{$type}.php")) {
				$this->types[$type] = $this->loadType(
					$addon_path,
					$addon_path.'field.'.$type.'.php',
					$type,
					$mode
				);
			}
		}
	}

	/**
	 * Load single type
	 *
	 * @param	string - type name
	 * @return	obj or null
	 */
	public function loadSingleType($type = null, $gather_types = false)
	{
		if ($gather_types)
		{
			$this->gatherTypes();	
		}
		
		// Check if we've already loaded this field type
		if (isset($this->types[$type])) return static::$types[$type];

		foreach ($this->addon_paths as $mode => $path)
		{
			// Is this a directory w/ a field type?
			if (is_dir($path.$type) and is_file($path.$type.'/field.'.$type.'.php')) {
				return $this->loadType(
					$path, 
					$path.$type.'/field.'.$type.'.php',
					$type,
					$mode
				);
			} elseif (is_file($path.'field.'.$type.'.php')) {
				return $this->loadType(
					$path, 
					$path.'field.'.$type.'.php',
					$type,
					$mode
				);
			}					
		}
	}

	/**
	 * Load the actual field type into the
	 * types object
	 *
	 * @param	string - addon path
	 * @param	string - path to the file (with the file name)
	 * @param	string - the field type
	 * @param	string - mode
	 * @return	obj - the type obj
	 */
	private function loadType($path, $file, $type, $mode)
	{
		// -------------------------
		// Load the language file
		// -------------------------

		if (is_dir($path.$type.'/language')) {
			$lang = ci()->config->item('language');

			// Fallback on English.
			if ( ! $lang) {
				$lang = 'english';
			}

			if ( ! is_dir($path.$type.'/language/'.$lang)) {
				$lang = 'english';
			}

			ci()->lang->load($type.'_lang', $lang, false, false, $path.$type.'/');

			unset($lang);
		}

		// -------------------------
		// Load file
		// -------------------------

		require_once($file);

		$instance = new \stdClass;

		$class_name = 'Field_'.$type;

		if (class_exists($class_name)) {
			$instance = new $class_name();

			// Set some ft class vars
			$instance->ft_mode 		= $mode;
			$instance->ft_root_path 	= $path;
			$instance->ft_path 		= $path.$type.'/';

			// Field type name is languagized
			if ( ! isset($instance->field_type_name)) {
				$instance->field_type_name = lang('streams:'.$type.'.name');
			}
		}

		return $instance;
	}

	/**
	 * Load crud assets for all field crud assets
	 *
	 * @return	void
	 */
	public function loadFieldCrudAssets($types = null)
	{
		if (! $types) {
			$types = $instance->types;
		}

		foreach ($types as $type) {
			if (method_exists($type, 'add_edit_field_assets')) {
				$type->add_edit_field_assets();
			}
		}

		unset($types);
	}

	/**
	 * Field Types array
	 *
	 * Create a drop down of field types
	 *
	 * @return	array
	 */
	public function fieldTypesArray($types = null)
	{
		if ( ! $types)
		{
			$types = $this->types;
		}

		$return = array();

		// For the chozen data placeholder value
		$return[null] = null;

		if ( ! $types) return array();

		foreach ($types as $type)
		{
			$return[$type->field_type_slug] = $type->field_type_name;
		}

		asort($return);

		return $return;
	}
}