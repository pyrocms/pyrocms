<?php

/**
 * Asset: Convenient asset library
 * 
 * This was a FuelPHP package converted for use within PyroCMS by Phil Sturgeon with 
 * express written consent from Antony Male to be used within PyroCMS Community and Professional
 *
 * @version    v1.11
 * @author     Antony Male
 * @license    MIT License
 * @copyright  2011 Antony Male
 * @author     Phil Sturgeon
 * @package    PyroCMS\Core\Libraries\Asset
 */
class Asset_Exception extends Exception {}
include(dirname(__FILE__).'/Asset/jsmin.php');
include(dirname(__FILE__).'/Asset/csscompressor.php');
include(dirname(__FILE__).'/Asset/cssurirewriter.php');

class Asset {

	/**
	 * @var array Array of paths in which the css, js, img directory structure
	 *            can be found, relative to $asset_url
	 */
	protected static $asset_paths = array(
		'core' => 'assets/',
	);

	/**
	 * @var string The key in $asset_paths to use if no key is given
	 */
	protected static $default_path_key = 'core';

	/**
	 * @var string The URL to be prepended to all assets.
	 */
	protected static $asset_url = null;

	/**
	 * @var array The folders in which css, js, and images can be found.
	 */
	protected static $default_folders = array(
		'css' => 'css/',
		'js' => 'js/',
		'img' => 'img/',
	);

	/**
	 * @var string The directory, relative to public/, where cached minified failes
	 *             are stored.
	 */
	protected static $cache_path = 'assets/cache/';

	/**
	 * @var array Holds groups of assets. Is documented fully in the config file.
	 */
	protected static $groups = array(
		'css' => array(),
		'js' => array(),
	);

	/**
	 * @var array Holds inline js and css.
	 */
	protected static $inline_assets = array(
		'css' => array(),
		'js' => array(),
	);

	/**
	 *
	 * @var array Defaults for a group
	 */
	protected static $default_options = array(
		'enabled' => true,
		'combine' => true,
		'min' => true,
		'inline' => false,
		'attr' => array(),
		'deps' => array(),
	);

	/**
	 * @var int How deep to go when resolving deps
	 */
	protected static $deps_max_depth = 5;

	/**
	 * @var bool Whether to show comments above the <script>/<link> tags showing
	 *           which files have been minified into that file.
	 */
	protected static $show_files = false;

	/**
	 * @var bool Whether to show comments inside minified files showing which
	 *           original file is where.
	 */
	protected static $show_files_inline = false;

	/**
	 * @var string If given, the name of the function to call when we have
	 *   read a file, before minifying. Note: It is only called if $combine
	 *   for the file is `true`.
	 *   Prototype: callback(content, filename, type, group_name);
	 */
	protected static $post_load_callback = null;

	/**
	 * @var function If given, the function to call when we've decided on the name
	 *               for a file, but want to allow the user to tweak it before we
	 *               write it to the page.
	 *               Prototype: callback($filepath, $type, $remote);
	 */
	protected static $filepath_callback = null;

	/**
	 * @var array Keeps a record of which groups have been rendered.
	 *            We then check this when deciding whether to render a dep.
	 */
	protected static $rendered_groups = array('js' => array(), 'css' => array());

	/**
	 * @var array Symlink-ed directories and their targets. Since the paths to assets and
	 * paths inside the assets get rewritten, we have to provide the symlink-ed directories
	 * and their targets
	*/
	protected static $symlinks = array();

	/**
	 * Loads in the config and sets the variables
	 */
	public function __construct()
	{
		$ci = get_instance();

		$ci->config->load('asset');

		$paths = $ci->config->item('asset_paths') ? $ci->config->item('asset_paths') : self::$asset_paths;

		self::$symlinks = $ci->config->item('asset_symlinks') ? $ci->config->item('asset_symlinks') : array();

		foreach ($paths as $key => $path)
		{
			self::add_path($key, $path);
		}

		self::$asset_url = $ci->config->item('asset_url') ? $ci->config->item('asset_url') : $ci->config->item('base_url');

		self::$default_folders = array(
			'css' => $ci->config->item('asset_css_dir'),
			'js' => $ci->config->item('asset_js_dir'),
			'img' => $ci->config->item('asset_img_dir'),
		);

		is_null($ci->config->item('asset_cache_path')) or self::$cache_path = $ci->config->item('asset_cache_path');
		is_null($ci->config->item('asset_min')) or self::$default_options['min'] = $ci->config->item('asset_min');
		is_null($ci->config->item('asset_combine')) or self::$default_options['combine'] = $ci->config->item('asset_combine');
		is_null($ci->config->item('asset_deps_max_depth')) or self::$deps_max_depth = $ci->config->item('asset_deps_max_depth');

		$group_sets = $ci->config->item('asset_groups') ? $ci->config->item('asset_groups') : array();

		foreach ($group_sets as $group_type => $groups)
		{
			foreach ($groups as $group_name => $group)
			{
				$options = self::prep_new_group_options($group);
				self::add_group($group_type, $group_name, $group['files'], $options);
			}
		}

		// Add the global group if it doesn't already exist.
		// This is so that set_group_option() can be used on it. This function will
		// throw an exception if the named group doesn't exist.
		if (!self::group_exists('js', 'global'))
		{
			self::add_group_base('js', 'global');
		}

		if (!self::group_exists('css', 'global'))
		{
			self::add_group_base('css', 'global');
		}

		is_null($ci->config->item('asset_show_files')) or self::$show_files = $ci->config->item('asset_show_files');
		is_null($ci->config->item('asset_show_files_inline')) or self::$show_files_inline = $ci->config->item('asset_show_files_inline');
		is_null($ci->config->item('asset_post_load_callback')) or self::$post_load_callback = $ci->config->item('asset_post_load_callback');
		is_null($ci->config->item('asset_filepath_callback')) or self::$filepath_callback = $ci->config->item('asset_filepath_callback');
	}


