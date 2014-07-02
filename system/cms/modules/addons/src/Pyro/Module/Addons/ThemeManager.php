<?php namespace Pyro\Module\Addons;

use Pyro\Module\Addons\AbstractTheme;

/**
 * Theme Manager
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.ThemeManager.html
 */
class ThemeManager
{
    /**
     * Available Themes
     *
     * @var array
     */
    protected $exists = array();

    /**
     * Theme Locations
     *
     * @var array
     */
    protected $locations = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->themes = new ThemeModel;
    }

    /**
     * Set Locations
     */
    public function setLocations(array $locations)
    {
        $this->locations = $locations;
    }

    /**
     * Get Module
     *
     * @return Pyro\Module\Addons\ThemeModel
     */
    public function getModel()
    {
        return $this->themes;
    }

    /**
     * Locate
     *
     * @param string $slug
     * @return bool|object
     */
    public function locate($slug)
    {
        if (count($this->locations) === 0) {
            throw new Exception('No locations have been set, so how can anything be found?');
        }

        foreach ($this->locations as $location) {
            if (is_dir($location . $slug)) {
                $theme = $this->readDetails($location, $slug);

                if ($theme !== false) {
                    return $theme;
                }
            }
        }

        return false;
    }

    /**
     * Get details about a theme
     *
     * @param $location
     * @param $slug
     * @return array
     */
    protected function readDetails($location, $slug)
    {
        // If it exists already, use it
        if (!empty($this->exists[$slug])) {
            return $this->exists[$slug];
        }

        if (!(is_dir($path = $location . $slug) and is_file($path . '/theme.php'))) {
            return false;
        }

        //path to theme
        $web_path = $location . $slug;

        //load the theme details.php file
        $theme = $this->spawnClass($location, $slug);

        if ((!$model = $this->themes->findBySlug($slug))) {
            throw new \Exception("Theme '{$slug}' does not exist!");
        }

        // Add some extra bits, that aren't in the DB
        $theme->model      = $model;
        $theme->path       = $path;
        $theme->web_path   = $web_path;
        $theme->screenshot = $web_path . '/screenshot.png';

        return $theme;
    }

    /**
     * Spawn Class
     * Checks to see if a details.php exists and returns a class
     *
     * @param string $path The location of the theme (APPPATH, SHARED_PATH, etc)
     * @param string $slug The folder name of the theme
     * @return array
     */
    private function spawnClass($path, $slug)
    {
        // Before we can install anything we need to know some details about the theme
        $details_file = "{$path}{$slug}/theme.php";

        // Sweet, include the file
        require_once $details_file;

        // Now call the details class
        $class = 'Theme_' . ucfirst(strtolower($slug));

        $class = new $class;

        $class->slug = $slug;

        // Now we need to talk to it
        return $class;
    }

    /**
     * Discover Unavailable Themes
     * Go through the list of themes in the file system and see
     * if they exist in the database
     *
     * @return  bool
     */
    public function registerUnavailableThemes()
    {
        $known = $this->themes->findAll();

        $known_mtime = array();

        // Loop through the known array and assign it to a single dimension because
        // in_array can not search a multi array.
        if ($known->count() > 0) {
            foreach ($known as $item) {
                $known_mtime[$item->slug] = $item;
            }
        }

        foreach ($this->locations as $location) {
            // some servers return false instead of an empty array
            if ((!$temp_themes = glob($location . '*', GLOB_ONLYDIR))) {
                continue;
            }

            foreach ($temp_themes as $path) {
                $slug = basename($path);

                $theme_class = $this->spawnClass($location, $slug);

                // This didnt work out right at all. Bail on this one theme.
                if ($theme_class === false or !($theme_class instanceof AbstractTheme)) {
                    continue;
                }

                $this->register($theme_class, $slug);
            }
        }

        return true;
    }

    /**
     * Register
     * Read a theme from the file system and save it to the DB
     *
     * @param AbstractTheme $theme Theme info instance
     * @param string        $slug  The folder name of the theme
     * @return  Pyro\Addons\ThemeModel
     */
    public function register(AbstractTheme $theme, $slug)
    {
        $record = false;

        if (!$this->themes->findBySlug($slug)) {
            // Looks like it installed ok, add a record
            $record = $this->themes->create(
                array(
                    'slug'           => $slug,
                    'name'           => $theme->name,
                    'author'         => $theme->author,
                    'author_website' => $theme->author_website,
                    'website'        => $theme->website,
                    'description'    => $theme->description,
                    'version'        => $theme->version,
                    'type'           => $theme->type,
                    'created_at'     => isset($theme->created_at) ? $theme->created_at : date('Y-m-d H:i:s'),
                )
            );

            if (is_array($theme->options)) {
                foreach ($theme->options as $key => $option) {

                    if (!isset($option['slug'])) {
                        $option['slug'] = $key;
                    }

                    $record->options()->create(
                        array(
                            'slug'        => $option['slug'],
                            'title'       => $option['title'],
                            'description' => isset($option['description']) ? $option['description'] : $option['description'],
                            'default'     => isset($option['default']) ? $option['default'] : '',
                            'value'       => isset($option['default']) ? $option['default'] : '',
                            'type'        => isset($option['type']) ? $option['type'] : 'text',
                            'options'     => isset($option['options']) ? $option['options'] : '',
                            'is_required' => isset($option['is_required']) ? $option['is_required'] : false,
                            'theme_id'    => $record->getKey(),
                        )
                    );
                }
            }
        }

        return $record;
    }

    /**
     * Get
     * Return an array containing module data
     *
     * @param   string $slug The name of the module to load
     * @return  array
     */
    public function get($slug)
    {
        return $this->locate($slug);
    }
}
