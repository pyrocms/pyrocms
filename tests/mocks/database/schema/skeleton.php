<?php

class Mock_Database_Schema_Skeleton {

	/**
	 * @var object Database Holder
	 */
	public static $db;

	/**
	 * @var object Forge Holder
	 */
	public static $forge;

	/**
	 * @var object Driver Holder
	 */
	public static $driver;

	/**
	 * Initialize both database and forge components
	 */
	public static function init($driver)
	{
		if (empty(static::$db) && empty(static::$forge))
		{
			$config = Mock_Database_DB::config($driver);
			$connection = new Mock_Database_DB($config);
			$db = Mock_Database_DB::DB($connection->set_dsn($driver), TRUE);

			CI_TestCase::instance()->ci_instance_var('db', $db);

			$loader = new Mock_Core_Loader();
			$loader->dbforge();
			$forge = CI_TestCase::instance()->ci_instance_var('dbforge');

			static::$db = $db;
			static::$forge = $forge;
			static::$driver = $driver;
		}

		return static::$db;
	}

	/**
	 * Create the dummy tables
	 *
	 * @return void
	 */
	public static function create_tables()
	{
		// User Table
		static::$forge->add_field(array(
			'id' => array(
				'type' => 'INTEGER',
				'constraint' => 3
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 40
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'country' => array(
				'type' => 'VARCHAR',
				'constraint' => 40
			)
		));
		static::$forge->add_key('id', TRUE);
		static::$forge->create_table('user', (strpos(static::$driver, 'pgsql') === FALSE));

		// Job Table
		static::$forge->add_field(array(
			'id' => array(
				'type' => 'INTEGER',
				'constraint' => 3
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 40
			),
			'description' => array(
				'type' => 'TEXT'
			)
		));
		static::$forge->add_key('id', TRUE);
		static::$forge->create_table('job', (strpos(static::$driver, 'pgsql') === FALSE));

		// Misc Table
		static::$forge->add_field(array(
			'id' => array(
				'type' => 'INTEGER',
				'constraint' => 3
			),
			'key' => array(
				'type' => 'VARCHAR',
				'constraint' => 40
			),
			'value' => array(
				'type' => 'TEXT'
			)
		));
		static::$forge->add_key('id', TRUE);
		static::$forge->create_table('misc', (strpos(static::$driver, 'pgsql') === FALSE));
	}

	/**
	 * Create the dummy datas
	 *
	 * @return void
	 */
	public static function create_data()
	{
		// Job Data
		$data = array(
			'user' => array(
				array('id' => 1, 'name' => 'Derek Jones', 'email' => 'derek@world.com', 'country' => 'US'),
				array('id' => 2, 'name' => 'Ahmadinejad', 'email' => 'ahmadinejad@world.com', 'country' => 'Iran'),
				array('id' => 3, 'name' => 'Richard A Causey', 'email' => 'richard@world.com', 'country' => 'US'),
				array('id' => 4, 'name' => 'Chris Martin', 'email' => 'chris@world.com', 'country' => 'UK')
			),
			'job' => array(
				array('id' => 1, 'name' => 'Developer', 'description' => 'Awesome job, but sometimes makes you bored'),
				array('id' => 2, 'name' => 'Politician', 'description' => 'This is not really a job'),
    				array('id' => 3, 'name' => 'Accountant', 'description' => 'Boring job, but you will get free snack at lunch'),
				array('id' => 4, 'name' => 'Musician', 'description' => 'Only Coldplay can actually called Musician')
			),
			'misc' => array(
				array('id' => 1, 'key' => '\\xxxfoo456', 'value' => 'Entry with \\xxx'),
				array('id' => 2, 'key' => '\\%foo456', 'value' => 'Entry with \\%')
			)
		);

		foreach ($data as $table => $dummy_data)
		{
			static::$db->truncate($table);

			foreach ($dummy_data as $single_dummy_data)
			{
				static::$db->insert($table, $single_dummy_data);
			}
		}
	}

}