	/**
	 * Sets up options for new groups setup via asset/config.php.
	 * Abstracts away from _init method. Also easier if options are
	 * added in future as iterates through defaults to do checking.
	 *
	 * @param array $group_options Options as defined in group in config.php
	 *
	 * @return array
	 */
	protected static function prep_new_group_options($group_options)
	{
		$options = array();
		foreach (self::$default_options as $key => $option_val)
		{
			if (array_key_exists($key, $group_options))
			{
				$options[$key] = $group_options[$key];
			}
		}
		return $options;
	}


	/**
	 * Parses one of the 'paths' config keys into the format used internally.
	 * Config file format:
	 * <code>
	 * 'paths' => array(
	 *		'assets/',
	 *		array(
	 *			'path' => 'assets_2/',
	 *			'js_dir' => 'js/',
	 *			'css_dir' => 'css/',
	 *		),
	 * ),
	 * </code>
	 * In the event that the value is not an array, it is turned into one.
	 * If js_dir, css_dir or img_dir are not given, they are populated with
	 * the defaults, giving in the 'js_dir', 'css_dir' and 'img_dir' config keys.
	 *
	 * @param string $path_key The key of the path
	 * @param mixed $path_attr The path attributes, as described above
	 */
	public static function add_path($path_key, $path_attr)
	{
		$path_val = array();

		if (!is_array($path_attr))
		{
			$path_attr = array('path' => $path_attr, 'dirs' => array());
		}
		elseif (!array_key_exists('dirs', $path_attr))
		{
			$path_attr['dirs'] = array();
		}

		$path_val['path'] = $path_attr['path'];

		$path_val['dirs'] = array(
			'js' => array_key_exists('js_dir', $path_attr) ? $path_attr['js_dir'] : self::$default_folders['js'],
			'css' => array_key_exists('css_dir', $path_attr) ? $path_attr['css_dir'] : self::$default_folders['css'],
			'img' => array_key_exists('img_dir', $path_attr) ? $path_attr['img_dir'] : self::$default_folders['img'],
		);

		self::$asset_paths[$path_key] = $path_val;
	}


	/**
	 * Set the current default path
	 *
	 * @param string $path_key The path key to set the default to.
	 *
	 * @throws Asset_Exception
	 */
	public static function set_path($path_key = 'core')
	{
		if (!array_key_exists($path_key, self::$asset_paths))
		{
			throw new Asset_Exception("Asset path key $path_key doesn't exist");
		}

		self::$default_path_key = $path_key;
	}


	/**
	 * Set the asset_url, to allow for CDN url's and such
	 *
	 * @param string $url The url to use.
	 */
	public static function set_url($url)
	{
		self::$asset_url = $url;
	}


	/**
	 * Adds a group of assets. If a group of this name exists, the function returns.
	 *
	 * The options array should be like:
	 * <code>
	 * array(
	 *   'enabled' => true|false,
	 *   'combine' => true|false,
	 *   'min' => true|false,
	 *   'inline' => true|false,
	 *	 'deps' => array(),
	 * );
	 * </code>
	 *
	 * @param string $group_type 'js' or 'css'
	 * @param string $group_name The name of the group
	 * @param array $options An array of options.
	 *
	 * @throws Asset_Exception
	 */
	protected static function add_group_base($group_type, $group_name, $options = array())
	{
		// Insert defaults
		$options += self::$default_options;

		if (!is_array($options['deps']))
		{
			$options['deps'] = array($options['deps']);
		}

		$options['files'] = array();

		// If it already exists, do not overwrite it.
		if (array_key_exists($group_name, self::$groups[$group_type]))
		{
			throw new Asset_Exception("Group $group_name already exists: can't create it.");
		}

		self::$groups[$group_type][$group_name] = $options;
	}


	/**
	 * Adds a group for assets, and adds assets to that group.
	 *
	 * The options array should be like:
	 * <code>
	 * array(
	 *   'enabled' => true|false,
	 *   'combine' => true|false,
	 *   'min' => true|false,
	 *   'inline' => true|false,
	 *	 'deps' => array(),
	 * );
	 * </code>
	 * To maintain backwards compatibility, you can also pass $enabled here instead of an array of options..
	 *
	 *
	 * @param string $group_type 'js' or 'css'
	 * @param string $group_name The name of the group
	 * @param array $files
	 * @param array $options An array of options.
	 * @param null|bool $combine_dep @deprecated Whether to combine files in this group. Default (null) means use config setting
	 * @param null|bool $min_dep @deprecated Whether to minify files in this group. Default (null) means use config setting
	 */
	public static function add_group($group_type, $group_name, $files, $options = array(), $combine_dep = null, $min_dep = null)
	{
		// Bit of backwards compatibity.
		// Order used to be add_group(group_type, group_name, files, enabled, combine, min)
		if (!is_array($options))
		{
			$options = array(
				'enabled' => $options,
				'combine' => $combine_dep,
				'min' => $min_dep,
			);
		}
		// We are basically faking the old add_group.
		// However, the approach has changed since those days
		// Therefore we create the group if it does not already
		// exist, then add the files to it.
		self::add_group_base($group_type, $group_name, $options);

		foreach ($files as $file)
		{
			if (!is_array($file))
			{
				$file = array($file, false);
			}

			self::add_asset($group_type, $file[0], $file[1], $group_name);
		}
	}


