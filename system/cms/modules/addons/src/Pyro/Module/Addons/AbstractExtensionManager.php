<?php namespace Pyro\Module\Addons;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Str;

/**
 * PyroStreams Core Field Extension Library
 *
 * @package		PyroCMS\Core\Modules\Addons
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
abstract class AbstractExtensionManager
{
    /**
     * The modules we're loading extensions from
     * @var string
     */
    protected static $modules = array();

    /**
     * The slugs of extensions found
     * @var string
     */
    protected static $slugs = array();

    /**
     * Places where our extensions may be
     *
     * @var		array
     */
    protected static $addonPaths = array();

    /**
     * Modules where dashboards may be
     *
     * @var		array
     */
    protected static $modulePaths = array();

    /**
     * Core addon path
     * @var [extension]
     */
    protected static $coreAddonPath;

    /**
     * Available extensions
     * @var array
     */
    protected static $extensions = array();

    /**
     * The registry of extensions
     * @var array
     */
    protected static $extensionClasses = array();

    /**
     * Has the classes being initiated
     * @var arry
     */
    protected static $initiated = array();

    /**
     * Collection class
     *
     * @var string
     */
    protected static $collectionClass = 'Pyro\Module\Addons\ExtensionCollection';

    /**
     * Get instance (singleton)
     * @return [extension] [description]
     */
    public static function init($module, $slug, $preload = false)
    {
        $instance = new static;

        if (! isset(static::$initiated[get_called_class()])) {
            ci()->load->helper('directory');
            ci()->load->language($module.'/'.$module);

            // Get Lang (full name for language file)
            // This defaults to english.
            $langs = ci()->config->item('supported_languages');

            // Set the module, slug, paths and extensions
            static::$modules[get_called_class()] = $module;
            static::$slugs[get_called_class()] = $slug;
            static::$modulePaths[get_called_class()] = array();
            static::$extensions[get_called_class()] = array();

            $extensionPath = $instance::getExtensionPath($module, $slug);

            // Needed for installer
            if ( ! class_exists('Settings')) {
                ci()->load->library('settings/Settings');
            }

            // Set our addon paths
            static::$addonPaths[get_called_class()] = array(
                'addon' 		=> ADDONPATH.$extensionPath,
                'addon_alt' 	=> SHARED_ADDONPATH.$extensionPath,
            );

            // Set module paths
            $modules = new ModuleManager;

            foreach ($modules->getAllEnabled() as $enabledModule) {
                if (is_dir($enabledModule['path'].'/'.$extensionPath)) {
                    static::$modulePaths[get_called_class()][$enabledModule['slug']] = $enabledModule['path'].'/'.$extensionPath;
                }
            }

            // Preload?
            if ($preload) {
                self::preload();
            }
        }

        static::$initiated[get_called_class()] = true;
    }

    /**
     * Get the extension path as it appears
     * after the addon / module path
     * @param  string $module
     * @param  string $slug
     * @return string
     */
    protected static function getExtensionPath($module, $slug)
    {
        return 'extensions/'.$module.'/'.$slug.'/';
    }

    /**
     * Set addon path
     * @param string $key
     * @param string $path
     */
    public static function setAddonPath($key, $path)
    {
        static::$addonPaths[get_called_class()][$key] = $path;
    }

    /**
     * Set module path
     * @param string $key
     * @param string $path
     */
    public static function setModulePath($key, $path)
    {
        static::$modulePaths[get_called_class()][$key] = $path;
    }

    /**
     * Get addon paths
     * @return array
     */
    public static function getAddonPaths()
    {
        return static::$addonPaths[get_called_class()];
    }

    /**
     * Get module paths
     * @return array
     */
    public static function getModulePaths()
    {
        return static::$modulePaths[get_called_class()];
    }

    /**
     * Get extension
     * @param  string  $extension
     * @param  boolean $gather_extensions
     * @return object
     */
    public static function getExtension($extension = null)
    {
        if (! empty(static::$extensions[get_called_class()][$extension]) and is_object(static::$extensions[get_called_class()][$extension])) {
            $extension = static::$extensions[get_called_class()][$extension];
        } else {
            $extension = static::loadExtension($extension);
        }

        // Remove where user does not have permission
        if ($extension->module) {
            $permissionModule = $extension->module;
        } else {
            $permissionModule = isset(ci()->module_details['slug']) ? ci()->module_details['slug'] : null;
        }

        if ($extension and $extension->role and $permission = $permissionModule . '.' . $extension->role) {
            if (ci()->current_user->hasAccess($permission)) {
                return $extension;
            }
        } else {
            return $extension;
        }

        return null;
    }

    /**
     * Register slug class
     * @param  array
     * @return void
     */
    public static function registerSlugClass($extensions = array())
    {
        if (is_string($extensions)) {
            $extensions = array($extensions);
        }

        if (is_array($extensions)) {
            foreach ($extensions as $extension) {
                static::$extensionClasses[get_called_class()][$extension] = static::getClass($extension);
            }
        }
    }

    /**
     * Register folder extensions
     * @param  string  $folder
     * @param  array   $extensions
     * @param  boolean $preload
     * @return void
     */
    public static function registerFolderExtensions($folder, $extensions = array(), $preload = false)
    {
        static::init(static::$modules[get_called_class()], static::$slugs[get_called_class()]);

        if (is_string($extensions)) {
            $extensions = array($extensions);
        }

        if ($extensions === true) {
            $extensions = directory_map($folder, 1);
        }

        if (is_array($extensions) and ! empty($extensions)) {

            $loader = new ClassLoader;

            foreach ($extensions as $key => &$extension) {

                $extension = basename($extension);

                if ($extension == 'index.html') {
                    unset($extensions[$key]);

                    continue;
                }

                static::registerSlugClass($extension);

                $loader->add(static::getClass($extension), $folder.$extension.'/src/');
            }

            $loader->register();

            if ($preload) {
                foreach ($extensions as $preload_extension) {
                    static::getExtension($preload_extension);
                }
            }
        }
    }

    /**
     * Register addon extensions
     * @param  boolean $preload
     * @return void
     */
    public static function registerExtensions($preload = false)
    {
        foreach (static::getAddonPaths() as $key => $path) {
            static::registerFolderExtensions($path, true, $preload);
        }
    }

    /**
     * Register module extensions
     * @param  boolean $preload
     * @return void
     */
    public static function registerModuleExtensions($preload = false)
    {
        foreach (static::getModulePaths() as $key => $path) {
            static::registerFolderExtensions($path, true, $preload);
        }
    }

    /**
     * Get class
     * @param  string $extension
     * @return string
     */
    public static function getClass($extension)
    {
        $class = static::getClassBase($extension);
        $class .= static::getClassPath($extension);
        $class .= '\\'.Str::studly($extension);
        $class .= static::getClassSuffix($extension);

        return $class;
    }

    /**
     * Get base of class path
     * @param  string $extension
     * @return string
     */
    public static function getClassBase($extension)
    {
        return 'Pyro\\Module\\'.Str::studly(static::$modules[get_called_class()]).'\\Extension';
    }

    /**
     * Get class path
     * @param  string $extension
     * @return string
     */
    public static function getClassPath($extension)
    {
        $path = '\\'.Str::studly(static::$slugs[get_called_class()]);

        return $path;
    }

    /**
     * Get class suffix
     * @param  string $extension
     * @return string
     */
    public static function getClassSuffix($extension)
    {
        return null;
    }

    /**
     * Get classes
     * @return array
     */
    public static function getClasses()
    {
        return static::$extensionClasses[get_called_class()];
    }

    /**
     * Get all extensions
     * @return array
     */
    public static function getAllExtensions($module = null, $extension = null)
    {
        if ($module and $extension) {
            static::init($module, $extension, true);
        }

        static::preload();

        return new static::$collectionClass(static::$extensions[get_called_class()]);
    }

    /**
     * Get registered extensions
     * @return array
     */
    public static function getRegisteredExtensions()
    {
        return new static::$collectionClass(static::$extensions[get_called_class()]);
    }

    /**
     * Get the extensions together as a big object
     *
     * @return	void
     */
    public static function preload()
    {
        static::registerFolderExtensions(static::$coreAddonPath.'extensions/', true, true);

        static::registerExtensions(true);

        static::registerModuleExtensions(true);
    }

    /**
     * Load the actual extension into the
     * extensions object
     *
     * @param	string - addon path
     * @param	string - path to the file (with the file name)
     * @param	string - the extension
     * @param	string - mode
     * @return	obj - the extension obj
     */
    // $path, $file, $extension, $mode
    private static function loadExtension($extension)
    {
        if (empty($extension) or empty(static::$extensionClasses[get_called_class()][$extension])) return null;

        $class = static::getClass($extension);

        $instance = new $class;

        if ($instance->module and !module_installed($instance->module)) {
            return false;
        }

        $type = static::$slugs[get_called_class()];

        $reflection = new \ReflectionClass($instance);

        // Field Extension class folder location
        $class_path = dirname($reflection->getFileName());

        /**
         * Determine the root path for
         * loading assets n what not
         * We'll start here and walk backwards
         */
        $path = str_replace(FCPATH, '', dirname($class_path));

        for ($x=1;$x<10;$x++) {
            $parts = explode('/', $path);

            if (end($parts) == $extension) {
                break;
            } else {
                $path = dirname($path);
            }
        }

        // Set asset paths
        $instance->path = $path;
        $instance->pathViews = $path.'/views/';
        $instance->pathImg = $path.'/img/';
        $instance->pathCss = $path.'/css/';
        $instance->pathJs = $path.'/js/';

        // -------------------------
        // Load the language file
        // -------------------------
        $instance->langPrefix = static::getLangPrefix($extension);

        if (is_dir($path) and is_dir($path.'/language')) {

            $lang = ci()->config->item('language');

            // Fallback on English.
            if ( ! $lang) {
                $lang = 'english';
            }

            if ( ! is_dir($path.$lang)) {
                $lang = 'english';
            }

            ci()->lang->load(static::getLangFilename($extension, $type), $lang, false, false, $path.'/');

            unset($lang);
        }

        // Extension name is languagized
        if ( ! isset($instance->name)) {
            $instance->name = lang_label('lang:'.$instance->langPrefix.'.name');
        }

        // Extension description is languagized
        if ( ! isset($instance->description)) {
            $instance->description = lang_label('lang:'.$instance->langPrefix.'.description');
        }

        if (isset(ci()->profiler)) {
            ci()->profiler->log->info($class.' loaded');
        }

        // Set the extension type
        // This is helpful when same name extensions
        // have different purposes and therefore are a
        // different extension type
        // Example:
        //  - contact (extension) information (type)
        //  - contact (extension) form (type)
        $instance->type = $type;

        // We're loaded
        $instance->loaded();

        return static::$extensions[get_called_class()][$extension] = $instance;
    }

    /**
     * Get the prefix string of the lang key
     * @return string
     */
    public static function getLangPrefix($extension)
    {
        return 'extension.'.static::$slugs[get_called_class()].'.'.$extension;
    }

    /**
     * Get the filename of the extensions lang file
     * @param  string $extension
     * @param  string $type
     * @return string
     */
    public static function getLangFilename($extension, $type)
    {
        return $extension.'_'.static::$slugs[get_called_class()].'_lang';
    }
}
