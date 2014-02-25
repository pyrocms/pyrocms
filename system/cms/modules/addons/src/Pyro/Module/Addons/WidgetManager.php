<?php namespace Pyro\Module\Addons;

/**
 * Widget Manager
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.WidgetManager.html
 */
class WidgetManager
{
    /**
     * Cache of rendered widget areas (html)
     *
     * @var array
     */
    protected $rendered_areas = array();

    /**
     * Theme Locations
     *
     * @var array
     */
    protected $locations = array();

    /**
     * Locations where widget files are located
     *
     * @var array
     */
    protected $located_widgets = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->widgets = new WidgetModel;
        $this->widgetInstances = new WidgetInstanceModel;
        $this->widgetAreas = new WidgetAreaModel;
    }

    /**
     * Set Locations
     */
    public function setLocations(array $locations)
    {
        $this->locations = $locations;
    }

    /**
     * Get the widget model
     *
     * @return Pyro\Module\Addons\WidgetModel
     */
    public function getModel()
    {
        return $this->widgets;
    }

    /**
     * Get the widget area model
     *
     * @return Pyro\Module\Addons\WidgetInstanceModel
     */
    public function getAreaModel()
    {
        return $this->widgetAreas;
    }

    /**
     * Get the widget instance model
     *
     * @return Pyro\Module\Addons\WidgetInstanceModel
     */
    public function getInstanceModel()
    {
        return $this->widgetInstances;
    }

    /**
     * Go on a hunting trip, to see where the Widgets live
     *
     * @return  array
     */
    public function locatePaths() //$params = null, $return_disabled = true
    {
        $all_widgets = array();

        // Map where all widgets are
        foreach ($this->locations as $location) {
            $widgets = glob($location.'*', GLOB_ONLYDIR);

            if (is_array($widgets) and count($widgets) > 0) {
                $all_widgets = array_merge($all_widgets, $widgets);
            }

            $module_widgets = glob(dirname($location).'modules/*/widgets/*', GLOB_ONLYDIR);

            if ( ! is_array($module_widgets)) {
                $all_widgets = array_merge($all_widgets, $module_widgets);
            }
        }

        return $all_widgets;
    }

    /**
     * Return an array of objects containing widget related data
     *
     * @param   array   $params             The array containing the modules to load
     * @param   bool    $return_disabled    Whether to return disabled modules
     * @return  array
     */
    public function getAll($params = null, $return_disabled = true)
    {
        $available = $this->locatePaths();

        return array_map(function($location) {

            $slug = pathinfo($location, PATHINFO_BASENAME);

            return $this->spawnClass($location, $slug);

        }, $available);
    }

    /**
     * Automatically install any uninstalled widgets
     *
     * @return array
     */
    public function registerUnavailableWidgets()
    {
        $installed = $this->widgets->findAllInstalled()->map(function($widget) {
            return $widget->slug;
        })->toArray();

        foreach ($this->locatePaths() as $location) {

            $slug = basename($location);

            if (! in_array($slug, $installed)) {
                $widget = $this->spawnClass(dirname($location), $slug);

                if ($widget !== false and $widget instanceof WidgetAbstract) {
                    $this->register($widget, $slug);
                }
            }
        }
    }

    /**
     * Read a theme from the file system and save it to the DB
     *
     * @param WidgetAbstract $theme Theme info instance
     * @param string $slug The folder name of the theme
     *
     * @return  Pyro\Addons\WidgetModel
     */
    public function register(WidgetAbstract $widget, $slug)
    {
        return $this->widgets->create(array(
            'slug'              => $slug,
            // Title is deprecated, remove in 3.0. Name is new
            'name'              => isset($widget->title) ? $widget->title : $widget->name,
            'author'            => $widget->author,
            'author_website'    => isset($widget->author_website) ? $widget->author_website : null,
            'website'           => $widget->website,
            'description'       => $widget->description,
            'version'           => $widget->version,
        ));
    }

    /**
     * Spawn a widget and get some basic information back, such as the module
     * and wether its an addon or not
     *
     * <code>
     * echo $this->widgets->get($id);
     * </code>
     *
     * @param  int    $slug
     * @return object stdObject
     */
    public function get($slug)
    {
        foreach ($this->locations as $location) {
            $widget = $this->spawnClass($location, $slug);

            if ($widget !== false and $widget instanceof WidgetAbstract) {
                break;
            }
        }

        if (empty($widget)) {
            return false;
        }

        $widget->slug = $slug;
        $widget->module = strpos($widget->path, 'modules/') ? basename(dirname($widget->path)) : null;
        $widget->is_addon = strpos($widget->path, 'system/') === false;

        return $widget;
    }

    /**
     * Display the actual widget HTML based on slug and options provided
     *
     * <code>
     * echo $this->widgets->render('rss_feed', array('feed_url' => 'http://philsturgeon.co.uk/blog/feed.rss'));
     * </code>
     *
     * @param  int    $slug     Widget
     * @param  array  $options  Options (data saved in the DB or provided on-the-fly)
     * @return string
     */
    public function render(WidgetAbstract $widget, WidgetInstanceModel $instance = null)
    {
        $options = $instance ? $instance->options : array();
        $data = method_exists($widget, 'run') ? call_user_func(array($widget, 'run'), $options) : array();

        // BAIL
        if ($data === false) {
            return false;

        // If we have true, just make an empty array
        } elseif ($data === true) {
            $data = array();

        // Make sure its an array
        } elseif (! is_array($data)) {
            $data = (array) $data;
        }

        $data['options'] = $options;

        return $this->loadView('display', $widget, $data);
    }

    /**
     * Display the widget form for the Control Panel
     *
     * @param  WidgetAbstract       $slug       Widget class
     * @param  WidgetInstanceModel  $instance   Widget instance contains existing options
     * @return string
     */
    public function renderBackend(WidgetAbstract $widget, WidgetInstanceModel $instance = null)
    {
        // No fields, no backend, no rendering
        if (empty($widget->fields)) {
            return '';
        }

        $options = $_arrays = array();

        foreach ($widget->fields as $field) {
            $field_name = &$field['field'];
            if (($pos = strpos($field_name, '[')) !== false) {
                $key = substr($field_name, 0, $pos);

                if (! in_array($key, $_arrays)) {
                    $options[$key] = $this->input->post($key);
                    $_arrays[] = $key;
                }
            }
            $options[$field_name] = set_value($field_name, isset($instance->options[$field_name]) ? $instance->options[$field_name] : '');
        }

        // Check for default data if there is any
        $data = method_exists($widget, 'form') ? call_user_func(array(&$widget, 'form'), $options) : array();

        // Options weren't changed, lets use the defaults
        if (! isset($data['options'])) {
            $data['options'] = $options;
        }

        return $this->loadView('form', $widget, $data);
    }

    /**
     * Display the widget area HTML
     *
     * <code>
     * echo $this->widgets->renderArea('sidebar');
     * </code>
     *
     * @param  string $short_name Widget area short name
     * @return string
     */
    public function renderArea($short_name)
    {
        if (isset($this->rendered_areas[$short_name])) {
            return $this->rendered_areas[$short_name];
        }

        // HACK: Let's get this out of here somehow
        $view = ($short_name === 'dashboard') ? 'admin/widget_wrapper' : 'widget_wrapper';

        // HACK: Less reliance on global code
        $path = ci()->template->get_views_path().'modules/widgets/';

        if (! file_exists($path.$view.'.php')) {
            list($path, $view) = \Modules::find($view, 'widgets', 'views/');
        }

        // save the existing view array so we can restore it
        $save_path = ci()->load->get_view_paths();

        $area = $this->widgetAreas->findBySlugWithInstances($short_name);

        if (is_null($area) or ! $area->instances) {
            return '';
        }

        $output = '';
        foreach ($area->instances as $instance) {

            // If this widget is disabled then skip it
            if ( ! $instance->widget->enabled) {
                continue;
            }

            // Widget
            $widget_class = $this->get($instance->widget->slug);

            if ($widget_class === false) {
                continue;
            }

            $instance->body = $this->render($widget_class, $instance);

            // add this view location to the array
            ci()->load->set_view_path($path);

            $output .= ci()->load->_ci_load(array(
                '_ci_view' => $view,
                '_ci_vars' => compact('widget_class', 'instance'),
                '_ci_return' => true
            ))."\n";

            // Put the old array back
            ci()->load->set_view_path($save_path);
        }

        $this->rendered_areas[$short_name] = $output;

        return $output;
    }

    public function reload_widget($slug)
    {
        if (is_array($slug)) {
            foreach ($slug as $_slug) {
                if ( ! $this->reload_widget($_slug)) {
                    return false;
                }
            }
            return true;
        }

        $widget = $this->spawnClass($slug);

        return $this->edit_widget(array(
            'title'         => $widget->title,
            'slug'          => $slug,
            'description'   => $widget->description,
            'author'        => $widget->author,
            'website'       => $widget->website,
            'version'       => $widget->version
        ));
    }

    public function validate(WidgetAbstract $widget)
    {
        ci()->load->library('form_validation');
        ci()->form_validation->set_rules('name', lang('name_label'), 'trim|required|max_length[100]');
        ci()->form_validation->set_rules('widget_id', null, 'trim|required|numeric');
        ci()->form_validation->set_rules('widget_area_id', null, 'trim|required|numeric');

        if (property_exists($widget, 'fields')) {
            ci()->form_validation->set_rules($widget->fields);
        }

        return ci()->form_validation->run('', false);
    }

    public function prepareOptions(WidgetAbstract $widget, WidgetInstanceModel $instance)
    {
        if (method_exists($widget, 'save')) {
            return (array) call_user_func(array(&$widget, 'save'), $instance->options);
        }

        return $instance->options;
    }

    /**
     * Turn a location and a widget name into an actuall instance
     *
     * @param string $path The location of the widget
     * @param string $slug The short name of the widget
     *
     * @return array
     */
    protected function spawnClass($location, $slug)
    {
        $widget_path = rtrim($location, '/')."/{$slug}/";
        $class_path = $widget_path."{$slug}.php";

        if ( ! file_exists($class_path)) {
            // throw new Exception("Widget {$slug} does not exist in {$location}.");
            return false;
        }

        require_once $class_path;
        $class_name = 'Widget_'.ucfirst(strtolower($slug));

        $widget = new $class_name();
        $widget->path = $widget_path;

        return $widget;
    }

    /**
     * Turn a location and a widget name into an actuall instance
     *
     * @param string          $view   View name
     * @param WidgetAbstract  $widget Widget class
     * @param array           $data   Extra data to be send to the view
     *
     * @return array
     */
    protected function loadView($view, WidgetAbstract $widget, array $data = array())
    {
        $view_path = $widget->path.'views/'.$view.'.php';

        $view_content = ci()->load->_ci_load(array(
            '_ci_path'      => $view_path,
            '_ci_vars'      => $data,
            '_ci_return'    => true
        ));

        return $view == 'display'

            ? ci()->parser->parse_string($view_content, array(), true)

            : $view_content;
    }

}