	/**
	 * Returns true if the given group exists
	 *
	 * @param string $group_type 'js' or 'css'
	 * @param string $group_name The name of the group
	 *
	 * @return bool
	 */
	public static function group_exists($group_type, $group_name)
	{
		return array_key_exists($group_name, self::$groups[$group_type]);
	}


	/**
	 * Enables both js and css groups of the given name.
	 *
	 * @param string|array $groups The group to enable, or array of groups
	 */
	public static function enable($groups)
	{
		self::asset_enabled('js', $groups, true);
		self::asset_enabled('css', $groups, true);
	}


	/**
	 * Disables both js and css groups of the given name.
	 *
	 * @param string|array $groups The group to disable, or array of groups
	 */
	public static function disable($groups)
	{
		self::asset_enabled('js', $groups, false);
		self::asset_enabled('css', $groups, false);
	}


	/**
	 * Enable a group of javascript assets.
	 *
	 * @param string|array $groups The group to enable, or array of groups
	 */
	public static function enable_js($groups)
	{
		self::asset_enabled('js', $groups, true);
	}


	/**
	 * Disable a group of javascript assets.
	 *
	 * @param string|array $groups The group to disable, or array of groups
	 */
	public static function disable_js($groups)
	{
		self::asset_enabled('js', $groups, false);
	}


	/**
	 * Enable a group of css assets.
	 *
	 * @param string|array $groups The group to enable, or array of groups
	 */
	public static function enable_css($groups)
	{
		self::asset_enabled('css', $groups, true);
	}

	/**
	 * Disable a group of css assets.
	 *
	 * @param string|array $groups The group to disable, or array of groups
	 */
	public static function disable_css($groups)
	{
		self::asset_enabled('css', $groups, false);
	}


	/**
	 * Enables or disables an asset.
	 *
	 * @param string $type 'css' or 'js'.
	 * @param string|array $groups The group to enable/disable, or array of groups.
	 * @param bool $enabled True to enable the group, false to disable.
	 */
	protected static function asset_enabled($type, $groups, $enabled)
	{
		if (!is_array($groups))
		{
			$groups = array($groups);
		}

		foreach ($groups as $group)
		{
			// If the group does not exist it is of no consequence.
			if (!array_key_exists($group, self::$groups[$type]))
			{
				continue;
			}

			self::$groups[$type][$group]['enabled'] = $enabled;
		}
	}


	/**
	 * Set group options on-the-fly.
	 *
	 * @param string $type 'css' or 'js'.
	 * @param string|array $group_names Group name to change, or array of groups to change,
	 *   or '' for global group, or '*' for all groups.
	 * @param string $option_key The name of the option to change.
	 * @param mixed $option_value What to set the option to.
	 *
	 * @throws Asset_Exception
	 */
	public static function set_group_option($type, $group_names, $option_key, $option_value)
	{
		if ($group_names == '')
		{
			$group_names = array('global');
		}
		else
		{
			if ($group_names == '*')
			{
				// Change the default
				self::$default_options[$option_key] = $option_value;
				$group_names = array_keys(self::$groups[$type]);
			}
			else
			{
				if (!is_array($group_names))
				{
					$group_names = array($group_names);
				}
			}
		}

		// Allow them to specify a single string dep
		if ($option_key == 'deps' && !is_array($option_value))
		{
			$option_value = array($option_value);
		}

		foreach ($group_names as $group_name)
		{
			// If the group doesn't exist, throw a fuss
			if (!self::group_exists($type, $group_name))
			{
				throw new Asset_Exception("Can't set option for group '$group_name' ($type), as it doesn't exist.");
			}

			self::$groups[$type][$group_name][$option_key] = $option_value;
		}
	}


	/**
	 * Set group options on-the-fly, js version
	 *
	 * @param string|array $group_names Group name to change, or array of groups to change,
	 *   or '' for global group, or '*' for all groups.
	 * @param string $option_key The name of the option to change.
	 * @param mixed $option_value What to set the option to.
	 */
	public static function set_js_option($group_names, $option_key, $option_value)
	{
		self::set_group_option('js', $group_names, $option_key, $option_value);
	}

	/**
	 * Set group options on-the-fly, css version
	 *
	 * @param mixed $group_names Group name to change, or array of groups to change,
	 *   or '' for global group, or '*' for all groups.
	 * @param string $option_key The name of the option to change
	 * @param mixed $option_value What to set the option to
	 */
	public static function set_css_option($group_names, $option_key, $option_value)
	{
		self::set_group_option('css', $group_names, $option_key, $option_value);
	}


	/**
	 * Add a javascript asset.
	 *
	 * @param string|array $script The script to add.
	 * @param bool $script_min If given, will be used when $min = true
	 *   If omitted, $script will be minified internally.
	 * @param string $group The group to add this asset to. Defaults to 'global'
	 *
	 * @return mixed
	 */
	public static function js($script, $script_min = false, $group = 'global')
	{
		if (is_array($script))
		{
			foreach ($script as $each)
			{
				self::add_asset('js', $each, $script_min, $group);
			}
			return;
		}

		self::add_asset('js', $script, $script_min, $group);
	}

	/**
	 * Add a css asset.
	 *
	 * @param string|array $sheet The script to add
	 * @param bool $sheet_min If given, will be used when $min = true
	 *   If omitted, $script will be minified internally.
	 * @param string $group The group to add this asset to. Defaults to 'global'
	 * @return mixed
	 */
	public static function css($sheet, $sheet_min = false, $group = 'global')
	{
		if (is_array($sheet))
		{
			foreach ($sheet as $each) 
			{
				self::add_asset('css', $each, $sheet_min, $group); 
			}
			return;
		}
		
		self::add_asset('css', $sheet, $sheet_min, $group);
	}


