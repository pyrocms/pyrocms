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
		$schema->dropIfExists('core_users_groups');
		$schema->dropIfExists('core_settings');
		$schema->dropIfExists('core_sites');
		$schema->dropIfExists(config_item('sess_table_name'));
		$schema->dropIfExists($db['site_ref'].'_modules');
		$schema->dropIfExists($db['site_ref'].'_migrations');
		$schema->dropIfExists($db['site_ref'].'_settings');
		$schema->dropIfExists($db['site_ref'].'_users');
		$schema->dropIfExists($db['site_ref'].'_users_groups');
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
		    $table->boolean('is_activated')->default(true);
            $table->boolean('is_blocked')->default(false);
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at')->nullable();

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
		    $table->string('password', 255);
		    $table->string('salt', 6)->nullable();
		    $table->string('ip_address');
		    $table->boolean('is_activated')->default(false);
            $table->boolean('is_blocked')->default(false);
		    $table->string('activation_code')->nullable();
		    $table->string('persist_code')->nullable();
		    $table->string('reset_password_code')->nullable();
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at')->nullable();
		    $table->dateTime('last_login')->nullable();

		    $table->unique('email');
		    $table->unique('username');
		    $table->index('email');
		    $table->index('username');
		};

		// Call upon the Mystical Hasher of Asoroth
		$hasher = new Cartalyst\Sentry\Hashing\NativeHasher;
		$password = $hasher->hash($user['password']);

		$user_data = array(
			'username'    => $user['username'],
			'email'       => $user['email'],
			'password'    => $password,
			'ip_address'  => $this->input->ip_address(),
			'is_activated'=> true,
			'created_at'  => date('Y-m-d H:i:s'),
		);

		// Create User tables
		$schema->create('core_users', $user_table);
		$schema->create($db['site_ref'].'_users', $user_table);

		// Insert our new user to both
		$conn->table('core_users')->insert($user_data);
		$conn->table($db['site_ref'].'_users')->insert($user_data);

		// Create Users Groups
		$user_groups_table = function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('group_id');
		};

		$user_groups_data = array(
			'user_id'    => 1,
			'group_id'   => 1,
		);

		// Create both User Groups tables
		$schema->create('core_users_groups', $user_groups_table);
		$schema->create($db['site_ref'].'_users_groups', $user_groups_table);

		// Insert our new user to both
		$conn->table('core_users_groups')->insert($user_groups_data);
		$conn->table($db['site_ref'].'_users_groups')->insert($user_groups_data);

		// Create Session Table
		$schema->create(config_item('sess_table_name'), function($table) {
		    $table->string('session_id', 40)->default(0);
		    $table->string('ip_address', 16)->default(0);
		    $table->string('user_agent', 120);
		    $table->integer('last_activity')->default(0);
		    $table->text('user_data');

		    $table->index('last_activity', 'last_activity_idx');
		});

		// HEAR YE HEAR YE, THE DB PREFIX CHANGES NOW!
		$conn->getSchemaGrammar()->setTablePrefix($db['site_ref'].'_');	// Set for grammer ($schema)
		$conn->setTablePrefix($db['site_ref'].'_'); // Set for connection ($conn)

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
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at')->nullable();

		    $table->unique('slug');
		    $table->index('enabled');
		    $table->index('is_frontend');
		    $table->index('is_backend');
		});

		$schema->dropIfExists('themes');

        $schema->create('themes', function($table) {
            $table->increments('id');
            $table->integer('site_id')->nullable();
            $table->string('slug');
            $table->string('name');
            $table->text('description');
            $table->string('author')->nullable();
            $table->string('author_website')->nullable();
            $table->string('website')->nullable();
            $table->string('version')->default('1.0.0');
            $table->string('type')->nullable();
            $table->boolean('enabled')->default(true);
            $table->integer('order')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });

        $schema->dropIfExists('theme_options');

        $schema->create('theme_options', function($table) {
            $table->increments('id');
            $table->string('slug', 30);
            $table->string('title', 100);
            $table->text('description');
            $table->enum('type', array('text', 'textarea', 'password', 'select', 'select-multiple', 'radio', 'checkbox', 'colour-picker'));
            $table->string('default', 255);
            $table->string('value', 255);
            $table->text('options');
            $table->boolean('is_required')->nullable();
            $table->integer('theme_id')->nullable();
        });

		$schema->create('settings', function($table) {
		    $table->string('slug', 30);
		    $table->string('title', 100);
		    $table->text('description');
		    $table->enum('type', array('text','textarea','password','select','select-multiple','radio','checkbox'))->default('text');
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

				// Streams Table
        $schema->dropIfExists('data_streams');

        $schema->create('data_streams', function($table) {
            $table->increments('id');
            $table->string('stream_name', 60);
            $table->string('stream_slug', 60);
            $table->string('stream_namespace', 60)->nullable();
            $table->string('stream_prefix', 60)->nullable();
            $table->string('about', 255)->nullable();
            $table->text('view_options');
            $table->string('title_column', 255)->nullable();
            $table->enum('sorting', array('title', 'custom'))->default('title');
            $table->text('permissions')->nullable();
            $table->enum('is_hidden', array('yes','no'))->default('no');
            $table->string('menu_path', 255)->nullable();
        });

        // Fields Table
        $schema->dropIfExists('data_fields');

        $schema->create('data_fields', function($table) {
            $table->increments('id');
            $table->string('field_name', 60);
            $table->string('field_slug', 60);
            $table->string('field_namespace', 60)->nullable();
            $table->string('field_type', 50);
            $table->text('field_data')->nullable();
            $table->text('view_options')->nullable();
            $table->enum('is_locked', array('yes', 'no'))->default('no');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });

        // Assignments Table
        $schema->dropIfExists('data_field_assignments');

        $schema->create('data_field_assignments', function($table) {
            $table->increments('id');
            $table->integer('sort_order');
            $table->integer('stream_id');
            $table->integer('field_id');
            $table->enum('is_required', array('yes', 'no'))->default('no');
            $table->enum('is_unique', array('yes', 'no'))->default('no');
            $table->text('instructions')->nullable();
            $table->string('field_name', 60)->nullable();

            // $table->foreign('stream_id'); //TODO Set up foreign keys
            // $table->foreign('field_id'); //TODO Set up foreign keys
        });
	}

}
