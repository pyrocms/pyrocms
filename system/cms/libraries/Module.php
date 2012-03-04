<?php  defined('BASEPATH') or exit('No direct script access allowed');
/**
 * PyroCMS Module Definition
 *
 * This class should be extended to allow for module management.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Libraries
 */
abstract class Module {

	/**
	 * The version of the module.
	 * 
	 * @var string
	 */
	public $version;
	
	/**
	 * The database tables of the module.
	 * 
	 * @var array
	 */
	public $tables = array();
	
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
	 * @return array The information about the module
	 */
	public abstract function info();

	/**
	 * Installs a module's tables and database tables and data.
	 *
	 * Called upon first install of the module. The typical case is that the 
	 * module's tables are initially dropped from the database and subsequently 
	 * are created again. If a module needs anything more than that it should go 
	 * ahead and implement this function on its own.
	 *
	 * @return bool Whether the module was installed
	 */
	public function install()
	{
		if(! empty($this->tables) )
		{
			foreach (array_keys($this->tables) as $table)
			{
				$this->dbforge->drop_table($table);
			}

			return $this->install_tables($this->tables);
		}
		// The module has no tables.
		return true;
	}

	/**
	 * Called upon the uninstall of the module.
	 *
	 * @return bool Whether the module was uninstalled
	 */
	public abstract function uninstall();

	/**
	 * Called when this is a newer version than currently installed.
	 *
	 * @param string The version to upgrade from
	 * @return bool Whether the module was installed
	 */
	public abstract function upgrade($old_version);

	/**
	 * Loads the database and dbforge libraries.
	 *
	 * @return string
	 */
	public function __construct()
	{
		$this->load->database();
		$this->load->dbforge();
	}

	/**
	 * Returns the help data for a module.
	 * 
	 * It should be overriden by the module. Defaults to "No Help Provided".
	 *
	 * @return string
	 */
	public function help()
	{
		return lang('modules.no_help');
	}

	/**
	 * Allows this class and classes that extend this to use $this-> just like
	 * you were in a controller.
	 *
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
	 * @param array $tables
	 *   The database tables definitions.
	 */
	public function install_tables($tables)
	{
		log_message('error', 'Will go ahead and create the following tables: '.implode(', ', array_keys($tables)));
		foreach ($tables as $table_name => $fields)
		{
			log_message('error', '-- Creating table: '.$table_name);
			// First we go ahead and add all the fields.
			$this->dbforge->add_field($fields);


			// Then go ahead and check for our special cases such as, primary 
			// and fulltext keys.
			$key_types = array(
				'primary' => array(),
				'fulltext' => array(),
				'unique' => array(),
				'key' => array(),
			);

			// For all the fields of this table definition:
			foreach ($fields as $field => $field_data)
			{
				// For each of the key types we know
				foreach (array_keys($key_types) as $type)
				{
					// Check with every property of the field definition...
					foreach ($field_data as $key => $value)
					{
						// to find if any of the one-above key types.
						if ($key === $type)
						{
							$this->_add_to_array($key_types[$type], $value, $field, $type);
						}

						// This is purely for convenience here since 'index' is 
						// a synonym to 'key'.
						if ($key == 'index')
						{
							$this->_add_to_array($key_types['key'], $value, $field, 'key');
						}
					}
				}
			}

			// Add primary keys
			$this->_add_keys('primary', $key_types['primary']);

			// Add normal keys
			$this->_add_keys('key', $key_types['key']);

			// Then we create the table (if not exists).
			if ( ! $this->dbforge->create_table($table_name, true))
			{
				log_message('error', '-- Table creation for '.$table_name.' failed.');
				return false;
			}

			// Then we create the fulltext keys.
			if ( ! $this->_create_keys('fulltext', $key_types['fulltext'], $table_name))
			{
				log_message('error', '-- Fulltext key creation failed for '.$table_name);
				return false;
			}

			// Then we create the rest of the keys.
			if ( ! $this->_create_keys('unique', $key_types['unique'], $table_name))
			{
				log_message('error', '-- Unique key creation failed for '.$table_name);
				return false;
			}
		}
		log_message('error', 'All done perfectly!');
		return true;
	}