	/**
	 * Abstraction of js() and css().
	 *
	 * @param string $type 'css' or 'js'.
	 * @param string $script The script to add.
	 * @param bool $script_min If given, will be used when $min = true
	 *   If omitted, $script will be minified internally.
	 * @param string $group The group to add this asset to
	 *
	 * @return mixed
	 */
	protected static function add_asset($type, $script, $script_min, $group)
	{
		// Allow the user to specify any non-string value for an asset, and it
		// will be ignore. This can be handy when using ternary operators
		// in the groups config.
		if (!is_string($script))
		{
			return;
		}

		// Do not force the user to remember that 'false' is used when not supplying
		// a pre-minified file.
		if (!is_string($script_min))
		{
			$script_min = false;
		}

		$files = array($script, $script_min);

		// If a path key has not been specified, add $default_path_key
		foreach ($files as &$file)
		{
			if ($file != false && strpos($file, '::') === false)
			{
				$file = self::$default_path_key . '::' . $file;
			}
		}

		if (!array_key_exists($group, self::$groups[$type]))
		{
			// Assume they want the group enabled
			self::add_group_base($type, $group);
		}

		array_push(self::$groups[$type][$group]['files'], $files);
	}


	/**
	 * Add a string containing javascript, which can be printed inline with
	 * js_render_inline().
	 *
	 * @param string $content The javascript to add.
	 */
	public static function js_inline($content)
	{
		self::add_asset_inline('js', $content);
	}


	/**
	 * Add a string containing css, which can be printed inline with
	 * render_css_inline().
	 *
	 * @param string $content The css to add.
	 */
	public static function css_inline($content)
	{
		self::add_asset_inline('css', $content);
	}


	/**
	 * Abstraction of js_inline() and css_inline().
	 *
	 * @param string $type 'css' or 'js'.
	 * @param string $content The css or js to add.
	 */
	protected static function add_asset_inline($type, $content)
	{
		array_push(self::$inline_assets[$type], $content);
	}


	/**
	 * Return the path for the given JS asset. Ties into find_files, so supports
	 * everything that, say, Asset::js() does.
	 * Throws an exception if the file isn't found.
	 *
	 * @param string $filename the name of the asset to find
	 * @param bool $add_url whether to add the 'url' config key to the filename
	 * @param bool $force_array By default, when one file is found a string is
	 *   returned. Setting this to true causes a single-element array to be returned.
	 *
	 * @return string
	 */
	public static function get_filepath_js($filename, $add_url = false, $force_array = false)
	{
		return self::get_filepath($filename, 'js', $add_url, $force_array);
	}


	/**
	 * Return the path for the given CSS asset. Ties into find_files, so supports
	 * everything that, say, Asset::js() does.
	 * Throws an exception if the file isn't found.
	 *
	 * @param string $filename the name of the asset to find.
	 * @param bool $add_url whether to add the 'url' config key to the filename.
	 * @param bool $force_array By default, when one file is found a string is
	 *		returned. Setting this to true causes a single-element array to be returned.
	 *
	 * @return string
	 */
	public static function get_filepath_css($filename, $add_url = false, $force_array = false)
	{
		return self::get_filepath($filename, 'css', $add_url, $force_array);
	}


	/**
	 * Return the path for the given img asset. Ties into find_files, so supports
	 * everything that, say, Asset::js() does.
	 * Throws an exception if the file isn't found.
	 *
	 * @param string $filename the name of the asset to find.
	 * @param bool $add_url whether to add the 'url' config key to the filename.
	 * @param bool $force_array By default, when one file is found a string is
	 *		returned. Setting this to true causes a single-element array to be returned.
	 *
	 * @return string
	 */
	public static function get_filepath_img($filename, $add_url = false, $force_array = false)
	{
		return self::get_filepath($filename, 'img', $add_url, $force_array);
	}


	/**
	 * Return the path for the given asset. Ties into find_files, so supports
	 * everything that, say, Asset::js() does.
	 * Throws an exception if the file isn't found.
	 *
	 * @param string $filename the name of the asset to find.
	 * @param string $type 'js', 'css' or 'img'.
	 * @param bool $add_url Whether to add the 'url' config key to the filename
	 * @param bool $force_array By default, when one file is found a string is
	 *   returned. Setting this to true causes a single-element array to be returned.
	 *
	 * @return string
	 */
	public static function get_filepath($filename, $type, $add_url = false, $force_array = false)
	{
		if (strpos($filename, '::') === false)
		{
			$filename = self::$default_path_key . '::' . $filename;
		}

		$files = self::find_files($filename, $type);

		foreach ($files as &$file)
		{
			$remote = (strpos($file, '//') !== false);
			$file = self::process_filepath($file, $type, $remote);

			if ($remote)
			{
				continue;
			}

			if ($add_url)
			{
				$file = self::$asset_url . $file;
			}
		}

		if (count($files) == 1 && !$force_array)
		{
			return $files[0];
		}

		return $files;
	}


	/**
	 * Can be used to add deps to a group.
	 *
	 * @param string $type 'css' or 'js'.
	 * @param string $group The group name to add deps to.
	 * @param array $deps An array of group names to add as deps.
	 *
	 * @throws Exception
	 */
	public static function add_deps($type, $group, $deps)
	{
		if (!is_array($deps))
		{
			$deps = array($deps);
		}

		if (!array_key_exists($group, self::$groups[$type]))
		{
			throw new Exception("Group $group ($type) doesn't exist, so can't add deps to it.");
		}

		array_push(self::$groups[$type][$group]['deps'], $deps);
	}

	/**
	 * Sugar for add_deps(), for js groups
	 * @param string $group The group name to add deps to
	 * @param array $deps An array of group names to add as deps.
	 */
	public static function add_js_deps($group, $deps)
	{
		self::add_deps('js', $group, $deps);
	}

