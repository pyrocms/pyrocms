<?php namespace Pyro\Module\Addons;

use Pyro\Module\Users\Model\User;

/**
 * Module Manager
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.ModuleManager.html
 */
class ModuleManager
{
    /**
     * Caches modules that exist
     */
    protected $exists = array();

    /**
     * Caches modules that are enabled
     */
    protected $enabled = array();

    /**
     * Caches module
     */
    protected $loaded_modules = array();

    /**
     * Caches modules that are installed
     */
    protected $installed = array();

    /**
     * Modules model
     */
    protected $modules;

    /**
     * User
     */
    protected $user;

    public function __construct(User $user = null)
    {
        $this->modules = new ModuleModel;

        $this->user = $user;
    }

    /**
     * Get Model
     *
     * @return Pyro\Module\Addons\ModuleModel
     */
    public function getModel()
    {
        return $this->modules;
    }

    /**
     * Spawn Class
     *
     * Checks to see if a details.php exists and returns a class
     *
     * @param   string  $slug   The folder name of the module
     * @return  array
     */
    public static function spawnClass($slug, $is_core = false)
    {
        $path = $is_core ? APPPATH : ADDONPATH;

        // Before we can install anything we need to know some details about the module
        $details_file = $path.'modules/'.$slug.'/details.php';

        // Check the details file exists
        if ( ! is_file($details_file)) {
            $details_file = SHARED_ADDONPATH.'modules/'.$slug.'/details.php';

            if ( ! is_file($details_file)) {
                // we return false to let them know that the module isn't here, keep looking
                return false;
            }
        }

        // Sweet, include the file
        include_once $details_file;

        // Now call the details class
        $module_class = 'Module_'.ucfirst(strtolower($slug));

        // Now we need to talk to it
        if ( ! class_exists($module_class)) {
            throw new Exception("Module $slug has an incorrect details.php class. It should be called '$module_class'.");
        }

        return array(new $module_class, dirname($details_file));
    }

    /**
     * Get
     *
     * Return an array containing module data
     *
     * @param   string  $slug  The name of the module to load
     * @return  array
     */
    public function get($slug)
    {
        // Fetch the actual module record
        if (isset($this->loaded_modules[$slug])) {
            $record = $this->loaded_modules[$slug];
        } elseif ((! $record = $this->modules->findBySlug($slug))) {
            return false;
        }

        $this->loaded_modules[$slug] = $record;

        $this->exists[$slug] = true;
        $this->enabled[$slug] = $record->isEnabled();
        $this->installed[$slug] = $record->isInstalled();

        // Let's get REAL
        if (( ! $module = $this->spawnClass($slug, $record->isCore()))) {
            return false;
        }

        list($module_class, $location) = $module;
        $info = $module_class->info();

        // Return false if the module is disabled
        if ($record->isEnabled() === false) {
            return false;
        }

        $name = ! isset($info['name'][CURRENT_LANGUAGE]) ? $info['name']['en'] : $info['name'][CURRENT_LANGUAGE];
        $description = ! isset($info['description'][CURRENT_LANGUAGE]) ? $info['description']['en'] : $info['description'][CURRENT_LANGUAGE];

        return array(
            'name' => $name,
            'module' => $module_class,
            'slug' => $record->slug,
            'version' => $record->version,
            'description' => $description,
            'skip_xss' => $record->skip_xss,
            'is_frontend' => $record->isFrontend(),
            'is_backend' => $record->isBackend(),
            'menu' => $record->menu,
            'enabled' => (bool) $record->enabled,
            'sections' => ! empty($info['sections']) ? $info['sections'] : array(),
            'shortcuts' => ! empty($info['shortcuts']) ? $info['shortcuts'] : array(),
            'is_core' => $record->isCore(),
            'is_current' => version_compare($record->version, $this->version($record->slug),  '>='),
            'current_version' => $this->version($record->slug),
            'path' => $location,
            'field_types' => ! empty($info['field_types']) ? $info['field_types'] : false,
            'updated_at' => $record->updated_at
        );
    }

    /**
     * Get All
     *
     * Return an array of objects containing module related data
     *
     * @param   array   $params             The array containing the modules to load
     * @param   bool    $return_disabled    Whether to return disabled modules
     * @return  array
     */
    public function getAllEnabled($params = null)
    {
        return $this->getAll($params, false, false);
    }