	/**
	 * Adds keys to the table creation SQL.
	 * 
	 * A key type has to be specified to in this because of the differentiated 
	 * handling on adding multiple primary keys by Codeigniter's DBForge to the 
	 * normal keys.
	 *
	 * @param string $type 
	 *   The type of key to add. 
	 * @param array $keys
	 *   Key-value pairs for the key's info.
	 */
	protected function _add_keys($type, $keys)
	{
		if (count($keys) > 0)
		{
			if (count($keys) > 1)
			{
				// Primary keys are special cases.
				if ($type == 'primary')
				{
					// Add them one by one.
					foreach ($keys as $i => $primary_key)
					{
						$this->dbforge->add_key($keys[$i], TRUE);
					}
				}
				// Everything else can be just be supplied as an array.
				else
				{
					$this->dbforge->add_key($keys);
				}
			}
			else
			{
				$this->dbforge->add_key($keys[array_shift(array_keys($keys))], ($type == 'primary'));
			}
		}
	}
	
	/**
	 * Executes the SQL to create table keys after table creation.
	 *
	 * @param string $type 
	 *   The type of the key to create.
	 * @param array $keys 
	 *   Key-value pairs for the key info.
	 * @param string $table 
	 *   The name of the table on which to create the keys
	 * @return boolean 
	 *   True if successful, false otherwise.
	 */
	protected function _create_keys($type, $keys, $table)
	{
		// Sorry, we only support specific keys for now
		if ( ! in_array($type, array('fulltext', 'unique')))
		{
			return false;
		}
		
		// Make sure the type is uppercase
		$type = strtoupper($type);
		
		if (count($keys) > 0)
		{
			// @todo there is no checking whether the index exists already.
			
			// FULLTEXT is only available on MyISAM.
			if($type === 'FULLTEXT') {
				$sql = 'ALTER TABLE '.$this->db->dbprefix($table).' ENGINE = MyISAM';
				if ( ! $this->db->query($sql) ) {
					log_message('error', '-- -- Failed turning the engine for '.$table.' to MyISAM. SQL: '.$sql);
					return false;
				}
			}
			foreach ($keys as $key => $fields)
			{
				$sql = 'CREATE '.$type.' INDEX '.$key.' ON '.$this->db->dbprefix($table).'('.implode(', ', $fields).')';
				if ( ! $this->db->query($sql))
				{
					log_message('error', '-- -- Failed creating key '.$type.' for '.$table.': '. $sql);
					return false;
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Adds a field to the key type array storage.
	 * 
	 * We gather all the keys in an array so that we can handle them later on.
	 *
	 * @param array $arr 
	 *   The array that holds the specific key type keys.
	 * @param string $index 
	 *   A name for the key. If none is specified then we let the DBForge do 
	 *   it's thing.
	 * @param string $value 
	 *   The name of the field to attach to the key we are adding.
	 * @param string $type 
	 *   The key's type.
	 */
	protected function _add_to_array(&$arr, $index, $value, $type='')
	{
		if(is_array($value)) {
			foreach ($value as $v)
			{
				$this->_add_to_array($arr, $index, $v, $type);
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
		//var_dump('--- function agruments:',func_get_args(),'--- the $arr:', $arr,'--- the $index:', $index);
	}
	
	/**
	 * Inserts a row of data to the specified table.
	 *
	 * @param string $table 
	 *   The name of the table where the data will be inserted into.
	 * @param type $data
	 *   The array of rows to insert into the table.
	 * @return boolean 
	 *   True if successful, false otherwise.
	 */
	public function batch_insert($table, $data)
	{
		foreach ($data as $row)
		{
			if ( ! $this->db->insert($table, $row))
			{
				return false;
			}
		}
		
		return true;
	}
}