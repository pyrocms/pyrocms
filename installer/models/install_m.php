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
		// @TODO Upgrade sha1 to password_hash()
		$salt = substr(md5(uniqid(rand(), true)), 0, 5);
		$password = sha1($input['password'].$salt);

		// Include migration config to know which migration to start from
		require PYROPATH.'config/migration.php';

		$schema = $db->getSchemaBuilder();

		// TODO KIIIIILLLL... MEEEEEE...!
		$pdo = $db->getPdo();
		$pdo->exec('DROP TABLE core_users');
		$pdo->exec('DROP TABLE core_settings');
		$pdo->exec('DROP TABLE core_sites');
		$pdo->exec('DROP TABLE '.$pdo->quote($input['site_ref']).'_modules');
		$pdo->exec('DROP TABLE '.$pdo->quote($input['site_ref']).'_migrations');
		$pdo->exec('DROP TABLE '.$pdo->quote($input['site_ref']).'_users');

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

		// Domains
		$schema->create('core_sites', function($table) {
		    $table->increments()->primary();
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

		// Domains
		$schema->create($input['site_ref'].'_users', function($table) {
		    $table->increments()->primary();
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
		});


		// '{site_ref}' 	=> $input['site_ref'],
		// '{session_table}' => config_item('sess_table_name'),

		// ':email'        => $pdo->quote(),
		// ':username'     => $pdo->quote(),
		// ':displayname'  => $pdo->quote(),
		// ':password'     => $pdo->quote($input['password']),
		// ':firstname'    => $pdo->quote($input['firstname']),
		// ':lastname'     => $pdo->quote($input['lastname']),
		// ':salt'         => $pdo->quote($salt),
		// ':unix_now'     => time(),
		// ':migration'    => $config['migration_version'],
	
		// Populate first user
		$db->table($input['site_ref'].'_users')->insert(array(
			`username`         => $input['username'],
			`email`            => $input['email'],
			`password`         => $password,
			`salt`             => $salt,
			`group_id`         => 1,
			`ip_address`       => $this->input->ip_address(),
			`active`           => true,
			`created_on`       => time(),
		));


CREATE TABLE `core_users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salt` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_id` int(11) DEFAULT NULL,
  `ip_address` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `activation_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotten_password_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Super User Information';

INSERT INTO core_users SELECT * FROM {site_ref}_users;

DROP TABLE IF EXISTS `{site_ref}_profiles`;

CREATE TABLE `{site_ref}_profiles` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `display_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `bio` text COLLATE utf8_unicode_ci,
  `dob` int(11) DEFAULT NULL,
  `gender` set('m','f','') COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

INSERT INTO `{site_ref}_profiles` (`id`, `user_id`, `first_name`, `last_name`, `display_name`, `company`, `lang`)
VALUES (1, 1, :firstname, :lastname, :displayname, '', 'en');

CREATE TABLE `{site_ref}_migrations` (
  `version` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO {site_ref}_migrations VALUES (:migration);

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

CREATE TABLE `{session_table}` (
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