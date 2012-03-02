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
			$key_or_index_types = array(
				'primary' => array(),
				'fulltext' => array(),
				'unique' => array(),
				'key' => array(),
			);

			//So for all the fields of this table:
			foreach ($fields as $field => $field_data)
			{
				// Lets collect the keys/indexes now.
				foreach ($key_or_index_types as $type => $arr)
				{
					// Check every property of the field definition
					foreach ($field_data as $key => $value)
					{
						if ($key === $type)
						{
							$this->_add_to_array($key_or_index_types[$type], $value, $field, $type);
						}
					}
				}
			}
			// Add primary keys now
			if (count($key_or_index_types['primary']) > 0)
			{
				if (count($key_or_index_types['primary']) > 1)
				{
					// Add them one by one.
					foreach ($key_or_index_types['primary'] as $i => $primary_key)
					{
						$this->dbforge->add_key($key_or_index_types['primary'][$i], TRUE);
					}
				}
				else
				{
					// Just add a single one
					$this->dbforge->add_key($key_or_index_types['primary'][array_shift(array_keys($key_or_index_types['primary']))], TRUE);
				}
			}

			if (count($key_or_index_types['key']) > 0)
			{
				if (count($key_or_index_types['key']) > 1)
				{
					$this->dbforge->add_key($key_or_index_types['key']);
				}
				else
				{
					$this->dbforge->add_key($key_or_index_types['key'][array_shift(array_keys($key_or_index_types['key']))]);
				}
			}

			// Then we create the table (if not exists).
			if ($this->dbforge->create_table($table_name, true))
			{
				// Add any fulltext indices now
				if (count($key_or_index_types['fulltext']) > 0)
				{
					// FULLTEXT is only available on MyISAM.
					$this->db->query('ALTER TABLE '.$this->db->dbprefix($table_name).' ENGINE = MyISAM');

					// Add all the fulltext indices we have collected
					// @todo there is no checking whether the index exists already.
					foreach ($key_or_index_types['fulltext'] as $index_name => $field_names)
					{
						$this->db->query('CREATE FULLTEXT INDEX '.$index_name.' ON '.$this->db->dbprefix($table_name).'('.implode(', ', $field_names).')');
					}
				}
				// Add any unique indexes now
				if (count($key_or_index_types['unique']) > 0)
				{
					foreach ($key_or_index_types['unique'] as $index_name => $field_names)
					{
						$this->db->query('CREATE UNIQUE INDEX '.$index_name.' ON '.$this->db->dbprefix($table_name).'('.implode(', ', $field_names).')');
					}
				}
			}
		}
	}

	private function _add_to_array(&$arr, $index, $value, $type='')
	{
		if(is_array($value)) {
			foreach ($value as $v)
			{
				$this->_add_to_array($arr, $index, $v);
			}
		}

		if ( is_bool($index) and $index === true)
		{
			// The key/index takes the fields name.
			$index = ( ! empty($type)) ? $type.'_'.$value : $value;
		}

		// If we dont have a key for this
		if (!array_key_exists($index, $arr))
		{
			// Go ahead and create it
			$arr[$index] = array();
		}
		// Add it
		$arr[$index][] = $value;
	}
}

/* End of file Module.php */