    /**
     * Get Modules
     *
     * Return an array of objects containing module related data
     *
     * @param   array   $params             The array containing the modules to load
     * @param   bool    $return_disabled    Whether to return disabled modules
     * @return  array
     */
    public function getAll($params = null, $return_disabled = true, $fresh = true)
    {
        // This is FUCKING BROKEN and I don't know why.. it returns em all
        $result = $this->modules->findWithFilter($params, $return_disabled);

        $modules = array();
        foreach ($result as $record) {

            // TMP FIX - @todo - Phil fix me..
            if (!$return_disabled and !$record->isEnabled()) continue;

            // Let's get REAL
            if ( ! $module = $this->spawnClass($record->slug, $record->isCore())) {
                // If module is not able to spawn a class,
                // just forget about it and move on, man.
                continue;
            }

            list($module_class, $location) = $module;
            $info = $module_class->info();

            $name = ! isset($info['name'][CURRENT_LANGUAGE]) ? $info['name']['en'] : $info['name'][CURRENT_LANGUAGE];

            $description = ! isset($info['description'][CURRENT_LANGUAGE]) ? $info['description']['en'] : $info['description'][CURRENT_LANGUAGE];

            $module = array(
                'name'            => $name,
                'module'          => $module_class,
                'slug'            => $record->slug,
                'version'         => $record->version,
                'description'     => $description,
                'skip_xss'        => $record->skip_xss,
                'is_frontend'     => $record->isFrontend(),
                'is_backend'      => $record->isBackend(),
                'menu'            => $record->menu,
                'enabled'         => $record->isEnabled(),
                'sections'        => ! empty($info['sections']) ? $info['sections'] : array(),
                'shortcuts'       => ! empty($info['shortcuts']) ? $info['shortcuts'] : array(),
                'installed'       => $record->installed,
                'is_core'         => $record->isCore(),
                'is_current'      => version_compare($record->version, $this->version($record->slug),  '>='),
                'current_version' => $this->version($record->slug),
                'path'            => $location,
                'field_types'     => ! empty($info['field_types']) ? $info['field_types'] : false,
                'updated_at'      => $record->updated_at
            );

            // store these
            $this->exists[$record->slug] = true;
            $this->enabled[$record->slug] = $record->enabled;
            $this->installed[$record->slug] = $record->installed;

            if ( ! empty($params['is_backend'])) {
                // This user has no permissions for this module
                if (( ! $this->user->hasAccess($record->slug.'.*'))) {
                    continue;
                }
            }

            $modules[$module['name']] = $module;
        }

        ksort($modules);

        return array_values($modules);
    }

    /**
     * Module widget task
     *
     * Enable/disable widgets inside module folder
     *
     * @param   string  $slug   The module slug
     * @param   string  $task   enable | disable
     * @return  NULL
     */
    private function module_widget_task($slug, $task)
    {
        foreach (array(APPPATH, ADDONPATH, SHARED_ADDONPATH) as $path) {
            foreach ((array) glob($path.'modules/'.$slug.'/widgets/*', GLOB_ONLYDIR) as $widget_path) {
                $widget = basename($widget_path);

                switch ($task) {
                    case 'enable':
                        $this->db
                            ->where('slug', $widget)
                            ->where('enabled', true)
                            ->update('widgets', array('enabled' => true));
                    break;
                    case 'disable':
                        $this->db
                            ->where('slug', $widget)
                            ->where('enabled', true)
                            ->update('widgets', array('enabled' => false));
                    break;
                }
            }
        }
    }

