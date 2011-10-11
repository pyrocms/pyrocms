<?php  defined('BASEPATH') or exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0
 * @filesource
 */

/**
 * PyroCMS Module Definition
 *
 * This class should be extended to allow for module management.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Modules
 * @abstract
 */
abstract class Module {

	/**
	 * @var The version of the module.
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
	 *	   'frontend' => TRUE,
	 *	   'backend'  => TRUE,
	 *	   'menu'	  => TRUE
	 *	   'controllers' => array(
	 *		   'admin' => array('index', 'edit', 'delete'),
	 *		   'example' => array('index', 'view')
	 *	   )
	 * );
	 *
	 * @abstract
	 * @access	public
	 * @return	array	The information about the module
	 */
	public abstract function info();

	/**
	 * Install
	 *
	 * Called upon first install of the module.
	 *
	 * @abstract
	 * @access	public
	 * @return	bool	Whether the module was installed
	 */
	public abstract function install();

	/**
	 * Uninstall
	 *
	 * Called upon the uninstall of the module.
	 *
	 * @abstract
	 * @access	public
	 * @return	bool	Whether the module was uninstalled
	 */
	public abstract function uninstall();

	/**
	 * Upgrade
	 *
	 * Called when this is a newer version than currently installed.
	 *
	 * @abstract
	 * @access	public
	 * @param	string	The version to upgrade from
	 * @return	bool	Whether the module was installed
	 */
	public abstract function upgrade($old_version);
	
	/**
	 * Construct
	 *
	 * Loads the database and dbforge libraries.
	 *
	 * @access	public
	 * @return	string
	 */
	public function __construct()
	{
		$this->load->database();
		$this->load->dbforge();
	}
	
	/**
	 * Help
	 *
	 * This function returns the help data for a module.  It should be overriden
	 * by the module.
	 * This defaults to "No Help Provided".
	 *
	 * @access	public
	 * @return	string
	 */
	public function help()
	{
		return lang('modules.no_help');
	}

	/**
	 * __get
	 *
	 * Allows this class and classes that extend this to use $this-> just like
	 * you were in a controller.
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function __get($var)
	{
		static $ci;
		isset($ci) OR $ci =& get_instance();
		return $ci->{$var};
	}
}

/* End of file Module.php */