	/**
	 * Sugar for add_deps(), for css groups
	 * @param string $group The group name to add deps to
	 * @param array $deps An array of group names to add as deps.
	 */
	public static function add_css_deps($group, $deps)
	{
		self::add_deps('css', $group, $deps);
	}


	/**
	 * Sticks the given filename through the filepath callback, if given.
	 *
	 * @param string $filepath The filepath to process
	 * @param string $type The type of asset, passed to the callback
	 * @param bool $remote Whether the asset is on another machine, passed to the callback
	 * 
	 * @return string
	 */
	protected static function process_filepath($filepath, $type, $remote = null)
	{
		if (self::$filepath_callback)
		{
			if ($remote === null)
				$remote = (strpos($filepath, '//') !== false);
			$func = self::$filepath_callback;
			$filepath = $func($filepath, $type, $remote);
		}
		return $filepath;
	}


	/**
	 * Shortcut to render_js() and render_css().
	 *
	 * @param bool|string $group Which group to render. If omitted renders all groups
	 * @param bool|null $inline_dep @deprecated If true, the result is printed inline.
	 *   If false, is written to a file and linked to. In fact, $inline = true also
	 *   causes a cache file to be written for speed purposes.
	 * @param string|array $attr The javascript tags to be written to the page
	 *
	 * @return string
	 */
	public static function render($group = false, $inline_dep = null, $attr = array())
	{
		$r = self::render_css($group, $inline_dep, $attr);
		$r .= self::render_js($group, $inline_dep, $attr);
		return $r;
	}


	/**
	 * Renders the specific javascript group, or all groups if no group specified.
	 *
	 * @param bool|string $group Which group to render. If omitted renders all groups.
	 * @param bool|null $inline_dep @deprecated If true, the result is printed inline.
	 *   If false, is written to a file and linked to. In fact, $inline = true also
	 *   causes a cache file to be written for speed purposes.
	 * @param array $attr_dep @todo Document this
	 *
	 * @return string The javascript tags to be written to the page
	 */
	public static function render_js($group = false, $inline_dep = null, $attr_dep = array())
	{
		// Do nοt force the user to remember that false is used for ommitted non-bool arguments
		if (!is_string($group))
		{
			$group = false;
		}

		if (!is_array($attr_dep))
		{
			$attr_dep = array();
		}

		$file_groups = self::files_to_render('js', $group);

		$ret = '';

		foreach ($file_groups as $group_name => $file_group)
		{
			// We used to take $inline as 2nd argument. However, we now use a group option.
			// It ιs easiest if we let $inline override this group option, though.
			$inline = ($inline_dep === null) ? self::$groups['js'][$group_name]['inline'] : $inline_dep;

			// $attr is also deprecated. If specified, entirely overrides the group option.
			$attr = (!count($attr_dep)) ? self::$groups['js'][$group_name]['attr'] : $attr_dep;

			// the type attribute is not required for script elements under html5
			// @link http://www.w3.org/TR/html5/scripting-1.html#attr-script-type
			// if (!\Html::$html5)
			// 	$attr = array( 'type' => 'text/javascript' ) + $attr;

			if (self::$groups['js'][$group_name]['combine'])
			{
				$filename = self::combine('js', $file_group, self::$groups['js'][$group_name]['min'], $inline);

				if (!$inline && self::$show_files)
				{
					// $ret .= '<!--'.PHP_EOL.'Group: '.$group_name.PHP_EOL.implode('', array_map(function($a){
					// 	return "\t".$a['file'].PHP_EOL;
					// }, $file_group)).'-->'.PHP_EOL;

					// PHP 5.2 hack
					$bits = array();
					foreach ($file_group as $a)
					{
						$bits[] = "\t".$a['file'].PHP_EOL;
					}
					$ret .= '<!--'.PHP_EOL.'Group: '.$group_name.PHP_EOL.implode('', $bits).'-->'.PHP_EOL;
				}

				if ($inline)
				{
					$ret .= self::html_tag('script', $attr, PHP_EOL.file_get_contents(FCPATH.self::$cache_path.$filename).PHP_EOL).PHP_EOL;
				}
				else
				{
					$filepath = self::process_filepath(self::$cache_path.$filename, 'js');
					$ret .= self::html_tag('script', array(
						'src' => self::$asset_url.$filepath,
					) + $attr, '').PHP_EOL;
				}
			}
			else
			{
				foreach ($file_group as $file)
				{
					if ($inline)
					{
						$ret .= self::html_tag('script', $attr, PHP_EOL.file_get_contents($file['file']).PHP_EOL).PHP_EOL;
					}
					else
					{
						$remote = (strpos($file['file'], '//') !== false);
						$base = ($remote) ? '' : self::$asset_url;
						$filepath = self::process_filepath($file['file'], 'js', $remote);
						$ret .= self::html_tag('script', array(
							'src' => $base.$filepath,
						) + $attr, '').PHP_EOL;
					}
				}
			}
		}
		return $ret;
	}