    /**
     * Install
     *
     * Installs a module
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function install($slug, $is_core = false, $insert = false)
    {
        if ( ! $located = $this->spawnClass($slug, $is_core)) {
            return false;
        }

        list($module_class) = $located;

        // They've just finished uploading it so we need to make a record
        if ($insert) {
            // Get some info for the db
            $input = $module_class->info();

            // Now lets set some details ourselves
            $input['slug']      = $slug;
            $input['version']   = $module_class->version;
            $input['enabled']   = $is_core; // enable if core
            $input['installed'] = $is_core; // install if core
            $input['is_core']   = $is_core; // is core if core

            // It's a valid module let's make a record of it
            $module = $this->modules->create($input);

        // Otherwise, find this module so we can update it shortly
        } else {
            $module = $this->modules->findBySlug($slug);
        }

        // set the site_ref and upload_path for third-party devs
        $module_class->site_ref    = SITE_REF;
        $module_class->upload_path = 'uploads/'.SITE_REF.'/';

        // Run the install method to get it into the database
        if ($module_class->install(ci()->pdb, ci()->pdb->getSchemaBuilder())) {

            // TURN ME ON BABY!
            $module->enabled = true;
            $module->installed = true;
            $module->save();

            // Update cache now that its enabled
            $this->exists[$slug] = true;
            $this->enabled[$slug] = true;
            $this->installed[$slug] = true;

            return true;
        }

        return false;
    }

    /**
     * Uninstall
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function uninstall($slug, $is_core = false)
    {
        if (( ! $located = $this->spawnClass($slug, $is_core))) {
            // the files are missing so let's clean the "modules" table

            return $this->modules->findBySlug($slug)->delete();
        }

        list($module_class) = $located;

        // set the site_ref and upload_path for third-party devs
        $module_class->site_ref    = SITE_REF;
        $module_class->upload_path = 'uploads/'.SITE_REF.'/';

        // Run the uninstall method to drop the module's tables
        if (! $module_class->uninstall(ci()->pdb, ci()->pdb->getSchemaBuilder())) {
            return false;
        }

        $record = $this->modules->findBySlug($slug);

        $record->enabled   = false;
        $record->installed = false;
        return $record->save();
    }

    /**
     * Upgrade
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function upgrade($slug, $is_core = false)
    {
        // Get info on the new module
        if (( ! $located = $this->spawnClass($slug, $is_core))) {
            return false;
        }

        // Get info on the old module
        if (( ! $old_module = $this->get($slug))) {
            return false;
        }

        list($module_class) = $located;

        // Get the old module version number
        $old_version = $old_module['version'];

        // set the site_ref and upload_path for third-party devs
        $module_class->site_ref    = SITE_REF;
        $module_class->upload_path = 'uploads/'.SITE_REF.'/';

        // Run the update method to get it into the database
        if (( ! $module_class->upgrade($old_version))) {
            // The upgrade failed
            return false;
        }

        // Update version number
        $record = $this->modules->findBySlug($slug);
        $record->version = $module_class->version;

        return $record->save();

    }

    /**
     * Discover Nonexistant Modules
     *
     * Go through the list of modules in the file system and see
     * if they exist in the database
     *
     * @return  bool
     */
    public function registerUnavailableModules()
    {
        $modules = array();

        $is_core = true;

        $known = $this->modules->findAll();

        $known_array = array();
        $known_mtime = array();

        // Loop through the known array and assign it to a single dimension because
        // in_array can not search a multi array.
        if ($known->count() > 0) {
            foreach ($known as $item) {
                $known_mtime[$item->slug] = $item;
            }
        }

        foreach (array(APPPATH, ADDONPATH, SHARED_ADDONPATH) as $directory) {
            // some servers return false instead of an empty array
            if ( ! $directory or ! ($temp_modules = glob($directory.'modules/*', GLOB_ONLYDIR))) {
                continue;
            }

            foreach ($temp_modules as $path) {
                $slug = basename($path);

                // Yeah yeah we know
                if (isset($known_mtime[$slug])) {
                    $details_file = $directory.'modules/'.$slug.'/details.php';

                    // This file has changed since the last "updated" date
                    if (file_exists($details_file) and
                        filemtime($details_file) > $known_mtime[$slug]->updated_on and
                        $located = $this->spawnClass($slug, $is_core))
                    {
                        list($module_class) = $located;

                        // Get some basic info
                        $input = $module_class->info();

                        // Update the DB record with the new stuff
                        $known_mtime[$slug]->save(array(
                            'name'        => serialize($input['name']),
                            'description' => serialize($input['description']),
                            'is_frontend' => ! empty($input['frontend']),
                            'is_backend'  => ! empty($input['backend']),
                            'skip_xss'    => ! empty($input['skip_xss']),
                            'menu'        => ! empty($input['menu']) ? $input['menu'] : false,
                            'updated_at'  => date('Y-m-d H:i:s')
                        ));

                        log_message('debug', sprintf('The information of the module "%s" has been updated', $slug));
                    }

                    continue;
                }

                // This doesn't have a valid details.php file! :o
                if ( ! $located = $this->spawnClass($slug, $is_core)) {
                    continue;
                }

                list ($module_class) = $located;

                // Get some basic info
                $input = $module_class->info();

                // Now lets set some details ourselves
                $input['slug']      = $slug;
                $input['version']   = $module_class->version;
                $input['enabled']   = $is_core; // enable if core
                $input['installed'] = $is_core; // install if core
                $input['is_core']   = $is_core; // is core if core

                // Looks like it installed ok, add a record
                $this->modules->create(
                    array(
                        'name' => serialize($input['name']),
                        'slug' => $input['slug'],
                        'version' => $input['version'],
                        'description' => serialize($input['description']),
                        'is_frontend' => ! empty($input['frontend']),
                        'is_backend'  => ! empty($input['backend']),
                        'skip_xss'    => ! empty($input['skip_xss']),
                        'menu'        => ! empty($input['menu']) ? $input['menu'] : false,
                        'enabled' => $input['enabled'],
                        'installed' => $input['installed'],
                        'is_core' => $input['is_core'],
                        )
                    );
            }
            unset($temp_modules);

            // Going back around, 2nd time is addons
            $is_core = false;
        }

        return true;
    }

