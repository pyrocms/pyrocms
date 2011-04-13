<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Migrations
 *
 * An open source utility for CodeIgniter inspired by Ruby on Rails.
 *
 * @package			Migrations
 * @author			Mat�as Montes
 * @modified		Phil Sturgeon
 * @license         http://philsturgeon.co.uk/code/dbad-license
 * @link			http://philsturgeon.co.uk/code/codeigniter-migrations
 *
 *	Credit for lots of the improvements:
 *
 * 	Spicer Matthews <spicer@cloudmanic.com>
 * 	Cloudmanic Labs, LLC
 * 	http://www.cloudmanic.com/
 *
 */

// ------------------------------------------------------------------------

/**
 * Migration Interface
 *
 * All migrations should implement this, forces up() and down() and gives
 * access to the CI super-global.
 *
 * @package		Migrations
 * @author		Phil Sturgeon
 */
abstract class Migration {

	public abstract function up();

	public abstract function down();

	function __get($var)
	{
		if (isset(get_instance()->$var))
		{
			return get_instance()->$var;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Migrations Class
 *
 * Utility main controller.
 *
 * @package		Migrations
 * @author		Mat�as Montes
 */
class Migrations {

	private $_migrations_enabled = FALSE;
	private $_migrations_path = NULL;
	private $_migrations_version = 0;

	public $verbose = FALSE;
	public $error = NULL;

	function __construct($config = array())
	{
		if ( ! empty($config))
		{
			foreach ($config as $key => $val)
			{
				$this->{'_' . $key} = $val;
			}
		}

		log_message('debug', 'Migrations class initialized');

		// Are they trying to use migrations while it is disabled?
		$this->_migrations_enabled OR show_error('Migrations has been loaded but is disabled or set up incorrectly.');

		// If not set, set it
		$this->_migrations_path == '' OR $this->_migrations_path = APPPATH . 'migrations/';

		// Add trailing slash if not set
		if (substr($this->_migrations_path, -1) != '/')
		{
			$this->_migrations_path .= '/';
		}

		$this->_ci =& get_instance();

		$this->_ci->lang->load('migrations');

		// They'll probably be using dbforge
		$this->_ci->load->dbforge();

		// If the schema_version table is missing, make it
		if ( ! $this->_ci->db->table_exists('schema_version'))
		{
			$this->_ci->dbforge->add_field(array(
				'version' => array('type' => 'INT', 'constraint' => 3),
			));

			$this->_ci->dbforge->create_table('schema_version', TRUE);

			$this->_ci->db->insert('schema_version', array('version' => 0));
		}
	}

	// This will set if there should be verbose output or not
	public function set_verbose($state)
	{
		$this->verbose = $state;
	}

	/**
	 * Installs the schema up to the last version
	 *
	 * @access	public
	 * @return	void	Outputs a report of the installation
	 */
	public function install()
	{
		// Load all *_*.php files in the migrations path
		$files = glob($this->_migrations_path . '*_*' . EXT);
		$file_count = count($files);

		for ($i = 0; $i < $file_count; $i++)
		{
			// Mark wrongly formatted files as FALSE for later filtering
			$name = basename($files[$i], EXT);
			if ( ! preg_match('/^\d{3}_(\w+)$/', $name))
			{
				$files[$i] = FALSE;
			}
		}

		$migrations = array_filter($files);

		if ( ! empty($migrations))
		{
			sort($migrations);
			$last_migration = basename(end($migrations));

			// Calculate the last migration step from existing migration
			// filenames and procceed to the standard version migration
			$last_version = substr($last_migration, 0, 3);
			return $this->version(intval($last_version, 10));
		}

		else
		{
			$this->error = $this->_ci->lang->line('migrations.no_migrations_found');
			return FALSE;
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
	function version($version)
	{
		$schema_version = $this->_get_schema_version();
		$start	= $schema_version;
		$stop	= $version;

		if ($version > $schema_version)
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
			$f = glob(sprintf($this->_migrations_path . '%03d_*' . EXT, $i));

			// Only one migration per step is permitted
			if (count($f) > 1)
			{
				$this->error = sprintf($this->_ci->lang->line('migrations.multiple_migrations_version'), $i);
				return FALSE;
			}

			// Migration step not found
			if (count($f) == 0)
			{
				// If trying to migrate
				// existing one, migrate to one.
				if ($migrations) break;

				// If trying to migrate but we're missing a step,
				// something must definitely be wrong.
				$this->error = sprintf($this->_ci->lang->line('migrations.migration_not_found'), $i);
				return FALSE;
			}

			$file = basename($f[0]);
			$name = basename($f[0], EXT);

			// Filename validations
			if (preg_match('/^\d{3}_(\w+)$/', $name, $match))
			{
				$match[1] = strtolower($match[1]);

				// Cannot repeat a migration at different steps
				if (in_array($match[1], $migrations))
				{
					$this->error = sprintf($this->_ci->lang->line('migrations.multiple_migrations_name'), $match[1]);
					return FALSE;
				}

				include $f[0];
				$class = 'Migration_' . ucfirst($match[1]);

				if ( ! class_exists($class))
				{
					$this->error = sprintf($this->_ci->lang->line('migrations.migration_class_doesnt_exist'), $class);
					return FALSE;
				}

				if ( ! is_callable(array($class, 'up')) || !is_callable(array($class, 'down')))
				{
					$this->error = sprintf($this->_ci->lang->line('migrations.wrong_migration_interface'), $class);
					return FALSE;
				}

				$migrations[] = $match[1];
			}
			else
			{
				$this->error = sprintf($this->_ci->lang->line('migrations.invalid_migration_filename'), $file);
				return FALSE;
			}
		}

		$version = $i + ($step == 1 ? -1 : 0);

		// If there is nothing to do, bitch and quit
		if ($migrations === array())
		{
			if ($this->verbose)
			{
				echo 'Nothing to do, bye!'.PHP_EOL;
			}

			return TRUE;
		}

		if ($this->verbose)
		{
			echo '<p>Current schema version: ' . $schema_version . '<br/>';
			echo 'Moving ' . $method . ' to version ' . $version . '</p>';
			echo '<hr/>';
		}

		// Loop through the migrations
		foreach ($migrations AS $migration)
		{
			if ($this->verbose)
			{
				echo $migration.':<br />';
				echo '<blockquote>';
			}

			$class = 'Migration_' . ucfirst($migration);
			call_user_func(array(new $class, $method));

			if ($this->verbose)
			{
				echo '</blockquote>';
				echo '<hr/>';
			}

			$schema_version += $step;
			$this->_update_schema_version($schema_version);
		}

		if ($this->verbose)
		{
			echo '<p>All done. Schema is at version '.$schema_version.'.</p>';
		}

		return $schema_version;
	}

	// --------------------------------------------------------------------

	/**
	 * Set's the schema to the latest migration
	 *
	 * @access	public
	 * @return	mixed	TRUE if already latest, FALSE if failed, int if upgraded
	 */
	public function latest()
	{
		$version = $this->_migrations_version;
		return $this->version($version);
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves current schema version
	 *
	 * @access	private
	 * @return	integer	Current Schema version
	 */
	private function _get_schema_version()
	{
		$row = $this->_ci->db->get('schema_version')->row();
		return $row ? $row->version : 0;
	}

	// --------------------------------------------------------------------

	/**
	 * Stores the current schema version
	 *
	 * @access	private
	 * @param $schema_version integer	Schema version reached
	 * @return	void					Outputs a report of the migration
	 */
	private function _update_schema_version($schema_version)
	{
		return $this->_ci->db->update('schema_version', array(
			'version' => $schema_version
		));
	}
}