	/**
	 * Renders the specific css group, or all groups if no group specified.
	 *
	 * @param bool|string $group Which group to render. If omitted renders all groups.
	 * @param null $inline_dep @deprecated If true, the result is printed inline.
	 *   If false, is written to a file and linked to. In fact, $inline = true also
	 *   causes a cache file to be written for speed purposes.
	 * @param array $attr_dep
	 *
	 * @return string The css tags to be written to the page.
	 */
	public static function render_css($group = false, $inline_dep = null, $attr_dep = array())
	{
		// Don't force the user to remember that false is used for ommitted non-bool arguments
		if (!is_string($group))
		{
			$group = false;
		}

		if (!is_array($attr_dep))
		{
			$attr_dep = array();
		}

		$file_groups = self::files_to_render('css', $group);

		$ret = '';

		foreach ($file_groups as $group_name => $file_group)
		{
			// We used to take $inline as 2nd argument. However, we now use a group option.
			// It's easiest if we let $inline override this group option, though.
			$inline = ($inline_dep === null) ? self::$groups['css'][$group_name]['inline'] : $inline_dep;

			// $attr is also deprecated. If specified, entirely overrides the group option.
			$attr = (!count($attr_dep)) ? self::$groups['css'][$group_name]['attr'] : $attr_dep;

			// the type attribute is not required for style or link[rel="stylesheet"] elements under html5
			// @link http://www.w3.org/TR/html5/links.html#link-type-stylesheet
			// @link http://www.w3.org/TR/html5/semantics.html#attr-style-type
			// if (!\Html::$html5)
			// 			$attr = array( 'type' => 'text/css' ) + $attr;

			if (self::$groups['css'][$group_name]['combine'])
			{
				$filename = self::combine('css', $file_group, self::$groups['css'][$group_name]['min'], $inline);

				if (!$inline && self::$show_files)
				{
					// $ret .= '<!--'.PHP_EOL.'Group: '.$group_name.PHP_EOL.implode('', array_map(function($a){
					// 	return "\t".$a['file'].PHP_EOL;
					// }, $file_group)).'-->'.PHP_EOL;

					// PHP 5.2 hack
					$bits = array();
					foreach ($file_group as $a)
					{
						$bits[] = "\t".$a['file'].PHP_EOL;
					}
					$ret .= '<!--'.PHP_EOL.'Group: '.$group_name.PHP_EOL.implode('', $bits).'-->'.PHP_EOL;
				}

				if ($inline)
				{
					$ret .= self::html_tag('style', $attr, PHP_EOL.file_get_contents(FCPATH.self::$cache_path.$filename).PHP_EOL).PHP_EOL;
				}
				else
				{
					$filepath = self::process_filepath(self::$cache_path.$filename, 'css');
					$ret .= self::html_tag('link', array(
						'rel' => 'stylesheet',
						'href' => self::$asset_url.$filepath,
					) + $attr).PHP_EOL;
				}
			}
			else
			{
				foreach ($file_group as $file)
				{
					if ($inline)
					{
						$ret .= self::html_tag('style', $attr, PHP_EOL.file_get_contents($file['file']).PHP_EOL).PHP_EOL;
					}
					else
					{
						$remote = (strpos($file['file'], '//') !== false);
						$base = ($remote) ? '' : self::$asset_url;
						$filepath = self::process_filepath($file['file'], 'css', $remote);
						$ret .= self::html_tag('link', array(
							'rel' => 'stylesheet',
							'href' => $base.$filepath,
						) + $attr).PHP_EOL;
					}
				}
			}
		}
		return $ret;
	}


	/**
	 * Figures out where a file should be, based on its namespace and type.
	 *
	 * @param string $file The name of the asset to search for.
	 * @param string $asset_type 'css', 'js' or 'img'
	 *
	 * @return array The paths to the assets, relative to $asset_url.
	 * @throws Asset_Exception
	 */
	protected static function find_files($file, $asset_type)
	{
		$parts = explode('::', $file, 2);

		if (!array_key_exists($parts[0], self::$asset_paths))
		{
			throw new Asset_Exception("Could not find namespace {$parts[0]}");
		}

		$path = self::$asset_paths[$parts[0]]['path'];
		$file = $parts[1];

		$folder = self::$asset_paths[$parts[0]]['dirs'][$asset_type];
		$file = ltrim($file, '/');

		$remote = (strpos($path, '//') !== false);

		if ($remote)
		{
			// Glob doesn't work on remote locations, so just assume they
			// specified a file, not a glob pattern.
			// Do not look for the file now either. That will be done
			// by file_get_contents() later on, if need be.
			return array($path.$folder.$file);
		}
		else
		{
			$glob_files = glob($path.$folder.$file);

			if (!$glob_files || !count($glob_files))
			{
				throw new Asset_Exception("Found no files matching $path$folder$file");
			}

			return $glob_files;
		}
	}


	/**
	 * Given a list of group names, adds to that list, in the appropriate places,
	 * and groups which are listed as dependencies of those group.
	 * Duplicate group names are not a problem, as a group is disabled when it's
	 * rendered.
	 *
	 * @param string $type 'js' or 'css'.
	 * @param array $group_names Array of group names to check.
	 * @param int $depth Used by this function to check for potentially infinite recursion.
	 *
	 * @return array List of group names with deps resolved.
	 * @throws Asset_Exception
	 */
	protected static function resolve_deps($type, $group_names, $depth = 0)
	{
		if ($depth > self::$deps_max_depth)
		{
			throw new Asset_Exception("Reached depth $depth trying to resolve dependencies. ".
				"You've probably got some circular ones involving ".implode(',', $group_names).". ".
				"If not, adjust the config key deps_max_depth.");
		}
		// Insert the dep just before what it's a dep for.
		foreach ($group_names as $i => $group_name)
		{
			// If the group has already been rendered, bottle.
			if (in_array($group_name, self::$rendered_groups[$type]))
			{
				continue;
			}

			// Do not pay attention to bottom-level groups which are disabled
			if (!self::$groups[$type][$group_name]['enabled'] && $depth == 0)
			{
				continue;
			}

			// Otherwise, enable the group. Fairly obvious, as the whole point of
			// deps is to render disabled groups
			self::asset_enabled($type, $group_name, true);

			if (count(self::$groups[$type][$group_name]['deps']))
			{
				array_splice($group_names, $i, 0, self::resolve_deps($type, self::$groups[$type][$group_name]['deps'], $depth + 1));
			}
		}
		return $group_names;
	}


