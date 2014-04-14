<?php namespace Pyro\Module\Streams\FieldType;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Str;

/**
 * PyroStreams Core Field Type Library
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Libraries
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class FieldTypeManager
{
    /**
     * We build up these assets for the footer
     *
     * @var        array
     */
    protected static $assets = array();

    /**
     * Places where our field types may be
     *
     * @var        array
     */
    protected static $addon_paths = array();

    /**
     * Core addon path
     *
     * @var [type]
     */
    protected static $core_addon_path;

    /**
     * Available field types
     *
     * @var array
     */
    protected static $types = array();

    /**
     * The registry of field types - field_slug => class
     *
     * @var array
     */
    protected static $slug_classes = array();

    /**
     * Has the class being initiated
     *
     * @var object
     */
    protected static $initiated = false;

    /**
     * Set addon path
     *
     * @param string $key
     * @param string $path
     */
    public static function setAddonPath($key, $path)
    {
        static::$addon_paths[$key] = $path;
    }

    /**
     * Get classes
     *
     * @return array
     */
    public static function getClasses()
    {
        return static::$slug_classes;
    }

    /**
     * Load crud assets for all field crud assets
     *
     * @return    void
     */
    public static function loadFieldCrudAssets($types = array())
    {
        if (empty($types)) {
            $types = static::getAllTypes();
        }

        foreach ($types as $type) {
            if (method_exists($type, 'add_edit_field_assets')) {
                $type->add_edit_field_assets();
            }
        }
    }

    /**
     * Get all field types
     *
     * @return array
     */
    public static function getAllTypes()
    {
        static::preload();

        return new FieldTypeCollection(static::$types);
    }

    /**
     * Get the types together as a big object
     *
     * @return    void
     */
    public static function preload()
    {
        static::registerFolderFieldTypes(static::$core_addon_path . 'field_types/', true, true, 'core');

        static::registerAddonFieldTypes(true);
    }

    /**
     * Register folder field types
     *
     * @param  string  $folder
     * @param  array   $types
     * @param  boolean $preload
     *
     * @return void
     */
    public static function registerFolderFieldTypes($folder, $types = array(), $preload = false, $mode = 'add_on')
    {
        static::init();

        if (is_string($types)) {
            $types = array($types);
        }

        if ($types === true) {
            $types = directory_map($folder, 1);
        }

        if (is_array($types) and !empty($types)) {
            $loader = new ClassLoader;

            foreach ($types as $key => &$type) {
                $type = basename($type);

                if ($type == 'index.html') {
                    unset($types[$key]);

                    continue;
                }

                static::registerSlugClass($type);

                $loader->add(static::getClass($type), $folder . $type . '/src/');
            }

            $loader->register();

            if ($preload) {
                foreach ($types as $_type) {
                    static::getType($_type, $mode);
                }
            }
        }
    }

    /**
     * Get instance (singleton)
     *
     * @return [type] [description]
     */
    public static function init()
    {
        if (!static::$initiated) {
            ci()->load->helper('directory');
            ci()->load->language('streams_core/pyrostreams');
            ci()->load->config('streams_core/streams');

            // Get Lang (full name for language file)
            // This defaults to english.
            $langs = ci()->config->item('supported_languages');

            // Needed for installer
            if (!class_exists('Settings')) {
                ci()->load->library('settings/Settings');
            }

            // Since this is PyroStreams core we know where
            // PyroStreams is, but we set this for backwards
            // compatability for anyone using this constant.
            // Also, now that the Streams API is around, we need to
            // check if we need to change this based on the
            // install situation.
            if (defined('PYROPATH')) {
                static::$core_addon_path = PYROPATH . 'modules/streams_core/';
            } else {
                static::$core_addon_path = APPPATH . 'modules/streams_core/';
            }

            // Set our addon paths
            static::$addon_paths = array(
                'addon'     => ADDONPATH . 'field_types/',
                'addon_alt' => SHARED_ADDONPATH . 'field_types/'
            );

            // Add addon paths event. This is an opportunity to
            // add another place for addons.
            if (!class_exists('Module_import')) {
                \Events::trigger('streams_core_add_addon_path');
            }
        }

        static::$initiated = true;
    }

    /**
     * Register slug class
     *
     * @param  array
     *
     * @return void
     */
    public static function registerSlugClass($types = array())
    {
        if (is_string($types)) {
            $types = array($types);
        }

        if (is_array($types)) {
            foreach ($types as $type) {
                static::$slug_classes[$type] = static::getClass($type);
            }
        }
    }

    /**
     * Get class
     *
     * @param  string $type
     *
     * @return string
     */
    public static function getClass($type)
    {
        return 'Pyro\\FieldType\\' . Str::studly($type);
    }

    /**
     * Get type
     *
     * @param  string  $type
     * @param  boolean $gather_types
     *
     * @return object
     */
    public static function getType($type = null, $mode = null)
    {
        if (!empty(static::$types[$type]) and is_object(static::$types[$type])) {
            return static::$types[$type];
        } else {
            return static::loadType($type, $mode);
        }
    }

    private static function loadType($type, $mode = 'add_on')
    {
        if (empty($type) or empty(static::$slug_classes[$type])) {
            return null;
        }

        $class = static::getClass($type);

        $instance = new $class;

        $reflection = new \ReflectionClass($instance);

        // Field Type class folder location
        $class_path = dirname($reflection->getFileName());

        // The root path of the field type
        $path = str_replace(FCPATH, '', dirname(dirname(dirname($class_path))));

        if (!$instance->field_type_mode) {
            $instance->field_type_mode = $mode;
        }

        // Set asset paths
        $instance->path       = $path;
        $instance->path_views = $path . '/views/';
        $instance->path_img   = $path . '/img/';
        $instance->path_css   = $path . '/css/';
        $instance->path_js    = $path . '/js/';

        // -------------------------
        // Load the language file
        // -------------------------
        if (is_dir($path)) {
            $lang = ci()->config->item('language');

            // Fallback on English.
            if (!$lang) {
                $lang = 'english';
            }

            if (!is_dir($path . $lang)) {
                $lang = 'english';
            }

            ci()->lang->load($type . '_lang', $lang, false, false, $path . '/');

            unset($lang);
        }

        // Field type name is languagized
        if (!isset($instance->field_type_name)) {
            $instance->field_type_name = lang('streams:' . $type . '.name');
        }

        if (isset(ci()->profiler)) {
            ci()->profiler->log->info($class . ' loaded');
        }

        return static::$types[$type] = $instance;
    }

    /**
     * Load the actual field type into the
     * types object
     *
     * @param    string - addon path
     * @param    string - path to the file (with the file name)
     * @param    string - the field type
     * @param    string - mode
     *
     * @return    obj - the type obj
     */
    // $path, $file, $type, $mode

    /**
     * Register addon field types
     *
     * @param  boolean $preload
     *
     * @return void
     */
    public static function registerAddonFieldTypes($preload = false)
    {
        foreach (static::getAddonPaths() as $key => $path) {

            static::registerFolderFieldTypes($path, true, $preload);
        }
    }

    /**
     * Get addon paths
     *
     * @return array
     */
    public static function getAddonPaths()
    {
        return static::$addon_paths;
    }

    /**
     * Get our build params
     *
     * Accessed via AJAX
     *
     * @return    void
     */
    public static function buildParameters($type = null, $namespace = null, $current_field = null)
    {
        // Out for certain characters
        if ($type == '-') {
            return null;
        }

        $value = null;

        $field_data = array();

        // Load paramaters
        $parameters = new FieldTypeParameter;

        // Load the proper class
        if (!$field_type = static::getType($type)) {
            return null;
        }

        // I guess we don't have any to show.

        $field_type->setField($current_field);

        // Otherwise, the beat goes on.
        $data['count'] = 0;
        $output        = '';

        //Echo them out
        foreach ($field_type->getCustomParameters() as $param) {
            $custom_param = Str::studly('param_' . $param);

            if (!isset($_POST[$param]) and $current_field) {
                if (isset($current_field->field_data[$param])) {
                    $value = $current_field->field_data[$param];
                } else {
                    $value = null;
                }
            }

            // Check to see if it is a standard one or a custom one
            // from the field type
            // custom ones go first to allow overriding defauts
            if (method_exists($field_type, $custom_param)) {
                $input = $field_type->$custom_param($value, $namespace);

                if (is_array($input)) {
                    $data['input']        = $input['input'];
                    $data['instructions'] = $input['instructions'];
                } else {
                    $data['input']        = $input;
                    $data['instructions'] = null;
                }
            } elseif (method_exists($parameters, $param)) {
                $data['input'] = $parameters->$param($value);
            }

            if (method_exists($parameters, $param)) {
                $data['input_name'] = lang('streams:' . $param);
            } else {
                $data['input_name'] = lang('streams:' . $field_type->field_type_slug . '.' . $param);
            }

            $data['input_slug'] = $param;

            $output .= ci()->load->view('streams_core/fields/parameter', $data, true);

            $data['count']++;
        }

        return $output;
    }
}
