<?php 

use Illuminate\Database\Connection;

/**
* Install model
*
* @author PyroCMS Dev Team
* @package PyroCMS\Installer\Models
*
*/
class Install_m extends CI_Model
{
	public function set_default_structure(Connection $conn, array $user, array $db)
	{
		// Include migration config to know which migration to start from
		require PYROPATH.'config/migration.php';

		$schema = $conn->getSchemaBuilder();

		// Remove any tables not installed by a module
		$schema->dropIfExists('core_users');
		$schema->dropIfExists('core_settings');
		$schema->dropIfExists('core_sites');
		$schema->dropIfExists(config_item('sess_table_name'));
		$schema->dropIfExists($db['site_ref'].'_modules');
		$schema->dropIfExists($db['site_ref'].'_migrations');
		$schema->dropIfExists($db['site_ref'].'_settings');
		$schema->dropIfExists($db['site_ref'].'_users');
		$schema->dropIfExists($db['site_ref'].'_profiles');

		// Create core_settings first
		$schema->create('core_settings', function($table) {
		    $table->string('slug', 30);
		    $table->text('default')->nullable();
		    $table->text('value')->nullable();

		    $table->unique('slug');
		    $table->index('slug');
		});
	
		// Populate core settings
		$conn->table('core_settings')->insert(array(
			array(
				'slug'    => 'date_format', 
				'default' => 'g:ia -- m/d/y',
			),
			array(
				'slug'    => 'lang_direction', 
				'default' => 'ltr',
			),
			array(
				'slug'    => 'status_message', 
				'default' => 'This site has been disabled by a super-administrator.',
			),
		));

		// Core Sites
		$schema->create('core_sites', function($table) {
		    $table->increments('id');
		    $table->string('name', 100);
		    $table->string('ref', 20);
		    $table->string('domain', 100);
		    $table->boolean('active')->default(1);
		    $table->integer('created_on');
		    $table->integer('updated_on')->nullable();

		    $table->unique('ref');
		    $table->unique('domain');
		    $table->index('ref');
		    $table->index('domain');
		});

		// User Table is used for site users and core users
		$user_table = function($table) {
		    $table->increments('id');
		    $table->string('username', 20);
		    $table->string('email', 60);
		    $table->string('password', 40);
		    $table->string('salt', 6);
		    $table->integer('group_id')->nullable();
		    $table->string('ip_address');
		    $table->boolean('active')->default(1);
		    $table->string('activation_code', 40)->nullable();
		    $table->string('forgotten_password_code', 40)->nullable();
		    $table->string('remember_code', 40)->nullable();
		    $table->integer('created_on');
		    $table->integer('updated_on')->nullable();
		    $table->integer('last_login')->nullable();

		    $table->unique('email');
		    $table->unique('username');
		    $table->index('email');
		    $table->index('username');
		};

		// @TODO Upgrade sha1 to password_hash()
		$salt = substr(md5(uniqid(rand(), true)), 0, 5);
		$password = sha1($user['password'].$salt);

		$user_data = array(
			'username'    => $user['username'],
			'email'       => $user['email'],
			'password'    => $password,
			'salt'        => $salt,
			'group_id'    => 1,
			'ip_address'  => $this->input->ip_address(),
			'active'      => true,
			'created_on'  => time(),
		);

		// Create User tables
		$schema->create('core_users', $user_table);
		$schema->create($db['site_ref'].'_users', $user_table);

		// Insert our new user to both
		$conn->table('core_users')->insert($user_data);
		$conn->table($db['site_ref'].'_users')->insert($user_data);

		$schema->create(config_item('sess_table_name'), function($table) {
		    $table->string('session_id', 40)->default(0);
		    $table->string('ip_address', 16)->default(0);
		    $table->string('user_agent', 120);
		    $table->integer('last_activity')->default(0);
		    $table->text('user_data');

		    $table->index('last_activity', 'last_activity_idx');
		});

		// HEAR YE HEAR YE, THE DB PREFIX CHANGES NOW!
		$conn->getQueryGrammar()->setTablePrefix($db['site_ref'].'_');
		$conn->getSchemaGrammar()->setTablePrefix($db['site_ref'].'_');

		// Profiles
		$schema->create('profiles', function($table) {
		    $table->increments('id');
		    $table->integer('user_id');
		    $table->string('display_name', 50); // TODO Revise these lengths
		    $table->string('first_name', 50);
		    $table->string('last_name', 50)->nullable();
		    $table->string('company', 100)->nullable();
		    $table->string('lang', 2)->default('en');
		    $table->text('bio')->nullable();
		    $table->integer('dob')->nullable();
		    $table->enum('gender', array('m', 'f', ''))->default('');
		    $table->string('phone', 20)->nullable();
		    $table->string('website', 255)->nullable();
		    $table->integer('updated_on')->nullable();

		    $table->index('user_id');
		});

		// Populate site profiles
		$conn->table('profiles')->insert(array(
			'user_id'       => 1,
			'first_name'    => $user['firstname'],
			'last_name'     => $user['lastname'],
			'display_name'  => $user['firstname'].' '.$user['lastname'],
			'lang'          => 'en',
		));

		// Migrations
		$schema->create('migrations', function($table) {
		    $table->integer('version');
		});

		// Insert current latest migration
		$conn->table('migrations')->insert(array(
			'version' => $config['migration_version'],
		));

		// Modules
		// TODO make migration to remove "type" field from here
		$schema->create('modules', function($table) {
		    $table->increments('id');
		    $table->text('name');
		    $table->string('slug', 50);
		    $table->string('version', 20);
		    $table->text('description');
		    $table->boolean('skip_xss');
		    $table->boolean('is_frontend');
		    $table->boolean('is_backend');
		    $table->string('menu', 20);
		    $table->boolean('enabled');
		    $table->boolean('installed');
		    $table->boolean('is_core');
		    $table->integer('updated_on')->nullable();

		    $table->unique('slug');
		    $table->index('enabled');
		    $table->index('is_frontend');
		    $table->index('is_backend');
		});

		$schema->create('settings', function($table) {
		    $table->string('slug', 30);
		    $table->string('title', 100);
		    $table->text('description');
		    $table->enum('type', array('text','textarea','password','select','select-multiple','radio','checkbox'));
		    $table->text('default')->nullable();
		    $table->text('value')->nullable();
		    $table->string('options', 255)->nullable();
		    $table->boolean('is_required')->default(false);
		    $table->boolean('is_gui')->default(true);
		    $table->string('module', 50)->nullable();
		    $table->integer('order')->default(0);

		    $table->unique('slug');
		    $table->index('slug');
		});
	}

}