	/**
	 * Determines the list of files to be rendered, along with whether they
	 * have been minified already.
	 *
	 * @param string $type 'css' / 'js'
	 * @param array $group The groups to render. If false, takes all groups
	 *
	 * @return array An array of array('file' => file_name, 'minified' => whether_minified)
	 */
	protected static function files_to_render($type, $group)
	{
		// If no group specified, print all groups.
		if ($group == false)
		{
			$group_names = array_keys(self::$groups[$type]);
		}
		// If a group was specified, but it does not exist.
		else
		{
			if (!array_key_exists($group, self::$groups[$type]))
			{
				return array();
			}

			$group_names = array($group);
		}

		$files = array();

		$minified = false;

		$group_names = self::resolve_deps($type, $group_names);

		foreach ($group_names as $group_name)
		{
			if (self::$groups[$type][$group_name]['enabled'] == false)
			{
				continue;
			}

			// If there are no files in the group, there's no point in printing it.
			if (count(self::$groups[$type][$group_name]['files']) == 0)
			{
				continue;
			}

			$files[$group_name] = array();

			// Mark the group as disabled to avoid the same group being printed twice
			self::asset_enabled($type, $group_name, false);

			// Add it to the list of rendered groups
			array_push(self::$rendered_groups[$type], $group_name);

			foreach (self::$groups[$type][$group_name]['files'] as $file_set)
			{
				if (self::$groups[$type][$group_name]['min'])
				{
					$assets = self::find_files(($file_set[1]) ? $file_set[1] : $file_set[0], $type);
					$minified = ($file_set[1] != false);
				}
				else
				{
					$assets = self::find_files($file_set[0], $type);
				}

				foreach ($assets as $file)
				{
					array_push($files[$group_name], array('file' => $file, 'minified' => $minified,));
				}
			}
		}
		return $files;
	}


	/**
	 * Used to load a file from disk.
	 *
	 * Also calls the post_load callback.
	 *
	 * @todo Document this function.
	 *
	 * @param string $filename
	 * @param string $type 'css' or 'js'
	 * @param string $file_group
	 *
	 * @return string
	 */
	protected static function load_file($filename, $type, $file_group)
	{
		$content = file_get_contents($filename);

		if (self::$post_load_callback != null)
		{
			// For some reason, PHP doesn't like you calling member closure directly
			$func = self::$post_load_callback;
			$content = $func($content, $filename, $type, $file_group);
		}
		return $content;
	}


	/**
	 * Takes a list of files, and combines them into a single minified file.
	 * Doesn't bother if none of the files have been modified since the cache
	 * file was written.
	 *
	 * @param string $type 'css' or 'js'.
	 * @param array $file_group Array of ('file' => filename, 'minified' => is_minified) to combine and minify.
	 * @param bool $minify Whether to minify the files, as well as combining them.
	 * @param $inline @todo Not used, document this
	 *
	 * @return string The path to the cache file which was written.
	 * @throws Asset_Exception
	 */
	protected static function combine($type, $file_group, $minify, $inline)
	{
		// Get the last modified time of all of the component files.
		$last_mod = 0;
		foreach ($file_group as $file)
		{
			// If it is a remote file just assume it is not modified,
			// otherwise we are stuck making a ton of HTTP requests.
			if (strpos($file['file'], '//') !== false)
			{
				continue;
			}

			$mod = filemtime(FCPATH.$file['file']);
			if ($mod > $last_mod)
			{
				$last_mod = $mod;
			}
		}

		// $filename = md5(implode('', array_map(function($a) {
		// 	return $a['file'];
		// }, $file_group)).($minify ? 'min' : '').$last_mod).'.'.$type;

		// PHP 5.2
		$bits = array();
		foreach ($file_group as $a)
		{
			$bits[] = $a['file'];
		}
		$filename = md5(implode('', $bits).($minify ? 'min' : '').$last_mod).'.'.$type;

		$filepath = FCPATH.self::$cache_path.'/'.$filename;
		$needs_update = (!file_exists($filepath));

		if ($needs_update)
		{
			$content = '';
			foreach ($file_group as $file)
			{
				if (self::$show_files_inline)
				{
					$content .= PHP_EOL.'/* '.$file['file'].' */'.PHP_EOL.PHP_EOL;
				}

				if ($file['minified'] || !$minify)
				{
					$content_temp = self::load_file($file['file'], $type, $file_group).PHP_EOL;

					if ($type == 'css')
					{
						$content .= Asset_Cssurirewriter::rewrite($content_temp, dirname($file['file']), null, self::$symlinks);
					}
					else
					{
						$content .= $content_temp;
					}
				}
				else
				{
					$file_content = self::load_file($file['file'], $type, $file_group);

					if ($file_content === false)
					{
						throw new Asset_Exception("Couldn't not open file {$file['file']}");
					}

					if ($type == 'js')
					{
						$content .= Asset_JSMin::minify($file_content).PHP_EOL;
					}
					elseif ($type == 'css')
					{
						$css = Asset_Csscompressor::process($file_content).PHP_EOL;
						$content .= Asset_Cssurirewriter::rewrite($css, dirname($file['file']), null, self::$symlinks);
					}
				}
			}
			file_put_contents($filepath, $content, LOCK_EX);
			$mtime = time(); // @todo Not used variable.
		}

		return $filename;
	}


