<?php  defined('BASEPATH') or exit('No direct script access allowed');
/**
 * PyroCMS Module Definition
 *
 * This class should be extended to allow for module management.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Libraries
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
	
	/**
	 * Installs the modules tables in the database.
	 * 
	 * Can handle primary keys and FULLTEXT indexes.
	 *
	 * @param array $tables The database tables definitions.
	 */
	public function install_tables($tables)
	{

		foreach ($tables as $table_name => $fields)
		{
			// First we go ahead and add all the fields.
			$this->dbforge->add_field($fields);


			// Then go ahead and check for our special cases such as, primary
			// keys, fulltext indices etc.
			$primary = array();
			$fulltext = array();

			//So for all the fields of this table:
			foreach ($fields as $field => $field_data)
			{
				// Check every property of the field definition
				foreach ($field_data as $key => $value)
				{
					// Primary keys
					if ($key === 'primary')
					{
						// Add it for later
						$primary[] = $field;
					}

					if ($key === 'fulltext')
					{
						// Check if we are actually doing multiple FULLTEXT keys
						if (is_array($value))
						{
							foreach ($value as $fulltext_index_name)
							{
								// If we dont have a key for this fulltext
								if (!array_key_exists($fulltext_index_name, $fulltext))
								{
									// Go ahead and create it.
									$fulltext[$fulltext_index_name] = array();
								}
								// Register the field for fulltext keying later on.
								$fulltext[$fulltext_index_name][] = $field;
							}
						}
						// Or this is just a single fulltext key name.
						elseif (is_string($value))
						{
							// If we dont have a key for this fulltext
							if (!array_key_exists($value, $fulltext))
							{
								// Go ahead and create it.
								$fulltext[$value] = array();
							}

							// Register the field for fulltext keying later on.
							$fulltext[$value][] = $field;
						}
					}
				}
			}
			// Add primary keys now
			if (count($primary) > 0)
			{
				if (count($primary) > 1)
				{
					// Add them all
					$this->dbforge->add_key($primary, TRUE);
				}
				else
				{
					// Just add a single one
					$this->dbforge->add_key($primary[0], TRUE);
				}
			}

			// Then we create the table (if not exists).
			if ($this->dbforge->create_table($table_name, true))
			{
				// Add any fulltext indices now
				if (count($fulltext) > 0)
				{
					// FULLTEXT is only available on MyISAM.
					$this->db->query('ALTER TABLE '.$this->db->dbprefix($table_name).' ENGINE = MyISAM');

					// Add all the fulltext indices we have collected
					// @todo there is no checking whether the index exists already.
					foreach ($fulltext as $index_name => $field_names)
					{
						$this->db->query('CREATE FULLTEXT INDEX '.$index_name.' ON '.$this->db->dbprefix($table_name).'('.implode(', ', $field_names).')');
					}
				}
			}
		}
	}
}

/* End of file Module.php */