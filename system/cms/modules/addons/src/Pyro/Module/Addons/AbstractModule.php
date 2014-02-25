<?php namespace Pyro\Module\Addons;

use Illuminate\Database\Connection as DbConnection;

/**
 * PyroCMS Module Definition
 *
 * This class should be extended to allow for module management
 *
 * @package		PyroCMS\Core\Libraries
 * @author		PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
abstract class AbstractModule
{
    /**
     * The version of the module.
     *
     * @var string
     */
    public $version;

    /**
     * Info
     *
     * This function returns the details for a module. It should be overridden
     * by the module.
     * Expected return is an array:
     *
     * array(
     *	   'name' => array(
     *		   'en' => 'Example Module'
     *	   ),
     *	   'description' => array(
     *		   'en' => 'Example Module Description'
     *	   ),
     *	   'frontend' => true,
     *	   'backend'  => true,
     *	   'menu'	  => true
     *	   'controllers' => array(
     *		   'admin' => array('index', 'edit', 'delete'),
     *		   'example' => array('index', 'view')
     *	   )
     * );
     *
     * @return array The information about the module
     */
    abstract public function info();

    /**
     * Installs a module's tables and database tables and data.
     *
     * Called upon first install of the module. The typical case is that the
     * module's tables are initially dropped from the database and subsequently
     * are created again. But this is up to the module to implement.
     *
     * @return	bool	Whether the module was installed
     */
    abstract public function install($pdb, $schema);

    /**
     * Called upon the uninstall of the module.
     *
     * @return	bool	Whether the module was uninstalled
     */
    abstract public function uninstall($pdb, $schema);

    /**
     * Called when this is a newer version than currently installed.
     *
     * @param string $old_version The version to upgrade from
     * @return bool Whether the module was installed
     */
    abstract public function upgrade($old_version);

    /**
     * Loads the database and dbforge libraries.
     *
     * @param Illuminate\Database\Connection $pdb The Laravel database connection
     */
    public function __construct(DbConnection $pdb = null)
    {
        $pdb and $this->pdb = $pdb;
    }

    /**
     * Returns the help text for a module.
     *
     * By default returns "No Help Provided".
     *
     * @return string
     */
    public function help()
    {
        return lang('modules:no_help');
    }
}