	/**
	 * Renders the javascript added through js_inline().
	 *
	 * @return string The <script /> tags containing the inline javascript.
	 */
	public static function render_js_inline()
	{

		// the type attribute is not required for script elements under html5
		// @link http://www.w3.org/TR/html5/scripting-1.html#attr-script-type
		// if (!\Html::$html5)
		// 	$attr = array( 'type' => 'text/javascript' );
		// else
		$attr = array();

		$ret = '';

		foreach (self::$inline_assets['js'] as $content)
		{
			$ret .= self::html_tag('script', $attr, PHP_EOL.$content.PHP_EOL).PHP_EOL;
		}

		return $ret;
	}

	/**
	 * Renders the css added through css_inline().
	 *
	 * @return string The <style> tags containing the inline css
	 */
	public static function render_css_inline()
	{

		// the type attribute is not required for style elements under html5
		// @link http://www.w3.org/TR/html5/semantics.html#attr-style-type
		// if (!\Html::$html5)
		// 	$attr = array( 'type' => 'text/css' );
		// else
		$attr = array();

		$ret = '';

		foreach (self::$inline_assets['css'] as $content)
		{
			$ret .= self::html_tag('style', $attr, PHP_EOL.$content.PHP_EOL).PHP_EOL;
		}

		return $ret;
	}


	/**
	 * Sets the post_load file callback.
	 *
	 * It's pretty basic, and you're expected to handle
	 * e.g. filtering for the right file yourself.
	 *
	 * @param string $callback The name of the function for the callback.
	 */
	public static function set_post_load_callback($callback) {
		self::$post_load_callback = $callback;
	}


	/**
	 * Sets the filepath callback.
	 *
	 * @param string $callback The name of the function for the callback.
	 */
	public static function set_filepath_callback($callback) {
		self::$filepath_callback = $callback;
	}


	/**
	 * Locates the given image(s), and returns the resulting <img> tag.
	 *
	 * @param string|array $images Image or images to print.
	 * @param string $alt The alternate text.
	 * @param array $attr Attributes to apply to each image (e.g. width)
	 *
	 * @return string The resulting <img /> tag(s)
	 */
	public static function img($images, $alt, $attr = array())
	{
		if (!is_array($images))
		{
			$images = array($images);
		}
		$attr['alt'] = $alt;

		$ret = '';

		foreach ($images as $image)
		{
			if (strpos($image, '::') === false)
			{
				$image = self::$default_path_key.'::'.$image;
			}

			$image_paths = self::find_files($image, 'img');

			foreach ($image_paths as $image_path)
			{
				$remote = (strpos($image_path, '//') !== false);
				$image_path = self::process_filepath($image_path, 'img', $remote);
				$base = ($remote) ? '' : self::$asset_url;
				$attr['src'] = $base.$image_path;
				$ret .= self::html_tag('img', $attr);
			}
		}

		return $ret;
	}


	/**
	 * Clears all cache files last modified before $before.
	 *
	 * @param string $before Time before which to delete files.
	 *   Defaults to 'now'. Uses strtotime.
	 */
	public static function clear_cache($before = 'now')
	{
		self::clear_cache_base('*', $before);
	}


	/**
	 * Clears all JS cache files last modified before $before.
	 *
	 * @param string $before Time before which to delete files.
	 *   Defaults to 'now'. Uses strtotime.
	 */
	public static function clear_js_cache($before = 'now')
	{
		self::clear_cache_base('*.js', $before);
	}


	/**
	 * Clears CSS all cache files last modified before $before.
	 *
	 * @param string $before Time before which to delete files.
	 *   Defaults to 'now'. Uses strtotime.
	 */
	public static function clear_css_cache($before = 'now')
	{
		self::clear_cache_base('*.css', $before);
	}


	/**
	 * Base cache clear function.
	 *
	 * @param string $filter Glob filter to use when selecting files to delete.
	 * @param string $before Time before which to delete files.
	 *   Defaults to 'now'. Uses strtotime.
	 */
	protected static function clear_cache_base($filter = '*', $before = 'now')
	{
		$before = strtotime($before);
		$files = glob(FCPATH.self::$cache_path.$filter);
		foreach ($files as $file)
		{
			if (filemtime($file) < $before)
			{
				unlink($file);
			}
		}
	}

	/**
	 * Reset assets that have already been added in this request.
	 * This is useful when one module is planning to handle the 
	 * output but another then takes over (such as a 404 handler)
	 */
	public static function reset()
	{
		foreach (self::$groups as $type => $groups)
		{
			foreach ($groups as $group => $meta)
			{
				unset(self::$groups[$type][$group]);
			}
		}
	}

	/**
	 * Create a XHTML tag
	 *
	 * @param string $tag The tag name.
	 * @param string|array $attr The tag attributes.
	 * @param string|bool $content The content to place in the tag, or false for no closing tag.
	 *
	 * @return string
	 */
	protected static function html_tag($tag, $attr = array(), $content = false)
	{
		$has_content = (bool)($content !== false and $content !== null);
		$html = '<'.$tag;

		$html .= (!empty($attr)) ? ' '.(is_array($attr) ? self::array_to_attr($attr) : $attr) : '';
		$html .= $has_content ? '>' : ' />';
		$html .= $has_content ? $content.'</'.$tag.'>' : '';

		return $html;
	}


	/**
	 * Takes an array of attributes and turns it into a string for an html tag
	 *
	 * @param array $attr
	 *
	 * @return string
	 */
	protected static function array_to_attr($attr)
	{
		$attr_str = '';

		if (!is_array($attr))
		{
			$attr = (array)$attr;
		}

		foreach ($attr as $property => $value)
		{
			// Ignore null values
			if (is_null($value))
			{
				continue;
			}

			// If the key is numeric then it must be something like selected="selected"
			if (is_numeric($property))
			{
				$property = $value;
			}

			$attr_str .= $property . '="' . $value . '" ';
		}

		// We strip off the last space for return
		return trim($attr_str);
	}
}

/* End of file asset.php */