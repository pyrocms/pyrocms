<?php

use Composer\Autoload\ClassLoader;
use Pyro\Module\Streams\FieldType\FieldTypeManager;

include PYROPATH.'core/MY_Model.php';

class Module_import
{
    public function __construct(array $params)
    {
        ci()->pdb = $this->pdb = $params['pdb'];

        // Make sure folders exist for addon structure
        $this->buildFolderStructure(ADDONPATH, dirname(FCPATH));

        // Lets PSR-0 up our modules
        $this->registerAutoloader(new ClassLoader, realpath(PYROPATH), true);
    }

    /**
     * Build folder structure
     * Creates folders if they are missing for modules, themes, widgets, etc
     *
     * @param string $app_path The location of the PyroCMS application folder
     * @param string $base_path The location of the root of the PyroCMS installation
     */
    public function buildFolderStructure($app_path, $base_path)
    {
        // create the site specific addon folder
        is_dir($app_path.'modules') or mkdir($app_path.'modules', DIR_READ_MODE, true);
        is_dir($app_path.'themes') or mkdir($app_path.'themes', DIR_READ_MODE, true);
        is_dir($app_path.'widgets') or mkdir($app_path.'widgets', DIR_READ_MODE, true);
        is_dir($app_path.'field_types') or mkdir($app_path.'field_types', DIR_READ_MODE, true);

        // create the site specific upload folder
        if ( ! is_dir($base_path.'/uploads/default')) {
            mkdir($base_path.'/uploads/default', DIR_WRITE_MODE, true);
        }
    }

    /**
     * Register Autoloader
     *
     * @param Composer\Autoload\ClassLoader $loader Instance of the Composer autoloader
     * @param string $app_path The location of the PyroCMS application folder
     *
     * @return Composer\Autoload\ClassLoader
     */
    public function registerAutoloader(ClassLoader $loader, $app_path, $is_core = false)
    {
        $loader->add('Pyro\\Module\\Addons', $app_path.'/modules/addons/src/');
        $loader->add('Pyro\\Module\\Streams_core', $app_path.'/modules/streams_core/src/');
        $loader->add('Pyro\\Module\\Streams', $app_path.'/modules/streams_core/src/');

        $slugs = array();

        // Go through EVERY module and register its src folder
        foreach (glob("{$app_path}/modules/*/src/", GLOB_ONLYDIR) as $dir) {

            // Turn 'modules/blog/src/' into 'blog'
            $slugs[] = $slug = basename(dirname($dir));

            // That 'blog' should now be 'Pyro\Module\Blog'
            $namespace = 'Pyro\\Module\\'.ucfirst($slug);

            $loader->add($namespace, $dir);
        }

        // activate the autoloader
        $loader->register();

        foreach ($slugs as $slug) {

            if ($details_class = $this->spawnClass($slug, $is_core)) {

                $module_info = $details_class->info();

                $field_types = isset($module_info['field_types']) ? $module_info['field_types'] : false;

                FieldTypeManager::registerFolderFieldTypes("{$app_path}/modules/{$slug}/field_types/", $field_types);
            }
        }

        return $loader;
    }

    /**
     * Installs a module
     *
     * @param string $slug The module slug
     * @param bool   $is_core
     *
     * @return bool
     */
    public function install($slug, $is_core = false)
    {
        if ( ! ($details_class = $this->spawnClass($slug, $is_core))) {
            exit("The module $slug is missing a details.php");
        }

        // Get some basic info
        $module = $details_class->info();

        // Now lets set some details ourselves
        $module['version'] = $details_class->version;
        $module['is_core'] = $is_core;
        $module['enabled'] = true;
        $module['installed'] = true;
        $module['slug'] = $slug;

        // set the site_ref and upload_path for third-party devs
        $details_class->site_ref = 'default';
        $details_class->upload_path = 'uploads/default/';

        // Run the install method to get it into the database
        // try
        // {
            $details_class->install($this->pdb, $this->pdb->getSchemaBuilder());
        // }
        // catch (Exception $e)
        // {
        // 	// TODO Do something useful
        // 	exit('HEY '.$e->getMessage()." in ".$e->getFile()."<br />");

        // 	return false;
        // }

        // Looks like it installed ok, add a record
        return $this->add($module);
    }

    /**
     * Add
     *
     * Insert the database record for a single module
     *
     * @param     array     Array of module informaiton.
     * @return    boolean
     */
    public function add($module)
    {
        return $this->pdb
            ->table('modules')
            ->insert(array(
                'name' => serialize($module['name']),
                'slug' => $module['slug'],
                'version' => $module['version'],
                'description' => serialize($module['description']),
                'skip_xss' => ! empty($module['skip_xss']),
                'is_frontend' => ! empty($module['frontend']),
                'is_backend' => ! empty($module['backend']),
                'menu' => ! empty($module['menu']) ? $module['menu'] : false,
                'enabled' => (bool) $module['enabled'],
                'installed' => (bool) $module['installed'],
                'is_core' => (bool) $module['is_core'],
                'created_at' => date('Y-m-d H:i:s'),
            )
        );
    }

    /**
     * Import All
     *
     * Create settings and streams core, and run the install() method for all modules
     *
     * @return    boolean
     */
    public function import_all()
    {
        // Install settings and streams core first. Other modules may need them.
        $this->install('settings', true);

        ci()->load->library('settings/settings');

        $this->install('streams_core', true);
        $this->install('templates', true);

        // Are there any modules to install on this path?
        if ($modules = glob(PYROPATH.'modules/*', GLOB_ONLYDIR)) {
            // Loop through modules
            foreach ($modules as $module_name) {
                $slug = basename($module_name);

                if ($slug == 'streams_core' or $slug == 'settings' or $slug == 'templates') {
                    continue;
                }

                // invalid details class?
                if ( ! $details_class = $this->spawnClass($slug, true)) {
                    continue;
                }

                $this->install($slug, true);
            }
        }

        $user = ci()->session->userdata('user');

        // Populate site profiles
        $this->pdb
            ->table('profiles')->insert(array(
                'user_id'       => 1,
                'first_name'    => $user['firstname'],
                'last_name'     => $user['lastname'],
                'display_name'  => $user['firstname'].' '.$user['lastname'],
                'lang'          => 'en',
                'created_at' => date('Y-m-d H:i:s'),
            ));

        // After modules are imported we need to modify the settings table
        // This allows regular admins to upload addons on the first install but not on multi
        $this->pdb
            ->table('settings')
            ->where('slug', '=', 'addons_upload')
            ->update(array('value' => true));

        return true;
    }

    /**
     * Spawn Class
     *
     * Checks to see if a details.php exists and returns a class
     *
     * @param string $slug    The folder name of the module
     * @param bool   $is_core
     *
     * @return    Module
     */
    private function spawnClass($slug, $is_core = false)
    {
        $path = $is_core ? PYROPATH : ADDONPATH;

        // Before we can install anything we need to know some details about the module<<<<<<< HEAD
        $details_file = "{$path}modules/{$slug}/details.php";

        // If it didn't exist as a core module or an addon then check shared_addons
        if ( ! is_file($details_file)) {
            $details_file = "{SHARED_ADDONPATH}modules/{$slug}/details.php";

            if ( ! is_file($details_file)) {
                return false;
            }
        }

        // Sweet, include the file
        include_once $details_file;

        // Now call the details class
        $class = 'Module_'.ucfirst(strtolower($slug));

        // Now we need to talk to it
        return class_exists($class) ? new $class($this->pdb) : false;
    }
}
