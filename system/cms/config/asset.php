<?php

/**
 * An array of paths that will be searched for assets.
 * Each path is assigned a name, which is used when referring to that asset.
 * See the js() and css() docs for more info.
 * Each asset is a RELATIVE path from the base_url WITH a trailing slash.
 * There must be an entry with the key 'core'. This is used when no path
 * is specified.
 *
 * array(
 *		'core' => 'assets/'
 * )
 *
 * You can also choose to override the js_dir, css_dir and/or img_dir config
 * options on a per-path basis. You can override just one dir, two, or all
 * of them.
 * In this case, the syntax is
 * array (
 *		'some_key' => array(
 *			'path' => 'more_assets/',
 *			'js_dir' => 'javascript/',
 *			'css_dir' => 'styles/'
 *			'img_dir' => 'images/',
 *		),
 * )
 */
	$config['asset_paths'] = array(
		'core' => 'assets/',
	);

/**
 * Asset Sub-folders
 *
 * Names for the js and css folders (inside the asset path).
 *
 * Examples:
 *
 * js/
 * css/
 * img/
 *
 * This MUST include the trailing slash ('/')
 */
$config['asset_js_dir'] = 'js/';
$config['asset_css_dir'] = 'css/';
$config['asset_img_dir'] = 'img/';

/**
 * When minifying, the minified, combined files are cached.
 * This value specifies the location of those files, relative to public/
 *
 * This MUST include the trailing slash ('/')
 */
$config['asset_cache_path'] = 'assets/cache/';

/**
 * Note the following with regards to combining / minifying files:
 * Combine and minify:
 *   Files are minified (or the minified form used, if given), and combined
 *   into a single cache file.
 * Combine and not minify:
 *   Non-minified versions of files are combined into a single cache file.
 * Not combine and minify:
 *   Minified versions of files are linked to, if given. Otherwise the non-
 *   minified versions are linked to.
 *   NOTE THIS IS POTENTIALLY UNEXPECTED BEHAVIOUR, but makes sense when you
 *   take remote assets into account.
 * Not combine and not minify:
 *   Non-minified versions of files are linked to.
 */

/**
 * Whether to minify files.
 */
$config['asset_min'] = (ENVIRONMENT !== PYRO_DEVELOPMENT);

/**
 * Whether to combine files
 */
$config['asset_combine'] = (ENVIRONMENT !== PYRO_DEVELOPMENT);

/**
 * When minifying, whether to show the files names in each combined
 * file in a comment before the tag to the file.
 */
$config['asset_show_files'] = false;

/**
 * When minifying, whether to put comments in each minified file showing
 * the origin location of each part of the file.
 */
$config['asset_show_files_inline'] = false;

/**
 * How deep to go when resolving deps, before assuming that there're some
 * circular ones.
 */
$config['asset_deps_max_depth'] = 2;

/**
 * Here you can define a callback that is called after a while is loaded from
 * disk, and before it is stored in a cache file.
 * This set of circumstances only occurs when 'combine' is true -- the callback
 * will *not* be called if 'combine' is false.
 *
 * This parameter expects a closure (or other function reference), with the
 * following prototype:
 * function($content, $filename, $type, $group_name)
 * and should return the content after being processed.
 * $content = the file content which casset has loaded from file
 * $filename = the name of the file casset has loaded
 * $type = 'js' or 'css'
 * $group_name = the name of the group to which the file belongs
 *
 * You are allowed to define functions in this config file, or you can use
 * Asset::set_post_load_callback(function($content,  ...) { ... }); instead
 */
$config['asset_post_load_callback'] = null;

/**
 * Groups of scripts.
 * You can predefine groups of js and css scripts which can be enabled/disabled
 * and rendered.
 * There isn't much flexibility in this syntax, and no error-checking is performed,
 * so please be careful!
 *
 * The groups array follows the following structure:
 * array(
 *    'js' => array(
 *       'group_name' => array(
 *          'files' => array(
 *             array('file1.js', 'file1.min.js'),
 *             'file2.js'
 *          ),
 *          'enabled' => true,
 *          'min' => false,
 *       ),
 *       'group_name_2' => array(.....),
 *    ),
 *    'css' => aarray(
 *       'group_name' => array(
 *          'files' => array(
 *             array('file1.css', 'file1.min.css'),
 *             'file2.css',
 *          ),
 *          'enabled' => true,
 *			'deps' => array('some_other_group'),
 *       ),
 *       'group_name_2' => array(.....),
 *    ),
 * ),
 *
 * - 'js' and 'css' are special keys, used by functions like render_js and
 *    render_css. Either can happily be omitted.
 * - 'group_name' is a user-defined group name. Files can be added to a
 *    particular group using the third argument of css() or js().
 *    Similarly, individual groups can be rendered by passing the group
 *    name to render_css() or render_js().
 *    Another point to note is that each group is minified into its own
 *    distinct cache file. This is a compromise between allowing the
 *    browser to cache files, and flooding it with too many files.
 * - 'files' is a list of the files present in the group.
 *    Each file can either be defined by a string, or by an array of 2 elements.
 *    If the string form is used, the file will be minified using an internal
 *    library when 'min' = true.
 *    If the array form is used, the second element in the array is used
 *    when 'min' = true. This is useful when a library also provided a minified
 *    version of itself (eg jquery).
 * - 'enabled': whether the group will be rendered when render_css() or
 *    render_js() is called.
 * - 'min: an optional key, allowing you to override the global 'min' config
 *    key on a per-group basis. If null or not specified, the 'min' config
 *    key will be used.
 *    Using this,
 * - 'deps': an optional key, allowing you to specify other groups
 *    which are automatically rendered when this group is. See the readme
 *    for more details.
 */
$config['asset_groups'] = array();

/*
 * If a CSS/JS file or images (and other ressources) used inside an CSS/JS
 * file is stored in a symlink-ed directory,
 * you have to provide an array of link paths to target paths, where the link
 * paths are within the document root.
 * Because paths need to be normalized for this to work, use "//" to substitute the
 * doc root in the link paths (the array keys). E.g.:
 * array('//symlink' => '/real/target/path') // unix
 * array('//static' => 'D:\\staticStorage')  // Windows
*/
$config['asset_symlinks'] = array();


/* End of file config/asset.php */