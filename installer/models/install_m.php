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
	public function set_default_structure(Connection $db, $input)
	{
		// Include migration config to know which migration to start from
		require PYROPATH.'config/migration.php';

		$schema = $db->getSchemaBuilder();

		// TODO KIIIIILLLL... MEEEEEE...!
		$pdo = $db->getPdo();
		$pdo->exec('DROP TABLE core_users');
		$pdo->exec('DROP TABLE core_settings');
		$pdo->exec('DROP TABLE core_sites');
		$pdo->exec('DROP TABLE IF EXISTS '.$pdo->quote($input['site_ref']).'_modules');
		$pdo->exec('DROP TABLE IF EXISTS '.$pdo->quote($input['site_ref']).'_migrations');
		$pdo->exec('DROP TABLE IF EXISTS '.$pdo->quote($input['site_ref']).'_users');
		$pdo->exec('DROP TABLE IF EXISTS '.$pdo->quote($input['site_ref']).'_profile');

		// Create core_settings first
		$schema->create('core_settings', function($table) {
		    $table->string('slug', 30)->primary();
		    $table->text('default');
		    $table->text('value');

		    $table->unique('slug');
		    $table->index('slug');
		});
	
		// Populate core settings
		$db->table('core_settings')->insert(array(
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
		    $table->increments('id')->primary();
		    $table->text('name', 100);
		    $table->text('ref', 20);
		    $table->text('domain', 100);
		    $table->bool('active')->default(1);
		    $table->integer('created_on');
		    $table->integer('updated_on')->nullable();

		    $table->unique('ref');
		    $table->unique('domain');
		    $table->index('ref');
		    $table->index('domain');
		});

		// User Table is used for site users and core users
		$user_table = function($table) {
		    $table->increments('id')->primary();
		    $table->string('username', 20);
		    $table->string('email', 60);
		    $table->string('password', 40);
		    $table->string('salt', 6);
		    $table->integer('group_id')->nullable();
		    $table->string('ip_address');
		    $table->bool('active')->default(1);
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
		$password = sha1($input['password'].$salt);

		$user_data = array(
			'username'    => $input['username'],
			'email'       => $input['email'],
			'password'    => $password,
			'salt'        => $salt,
			'group_id'    => 1,
			'ip_address'  => $this->input->ip_address(),
			'active'      => true,
			'created_on'  => time(),
		);

		// Create User tables
		$schema->create('core_users', $user_table);
		$schema->create($input['site_ref'].'_users', $user_table);

		// Insert our new user to both
		$db->table('core_users')->insert($user_data);
		$db->table($input['site_ref'].'_users')->insert($user_data);

		// Site Profiles
		$schema->create('core_sites', function($table) {
		    $table->increments('id')->primary();
		    $table->text('name', 100);
		    $table->text('ref', 20);
		    $table->text('domain', 100);
		    $table->bool('active')->default(1);
		    $table->integer('created_on');
		    $table->integer('updated_on')->nullable();

		    $table->unique('ref');
		    $table->unique('domain');
		    $table->index('ref');
		    $table->index('domain');
		});

		// Profiles
		$schema->create($input['site_ref'].'_profiles', function($table) {
		    $table->increments('id')->primary();
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
		$db->table($input['site_ref'].'_profiles')->insert(array(
			'user_id'       => 1,
			'first_name'    => $input['firstname'],
			'last_name'     => $input['lastname'],
			'display_name'  => $input['firstname'].' '.$input['lastname'],
			'lang'          => 'en',
		));

		// Migrations
		$schema->create($input['site_ref'].'_migrations', function($table) {
		    $table->integer('version');
		});

		$db->table($input['site_ref'].'_profiles')->insert(array(
			'version' => $config['migration_version'],
		));

CREATE TABLE `{site_ref}_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `slug` varchar(50) NOT NULL,
  `version` varchar(20) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `skip_xss` tinyint(1) NOT NULL,
  `is_frontend` tinyint(1) NOT NULL,
  `is_backend` tinyint(1) NOT NULL,
  `menu` varchar(20) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `installed` tinyint(1) NOT NULL,
  `is_core` tinyint(1) NOT NULL,
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  INDEX `enabled` (`enabled`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE config_item('sess_table_name') (
 `session_id` varchar(40) DEFAULT '0' NOT NULL,
 `ip_address` varchar(16) DEFAULT '0' NOT NULL,
 `user_agent` varchar(120) NOT NULL,
 `last_activity` int(10) unsigned DEFAULT 0 NOT NULL,
 `user_data` text NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


		$schema->create('settings', function($table) {
		    $table->string('slug', 30);
		    $table->string('title', 100);
		    $table->text('description');
		    $table->enum('type',array('text','textarea','password','select','select-multiple','radio','checkbox'));
		    $table->text('default');
		    $table->text('value');
		    $table->string('options', 255);
		    $table->boolean('is_required');
		    $table->boolean('is_gui');
		    $table->string('module', 50);
		    $table->integer('order')->default(0);

		    $table->unique('slug', 'index_slug');
		});
	}

}