    /**
     * Module Exists
     *
     * Checks if a module exists
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function moduleExists($slug)
    {
        if (( ! $slug)) {
            return false;
        }

        if (isset($this->exists[$slug])) {
            return $this->exists[$slug];
        }

        // Go forth, find the answer, cache it and let us know
        return $this->exists[$slug] = $this->modules->moduleExists($slug);
    }

    /**
     * Module Enabled
     *
     * Checks if a module is enabled
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function moduleEnabled($slug)
    {
        if (( ! $slug)) {
            return false;
        }

        if (isset($this->enabled[$slug])) {
            return $this->enabled[$slug];
        }

        // Go forth, find the answer, cache it and let us know
        return $this->enabled[$slug] = $this->modules->moduleEnabled($slug);
    }

    /**
     * Module Installed
     *
     * Checks if a module is installed
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function moduleInstalled($slug)
    {
        if (( ! $slug)) {
            return false;
        }

        if (isset($this->installed[$slug])) {
            return $this->installed[$slug];
        }

        // Go forth, find the answer, cache it and let us know
        return $this->installed[$slug] = $this->modules->moduleInstalled($slug);
    }

    /**
     * Help
     *
     * Retrieves help string from details.php
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function help($slug)
    {
        foreach (array(false, true) as $is_core) {
            $languages = ci()->config->item('supported_languages');
            $default = $languages[ci()->config->item('default_language')]['folder'];

            //first try it as a core module
            if ($located = $this->spawnClass($slug, $is_core)) {
                list ($module_class, $location) = $located;

                // Check for a hep language file, if not show the default help text from the details.php file
                if (file_exists($location.'/language/'.$default.'/help_lang.php')) {
                    ci()->lang->load($slug.'/help');

                    if (lang('help_body')) {
                        return lang('help_body');
                    }
                } else {
                    return $module_class->help();
                }
            }
        }

        return false;
    }

    /**
     * Roles
     *
     * Retrieves roles for a specific module
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function roles($slug)
    {
        foreach (array(false, true) as $is_core) {
            // First try it as a core module
            if ($located = $this->spawnClass($slug, $is_core)) {

                list($module_class) = $located;
                $info = $module_class->info();

                if ( ! empty($info['roles'])) {
                    ci()->lang->load($slug.'/permission');
                    return $info['roles'];
                }
            }
        }

        return array();
    }

    /**
     * Help
     *
     * Retrieves version number from details.php
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function version($slug)
    {
        if ($located = $this->spawnClass($slug, true) or $located = $this->spawnClass($slug)) {
            list($module_class) = $located;
            return $module_class->version;
        }

        return false;
    }
}
