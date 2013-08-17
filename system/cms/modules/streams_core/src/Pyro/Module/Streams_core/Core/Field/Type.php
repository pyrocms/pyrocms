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
	protected static $assets = array();

	/**
	 * Places where our field types may be
	 *
	 * @var		array
	 */
	protected static $addon_paths = array();

	protected static $types = array();

	/**
	 * Constructor
	 */
    public function __construct()
    {
/*		ci()->load->helper('directory');
		ci()->load->config('streams_core/streams');

		// These constants are used throughout the models.
		// They should be removed at some point in the future.
		// if ( ! defined('STREAMS_TABLE')) define('STREAMS_TABLE', ci()->config->item('streams:streams_table'));
		// if ( ! defined('FIELDS_TABLE')) define('FIELDS_TABLE', ci()->config->item('streams:fields_table'));
		// if ( ! defined('ASSIGN_TABLE')) define('ASSIGN_TABLE', ci()->config->item('streams:assignments_table'));
		// if ( ! defined('SEARCH_TABLE')) define('SEARCH_TABLE', ci()->config->item('streams:searches_table'));

		// Get Lang (full name for language file)
		// This defaults to english.
		$langs = ci()->config->item('supported_languages');

		// Needed for installer
		if ( ! class_exists('Settings')) {
			ci()->load->library('settings/Settings');
		}

		// We either need a prefix or not
		// This is for legacy and if any 3rd party
		// field types use this constant
		define('PYROSTREAMS_DB_PRE', SITE_REF.'_');

		// Since this is PyroStreams core we know where
		// PyroStreams is, but we set this for backwards
		// compatability for anyone using this constant.
		// Also, now that the Streams API is around, we need to
		// check if we need to change this based on the
		// install situation.
		if (defined('PYROPATH')) {
			define('PYROSTEAMS_DIR', PYROPATH.'modules/streams_core/');
		} else {
			define('PYROSTEAMS_DIR', APPPATH.'modules/streams_core/');
		}

		// Set our addon paths
		static::$addon_paths = array(
			'core' 			=> PYROSTEAMS_DIR.'field_types/',
			'addon' 		=> ADDONPATH.'field_types/',
			'addon_alt' 	=> SHARED_ADDONPATH.'field_types/'
		);

		// Add addon paths event. This is an opportunity to
		// add another place for addons.
		if ( ! class_exists('Module_import')) {
			Events::trigger('streams_core_add_addon_path', $this);
		}*/
	}

	public static function addPath($key, $path)
	{
		static::$addon_paths[$key] = $path;
	}

	public static function getPaths()
	{
		return static::$addon_paths;
	}

	public function registerType()
	{
		
	}

	public static function addType($slug, $type)
	{

	}

	public static function updateTypes()
	{
		Events::trigger('streams_core_add_addon_path', $this);

		// Go ahead and regather our types
		return static::getTypes();
	}

	/**
	 * Get the types together as a big object
	 *
	 * @return	void
	 */
	public static function getTypes()
	{
		foreach (static::getAddonPaths() as $raw_mode => $path) {
			$mode = ($raw_mode == 'core') ? 'core' : 'addon';

			static::loadTypesFromFolder($path, $mode);
		}
	}

	public static function getFieldType(\Pyro\Module\Streams_core\Core\Model\Field $field = null, \Pyro\Module\Streams_core\Core\Model\Entry $entry = null)
    {
        if ( ! $field)
        {
            return false;
        }

        // If no entry was passed at least instantiate an empty entry object
        if ( ! $entry)
        {
        	$entry = new \Pyro\Module\Streams_core\Core\Model\Entry;
        }

        // @todo - replace the Type library with the PSR version
        if ( ! $type = isset(ci()->type->types->{$field->field_type}) ? ci()->type->types->{$field->field_type} : null)
        {
            return false;
        }

        $type->setField($field);

        $type->setEntry($entry);
        
        $type->setModel($entry->getModel());
        
        $type->setEntryBuilder($entry->getModel()->newQuery());
        
        $type->setValue($entry->{$field->field_slug});

        return $type;
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
	public static function loadTypesFromFolder($addon_path, $mode = 'core')
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
				$this->types->$type = static::loadType(
					$addon_path,
					$addon_path.$type.'/field.'.$type.'.php',
					$type,
					$mode
				);
			} elseif (is_file("{$addon_path}field.{$type}.php")) {
				$this->types->$type = static::loadType(
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
	public function loadSingleType($type)
	{
		// Check if we've already loaded this field type
		if ( ! property_exists($this->types, $type)) {
			foreach ($this->addon_paths as $mode => $path) {
				// Is this a directory w/ a field type?
				if (is_dir($path.$type) and is_file($path.$type.'/field.'.$type.'.php')) {
					return static::loadType(
						$path, 
						$path.$type.'/field.'.$type.'.php',
						$type,
						$mode
					);		
				} elseif (is_file($path.'field.'.$type.'.php')) {
					return static::loadType(
						$path, 
						$path.'field.'.$type.'.php',
						$type,
						$mode
					);
				}					
			}
		}

		return $this->types->$type;
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

		$tmp = new stdClass;

		$class_name = 'Field_'.$type;

		if (class_exists($class_name)) {
			$tmp = new $class_name();

			// Set some ft class vars
			$tmp->ft_mode 		= $mode;
			$tmp->ft_root_path 	= $path;
			$tmp->ft_path 		= $path.$type.'/';

			// And give us a CI instance
			$tmp->CI			= get_instance();

			// Field type name is languagized
			if ( ! isset($tmp->field_type_name)) {
				$tmp->field_type_name = lang('streams:'.$type.'.name');
			}
		}

		return $tmp;
	}

	/**
	 * Add a field type CSS file
	 */
	public function addCss($field_type, $file)
	{
		$html = '<link href="'.site_url('streams_core/field_asset/css/'.$field_type.'/'.$file).'" type="text/css" rel="stylesheet" />';

		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Add a field type JS file
	 */
	public function addJs($field_type, $file)
	{
		$html = '<script type="text/javascript" src="'.site_url('streams_core/field_asset/js/'.$field_type.'/'.$file).'"></script>';

		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Add a field type JS file
	 */
	public function addMisc($html)
	{
		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Load a view from a field type
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 */
	public function loadView($type, $view_name, $data = array())
	{
		$paths = ci()->load->get_view_paths();

		ci()->load->set_view_path($this->types->$type->ft_path.'views/');

		$view_data = ci()->load->_ci_load(array('_ci_view' => $view_name, '_ci_vars' => $this->object_to_array($data), '_ci_return' => true));

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
	 * Load crud assets for all field crud assets
	 *
	 * @return	void
	 */
	public function loadFieldCrudAssets($types = null)
	{
		if (! $types) {
			$types = $this->types;
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
		if (! $types) {
			$types = $this->types;
		}

		$return = array();

		// For the chozen data placeholder value
		$return[null] = null;

		if ( ! $types) return array();

		foreach ($types as $type) {
			$return[$type->field_type_slug] = $type->field_type_name;
		}

		asort($return);

		return $return;
	}
}