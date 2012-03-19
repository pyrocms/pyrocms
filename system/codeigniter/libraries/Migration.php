<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2006 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 3.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Migration Class
 *
 * All migrations should implement this, forces up() and down() and gives
 * access to the CI super-global.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Reactor Engineers
 * @link
 */
class CI_Migration {

	protected $_migration_enabled = FALSE;
	protected $_migration_path = NULL;
	protected $_migration_version = 0;
	protected $_migration_table = 'migrations';
	protected $_migration_auto_latest = FALSE;

	protected $_error_string = '';

	public function __construct($config = array())
	{
		# Only run this constructor on main library load
		if (get_parent_class($this) !== FALSE)
		{
			return;
		}

		foreach ($config as $key => $val)
		{
			$this->{'_' . $key} = $val;
		}

		log_message('debug', 'Migrations class initialized');

		// Are they trying to use migrations while it is disabled?
		if ($this->_migration_enabled !== TRUE)
		{
			show_error('Migrations has been loaded but is disabled or set up incorrectly.');
		}

		// If not set, set it
		$this->_migration_path == '' AND $this->_migration_path = APPPATH.'migrations/';

		// Add trailing slash if not set
		$this->_migration_path = rtrim($this->_migration_path, '/').'/';

		// Load migration language
		$this->lang->load('migration');

		// They'll probably be using dbforge
		$this->load->dbforge();

		// Make sure the migration table name was set.
		if (empty($this->_migration_table))
		{
			show_error('Migrations configuration file (migration.php) must have "migration_table" set.');
		}

		// If the migrations table is missing, make it
		if ( ! $this->db->table_exists($this->_migration_table))
		{
			$this->dbforge->add_field(array(
				'version' => array('type' => 'INT', 'constraint' => 3),
			));

			$this->dbforge->create_table($this->_migration_table, TRUE);

			$this->db->insert($this->_migration_table, array('version' => 0));
		}

		// Do we auto migrate to the latest migration?
		if ($this->_migration_auto_latest === TRUE AND ! $this->latest())
		{
			show_error($this->error_string());
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Migrate to a schema version
	 *
	 * Calls each migration step required to get to the schema version of
	 * choice
	 *
	 * @access	public
	 * @param $version integer	Target schema version
	 * @return	mixed	TRUE if already latest, FALSE if failed, int if upgraded
	 */
	public function version($target_version)
	{
		$start = $current_version = $this->_get_version();
		$stop = $target_version;

		if ($target_version > $current_version)
		{
			// Moving Up
			++$start;
			++$stop;
			$step = 1;
		}
		else
		{
			// Moving Down
			$step = -1;
		}

		$method = $step === 1 ? 'up' : 'down';
		$migrations = array();

		// We now prepare to actually DO the migrations
		// But first let's make sure that everything is the way it should be
		for ($i = $start; $i != $stop; $i += $step)
		{
			$f = glob(sprintf($this->_migration_path.'%03d_*.php', $i));

			// Only one migration per step is permitted
			if (count($f) > 1)
			{
				$this->_error_string = sprintf($this->lang->line('migration_multiple_version'), $i);
				return FALSE;
			}

			// Migration step not found
			if (count($f) === 0)
			{
				// If trying to migrate up to a version greater than the last
				// existing one, migrate to the last one.
				if ($step === 1)
				{
					break;
				}

				// If trying to migrate down but we're missing a step,
				// something must definitely be wrong.
				$this->_error_string = sprintf($this->lang->line('migration_not_found'), $i);
				return FALSE;
			}

			$file = basename($f[0]);
			$name = basename($f[0], '.php');

			// Filename validations
			if (preg_match('/^\d{3}_(\w+)$/', $name, $match))
			{
				$match[1] = strtolower($match[1]);

				// Cannot repeat a migration at different steps
				if (in_array($match[1], $migrations))
				{
					$this->_error_string = sprintf($this->lang->line('migration_multiple_version'), $match[1]);
					return FALSE;
				}

				include $f[0];
				$class = 'Migration_'.ucfirst($match[1]);

				if ( ! class_exists($class))
				{
					$this->_error_string = sprintf($this->lang->line('migration_class_doesnt_exist'), $class);
					return FALSE;
				}

				if ( ! is_callable(array($class, $method)))
				{
					$this->_error_string = sprintf($this->lang->line('migration_missing_'.$method.'_method'), $class);
					return FALSE;
				}

				$migrations[] = $match[1];
			}
			else
			{
				$this->_error_string = sprintf($this->lang->line('migration_invalid_filename'), $file);
				return FALSE;
			}
		}

		log_message('debug', 'Current migration: '.$current_version);

		$version = $i + ($step === 1 ? -1 : 0);

		// If there is nothing to do so quit
		if ($migrations === array())
		{
			return TRUE;
		}

		log_message('debug', 'Migrating from '.$method.' to version '.$version);

		// Loop through the migrations
		foreach ($migrations AS $migration)
		{
			// Run the migration class
			$class = 'Migration_'.ucfirst(strtolower($migration));
			call_user_func(array(new $class, $method));

			$current_version += $step;
			$this->_update_version($current_version);
		}

		log_message('debug', 'Finished migrating to '.$current_version);

		return $current_version;
	}

	// --------------------------------------------------------------------

	/**
	 * Set's the schema to the latest migration
	 *
	 * @access	public
	 * @return	mixed	true if already latest, false if failed, int if upgraded
	 */
	public function latest()
	{
		if ( ! $migrations = $this->find_migrations())
		{
			$this->_error_string = $this->lang->line('migration_none_found');
			return false;
		}

		$last_migration = basename(end($migrations));

		// Calculate the last migration step from existing migration
		// filenames and procceed to the standard version migration
		return $this->version((int) substr($last_migration, 0, 3));
	}

	// --------------------------------------------------------------------

	/**
	 * Set's the schema to the migration version set in config
	 *
	 * @access	public
	 * @return	mixed	true if already current, false if failed, int if upgraded
	 */
	public function current()
	{
		return $this->version($this->_migration_version);
	}

	// --------------------------------------------------------------------

	/**
	 * Error string
	 *
	 * @access	public
	 * @return	string	Error message returned as a string
	 */
	public function error_string()
	{
		return $this->_error_string;
	}

	// --------------------------------------------------------------------

	/**
	 * Set's the schema to the latest migration
	 *
	 * @access	protected
	 * @return	mixed	true if already latest, false if failed, int if upgraded
	 */
	protected function find_migrations()
	{
		// Load all *_*.php files in the migrations path
		$files = glob($this->_migration_path.'*_*.php');

		for ($i = 0, $c = count($files); $i < $c; $i++)
		{
			// Mark wrongly formatted files as false for later filtering
			if ( ! preg_match('/^\d{3}_(\w+)$/', basename($files[$i], '.php')))
			{
				$files[$i] = FALSE;
			}
		}

		sort($files);

		return $files;
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves current schema version
	 *
	 * @access	protected
	 * @return	integer	Current Migration
	 */
	protected function _get_version()
	{
		$row = $this->db->select('version')->get($this->_migration_table)->row();
		return $row ? $row->version : 0;
	}

	// --------------------------------------------------------------------

	/**
	 * Stores the current schema version
	 *
	 * @access	protected
	 * @param $migrations integer	Migration reached
	 * @return	void					Outputs a report of the migration
	 */
	protected function _update_version($migrations)
	{
		return $this->db->update($this->_migration_table, array(
			'version' => $migrations
		));
	}

	// --------------------------------------------------------------------

	/**
	 * Enable the use of CI super-global
	 *
	 * @access	public
	 * @param $var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}
}

/* End of file Migration.php */
/* Location: ./system/libraries/Migration.php */
