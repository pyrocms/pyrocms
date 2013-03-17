<?php defined('BASEPATH') or exit('No direct script access allowed');

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
	 * @access	public
	 * @var		array
	 */
	public $assets = array();

	// --------------------------------------------------------------------------
	
	/**
	 * Places where our field types may be
	 *
	 * @access	public
	 * @var		array
	 */
	public $addon_paths = array();

	// --------------------------------------------------------------------------

    public function __construct()
    {    
		$this->CI = get_instance();
		
		$this->CI->load->helper('directory');
		$this->CI->load->config('streams_core/streams');

		// These constants are used throughout the models.
		// They should be removed at some point in the future.
		if ( ! defined('STREAMS_TABLE')) define('STREAMS_TABLE', $this->CI->config->item('streams:streams_table'));
		if ( ! defined('FIELDS_TABLE')) define('FIELDS_TABLE', $this->CI->config->item('streams:fields_table'));		
		if ( ! defined('ASSIGN_TABLE')) define('ASSIGN_TABLE', $this->CI->config->item('streams:assignments_table'));
		if ( ! defined('SEARCH_TABLE')) define('SEARCH_TABLE', $this->CI->config->item('streams:searches_table'));

		// Get Lang (full name for language file)
		// This defaults to english.
		$langs = $this->CI->config->item('supported_languages');

		// Needed for installer
		if ( ! class_exists('Settings'))
		{
			$this->CI->load->library('settings/Settings');
		}

		// Obj to hold all our field types
		$this->types = new stdClass;
		
		// We either need a prefix or not
		// This is for legacy and if any 3rd party
		// field types use this constant
		(CMS_VERSION < 1.3) ? define('PYROSTREAMS_DB_PRE', '') : define('PYROSTREAMS_DB_PRE', SITE_REF.'_');
		
		// Since this is PyroStreams core we know where
		// PyroStreams is, but we set this for backwards
		// compatability for anyone using this constant.
		// Also, now that the Streams API is around, we need to
		// check if we need to change this based on the
		// install situation. 
		if(defined('PYROPATH'))
		{
			define('PYROSTEAMS_DIR', PYROPATH.'modules/streams_core/');
		}
		else
		{
			define('PYROSTEAMS_DIR', APPPATH.'modules/streams_core/');
		}

		// Set our addon paths
		$this->addon_paths = array(
			'core' 			=> PYROSTEAMS_DIR.'field_types/',
			'addon' 		=> ADDONPATH.'field_types/',
			'addon_alt' 	=> SHARED_ADDONPATH.'field_types/'
		);

		// Add addon paths event. This is an opportunity to
		// add another place for addons.
		if ( ! class_exists('Module_import'))
		{
			Events::trigger('streams_core_add_addon_path', $this);
		}
		
		// Go ahead and gather our types
		$this->gather_types();		
	}

	// --------------------------------------------------------------------------

	public function add_ft_path($key, $path)
	{
		$this->addon_paths[$key] = $path;
	}

	// --------------------------------------------------------------------------

	public function update_types()
	{
		Events::trigger('streams_core_add_addon_path', $this);

		// Go ahead and regather our types
		$this->gather_types();	
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get the types together as a big object
	 *
	 * @access	public
	 * @return	void
	 */
	public function gather_types()
	{
		foreach ($this->addon_paths as $raw_mode => $path)
		{
			$mode = ($raw_mode == 'core') ? 'core' : 'addon';
	
			$this->load_types_from_folder($path, $mode);
		}
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Load field types from a certain folder.
	 *
	 * Mostly used by this library, but can be used in
	 * a pinch if you need to bring in some field types
	 * from a custom location.
	 *
	 * @access	public
	 * @param	array
	 * @param	string
	 * @return	void
	 */	
	public function load_types_from_folder($addon_path, $mode = 'core')
	{
		if ( ! is_dir($addon_path)) return;

		$types_files = directory_map($addon_path, 1);

		foreach ($types_files as $type)
		{
			// Check if we've already loaded this field type
			if ( ! property_exists($this->types, $type))
			{
				// Is this a directory w/ a field type?
				if (is_dir($addon_path.$type) and is_file($addon_path.$type.'/field.'.$type.'.php'))
				{
					$this->types->$type = $this->_load_type($addon_path, 
										$addon_path.$type.'/field.'.$type.'.php',
										$type,
										$mode);
				}			
				elseif (is_file($addon_path.'field.'.$type.'.php'))
				{
					$this->types->$type = $this->_load_type($addon_path, 
										$addon_path.'field.'.$type.'.php',
										$type,
										$mode);												
				}
			}
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Load single type
	 *
	 * @access	public
	 * @param	string - type name
	 * @return	obj or null
	 */	
	public function load_single_type($type)
	{
		// Check if we've already loaded this field type
		if ( ! property_exists($this->types, $type))
		{
			foreach ($this->addon_paths as $mode => $path)
			{
				// Is this a directory w/ a field type?
				if (is_dir($path.$type) and is_file($path.$type.'/field.'.$type.'.php'))
				{
					return $this->_load_type($path, 
										$path.$type.'/field.'.$type.'.php',
										$type,
										$mode);		
				}
				elseif (is_file($path.'field.'.$type.'.php'))
				{
					return $this->_load_type($path, 
										$path.'field.'.$type.'.php',
										$type,
										$mode);
				}					
			}
		}
		else
		{
			return $this->types->$type;
		}
		
		return null;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Load the actual field type into the
	 * types object
	 *
	 * @access	private
	 * @param	string - addon path
	 * @param	string - path to the file (with the file name)
	 * @param	string - the field type
	 * @param	string - mode
	 * @return	obj - the type obj
	 */
	private function _load_type($path, $file, $type, $mode)
	{
		// -------------------------
		// Load the language file
		// -------------------------

		if (is_dir($path.$type.'/language'))
		{
			$lang = $this->CI->config->item('language');

			// Fallback on English
			if ( ! is_dir($path.$type.'/language/'.$lang)) $lang = 'english';

			$this->CI->lang->load($type.'_lang', $lang, false, false, $path.$type.'/');
			
			unset($lang);
		}

		// -------------------------
		// Load file
		// -------------------------

		require_once($file);
		
		$tmp = new stdClass;
	
		$class_name = 'Field_'.$type;
		
		if (class_exists($class_name))
		{
			$tmp = new $class_name();
			
			// Set some ft class vars
			$tmp->ft_mode 		= $mode;
			$tmp->ft_root_path 	= $path;
			$tmp->ft_path 		= $path.$type.'/';
			
			// And give us a CI instance
			$tmp->CI			= get_instance();
			
			// Field type name is languagized
			if ( ! isset($tmp->field_type_name))
			{
				$tmp->field_type_name = $this->CI->lang->line('streams:'.$type.'.name');
			}
		}
	
		return $tmp;
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Add a field type CSS file
	 */
	public function add_css($field_type, $file)
	{
		$html = '<link href="'.site_url('streams_core/field_asset/css/'.$field_type.'/'.$file).'" type="text/css" rel="stylesheet" />';
	
		$this->CI->template->append_metadata($html);
		
		$this->assets[] = $html;	
	}

	// --------------------------------------------------------------------------

	/**
	 * Add a field type JS file
	 */
	public function add_js($field_type, $file)
	{
		$html = '<script type="text/javascript" src="'.site_url('streams_core/field_asset/js/'.$field_type.'/'.$file).'"></script>';
	
		$this->CI->template->append_metadata($html);
		
		$this->assets[] = $html;	
	}

	// --------------------------------------------------------------------------

	/**
	 * Add a field type JS file
	 */
	public function add_misc($html)
	{	
		$this->CI->template->append_metadata($html);
		
		$this->assets[] = $html;	
	}

	// --------------------------------------------------------------------------

	/**
	 * Load a view from a field type
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	bool
	 */
	public function load_view($type, $view_name, $data = array())
	{	
		$paths = $this->CI->load->get_view_paths();

		$this->CI->load->set_view_path($this->types->$type->ft_path.'views/');

		$view_data = $this->CI->load->_ci_load(array('_ci_view' => $view_name, '_ci_vars' => $this->object_to_array($data), '_ci_return' => true));

		$this->CI->load->set_view_path($paths);

		return $view_data;
	}

	// --------------------------------------------------------------------

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
	protected function object_to_array($object)
	{
		return (is_object($object)) ? get_object_vars($object) : $object;
	}

	// --------------------------------------------------------------------------

	/**
	 * Load crud assets for all field crud assets
	 *
	 * @access	public
	 * @return	void
	 */	
	public function load_field_crud_assets($types = null)
	{
		if ( ! $types)
		{
			$types = $this->types;
		}

		foreach ($types as $type)
		{
			if (method_exists($type, 'add_edit_field_assets'))
			{
				$type->add_edit_field_assets();
			}
		}

		unset($types);
	}

	// --------------------------------------------------------------------------   

	/**
	 * Field Types array
	 *
	 * Create a drop down of field types
	 *
	 * @access	public
	 * @return	array
	 */
	public function field_types_array($types = null)
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
