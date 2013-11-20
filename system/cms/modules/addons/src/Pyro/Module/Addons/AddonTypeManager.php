<?php namespace Pyro\Module\Addons;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Str;

/**
 * PyroStreams Core Field Type Library
 *
 * @package		PyroCMS\Core\Modules\Addons
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class AddonTypeManager
{
	/**
	 * The module we're loading addons in regards to
	 * @var string
	 */
	protected static $module = false;

	/**
	 * The slug of the addon type being worked with
	 * @var string
	 */
	protected static $type_slug = false;

	/**
	 * Places where our types may be
	 *
	 * @var		array
	 */
	protected static $addon_paths = array();

	/**
	 * Modules where dashboards may be
	 *
	 * @var		array
	 */
	protected static $module_paths = array();

	/**
	 * Core addon path
	 * @var [type]
	 */
	protected static $core_addon_path;

	/**
	 * Available types
	 * @var array
	 */
	protected static $types = array();

	/**
	 * The registry of types - field_slug => class
	 * @var array
	 */
	protected static $slug_classes = array();

	/**
	 * Has the class being initiated
	 * @var object
	 */
	protected static $initiated = false;

	/**
	 * Get instance (singleton)
	 * @return [type] [description]
	 */
	public static function init($module, $type_slug, $preload = false)
	{
		if ( ! static::$initiated)
		{
			ci()->load->helper('directory');
			ci()->load->language($module.'/'.$module);

			// Get Lang (full name for language file)
			// This defaults to english.
			$langs = ci()->config->item('supported_languages');

			// Set the module and type_slug
			static::$module = $module;
			static::$type_slug = $type_slug;

			// Needed for installer
			if ( ! class_exists('Settings'))
			{
				ci()->load->library('settings/Settings');
			}

			// Set our addon paths
			static::$addon_paths = array(
				'addon' 		=> ADDONPATH.'addon_types/'.$module.'/'.$type_slug.'/',
				'addon_alt' 	=> SHARED_ADDONPATH.'addon_types/'.$module.'/'.$type_slug.'/',
			);

			// Set module paths
			$modules = new ModuleManager;

			foreach ($modules->getAllEnabled() as $enabled_module)
				if (is_dir($enabled_module['path'].'/addon_types/'.$module.'/'.$type_slug.'/'))
					static::$module_paths[$enabled_module['slug']] = $enabled_module['path'].'/addon_types/'.$module.'/'.$type_slug.'/';

			// Preload?
			if ($preload)
				self::preload();
		}

		static::$initiated = true;
	}

	/**
	 * Set addon path
	 * @param string $key  
	 * @param string $path 
	 */
	public static function setAddonPath($key, $path)
	{
		static::$addon_paths[$key] = $path;
	}

	/**
	 * Set module path
	 * @param string $key  
	 * @param string $path 
	 */
	public static function setModulePath($key, $path)
	{
		static::$module_paths[$key] = $path;
	}

	/**
	 * Get addon paths
	 * @return array
	 */
	public static function getAddonPaths()
	{
		return static::$addon_paths;
	}

	/**
	 * Get module paths
	 * @return array
	 */
	public static function getModulePaths()
	{
		return static::$module_paths;
	}

	/**
	 * Get type
	 * @param  string  $type         
	 * @param  boolean $gather_types 
	 * @return object
	 */
	public static function getType($type = null)
	{
		return ( ! empty(static::$types[$type]) and is_object(static::$types[$type])) ? static::$types[$type] : static::loadType($type);
	}

	/**
	 * Register slug class
	 * @param  array
	 * @return void
	 */
	public static function registerSlugClass($types = array())
	{
		if (is_string($types))
		{
			$types = array($types);
		}

		if (is_array($types))
		{
			foreach ($types as $type)
			{
				static::$slug_classes[$type] = static::getClass($type);
			}
		}
	}

	/**
	 * Register folder types
	 * @param  string  $folder
	 * @param  array   $types
	 * @param  boolean $preload
	 * @return void
	 */
	public static function registerFolderTypes($folder, $types = array(), $preload = false)
	{
		static::init(static::$module, static::$type_slug);

		if (is_string($types))
		{
			$types = array($types);
		}

		if ($types === true)
		{
			$types = directory_map($folder, 1);
		}

		if (is_array($types) and ! empty($types))
		{
			$loader = new ClassLoader;

			foreach ($types as $key => &$type)
			{
				$type = basename($type);

				if ($type == 'index.html')
				{
					unset($types[$key]);

					continue;
				}

				static::registerSlugClass($type);

				$loader->add(static::getClass($type), $folder.$type.'/src/');
			}

			$loader->register();

			if ($preload)
			{
				foreach ($types as $type)
				{
					static::getType($type);
				}
			}
		}
	}

	/**
	 * Register addon types
	 * @param  boolean $preload
	 * @return void
	 */
	public static function registerAddonTypes($preload = false)
	{
		foreach (static::getAddonPaths() as $key => $path)
		{
			static::registerFolderTypes($path, true, $preload);
		}
	}

	/**
	 * Register module types
	 * @param  boolean $preload
	 * @return void
	 */
	public static function registerModuleTypes($preload = false)
	{
		foreach (static::getModulePaths() as $key => $path)
		{
			static::registerFolderTypes($path, true, $preload);
		}
	}

	/**
	 * Get class
	 * @param  string $type
	 * @return string
	 */
	public static function getClass($type)
	{
		return 'Pyro\\AddonTypes\\'.Str::studly(static::$module).'\\'.Str::studly(static::$type_slug).'\\'.Str::studly($type);
	}

	/**
	 * Get classes
	 * @return array
	 */
	public static function getClasses()
	{
		return static::$slug_classes;
	}

	/**
	 * Get all types
	 * @return array 
	 */
	public static function getAllTypes()
	{
		static::preload();

		return new \Pyro\Module\Addons\AddonTypeCollection(static::$types);
	}

	/**
	 * Get the types together as a big object
	 *
	 * @return	void
	 */
	public static function preload()
	{
		static::registerFolderTypes(static::$core_addon_path.'addon_types/', true, true);

		static::registerAddonTypes(true);

		static::registerModuleTypes(true);
	}

	/**
	 * Load the actual type into the
	 * types object
	 *
	 * @param	string - addon path
	 * @param	string - path to the file (with the file name)
	 * @param	string - the type
	 * @param	string - mode
	 * @return	obj - the type obj
	 */
	// $path, $file, $type, $mode
	private static function loadType($type)
	{
		if (empty($type) or empty(static::$slug_classes[$type])) return null;

		$class = static::getClass($type);

		$instance = new $class;

		$reflection = new \ReflectionClass($instance);

		// Field Type class folder location
		$class_path = dirname($reflection->getFileName());

		// The root path of the type
		$path = dirname(dirname(dirname($class_path)));

		// Set asset paths
		$instance->path = $path;
		$instance->path_views = $path.'/views/';
		$instance->path_css = $path.'/css/';
		$instance->path_js = $path.'/js/';

		// -------------------------
		// Load the language file
		// -------------------------
		if (is_dir($path) and is_dir($path.'/language'))
		{
			$lang = ci()->config->item('language');

			// Fallback on English.
			if ( ! $lang) {
				$lang = 'english';
			}

			if ( ! is_dir($path.$lang)) {
				$lang = 'english';
			}

			ci()->lang->load($type.'_lang', $lang, false, false, $path.'/');

			unset($lang);
		}

		// Type name is languagized
		if ( ! isset($instance->type_name)) {
			$instance->type_name = lang_label(static::$module.':'.static::$type_slug.'.'.$type.'.name');
		}

		// Type description is languagized
		if ( ! isset($instance->type_description)) {
			$instance->type_description = lang_label(static::$module.':'.static::$type_slug.'.'.$type.'.description');
		}

		if (isset(ci()->profiler))
		{
			ci()->profiler->log->info($class.' loaded');
		}

		return static::$types[$type] = $instance;
	}
}
