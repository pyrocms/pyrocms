<?php

use Pyro\Module\Addons\AbstractModule;

/**
 * PyroStreams Core Module
 *
 * @package        PyroCMS\Core\Modules\Streams Core
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Module_Streams_core extends AbstractModule
{
	public $version = '1.3.0';

	/**
	 * Module Info
	 *
	 * @return array
	 */
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Streams Core',
				'pt' => 'Núcleo Fluxos',
				'el' => 'Πυρήνας Ροών',
                'fa' => 'هسته استریم ها',
                'fr' => 'Noyau Flux',
                'fi' => 'Striimit ydin',
				'se' => 'Streams grundmodul',
				'tw' => 'Streams 核心',
				'cn' => 'Streams 核心',
				'ar' => 'الجداول الأساسية',
				'it' => 'Streams Core',
			),
			'description' => array(
				'en' => 'Core data module for streams.',
				'pt' => 'Módulo central de dados para fluxos.',
                'fa' => 'ماژول مرکزی برای استریم ها',
                'fi' => 'Ydin datan hallinoiva moduuli striimejä varten.',
				'fr' => 'Noyau de données pour les Flux.',
				'el' => 'Προγραμματιστικός πυρήνας για την λειτουργία ροών δεδομένων.',
				'se' => 'Streams grundmodul för enklare hantering av data.',
				'tw' => 'Streams 核心資料模組。',
				'cn' => 'Streams 核心资料模组。',
				'ar' => 'وحدة البيانات الأساسية للجداول',
				'it' => 'Core dello Stream',
			),
			'frontend' => false,
			'backend' => false,
			'skip_xss' => true,
			'author' => 'Parse19',
		);
	}

	/**
     * Install
     *
     * This function is run to install the module
     *
     * @return bool
     */
    public function install($pdb, $schema)
	{
		if ( ! ($config = $this->loadConfig())) {
			return false;
		}

		// Streams Table
        $schema->dropIfExists($config['streams:streams_table']);

        $schema->create($config['streams:streams_table'], function($table) {
            $table->increments('id');
            $table->string('stream_name', 60);
            $table->string('stream_slug', 60);
            $table->string('stream_namespace', 60)->nullable();
            $table->string('stream_prefix', 60)->nullable();
            $table->string('about', 255)->nullable();
            $table->binary('view_options');
            $table->string('title_column', 255)->nullable();
            $table->enum('sorting', array('title', 'custom'))->default('title');
            $table->text('permissions');
            $table->enum('is_hidden', array('yes','no'))->default('no');
            $table->string('menu_path', 255)->nullable();
        });

        // Fields Table
        $schema->dropIfExists($config['streams:fields_table']);

        $schema->create($config['streams:fields_table'], function($table) {
            $table->increments('id');
            $table->string('field_name', 60);
            $table->string('field_slug', 60);
            $table->string('field_namespace', 60)->nullable();
            $table->string('field_type', 50);
            $table->binary('field_data')->nullable();
            $table->binary('view_options')->nullable();
            $table->enum('is_locked', array('yes', 'no'))->default('no');
        });

        // Assignments Table
        $schema->dropIfExists($config['streams:assignments_table']);

        $schema->create($config['streams:assignments_table'], function($table) {
            $table->increments('id');
            $table->integer('sort_order');
            $table->integer('stream_id');
            $table->integer('field_id');
            $table->enum('is_required', array('yes', 'no'))->default('no');
            $table->enum('is_unique', array('yes', 'no'))->default('no');
            $table->text('instructions')->nullable();
            $table->string('field_name', 60);

            // $table->foreign('stream_id'); //TODO Set up foreign keys
            // $table->foreign('field_id'); //TODO Set up foreign keys
        });

        // Forms Table
        $schema->dropIfExists($config['streams:forms_table']);

        $schema->create($config['streams:forms_table'], function($table) {
            $table->increments('id');
            $table->string('namespace', 100);
            $table->string('stream', 100);
            $table->string('slug', 100);
            $table->text('form_structure')->nullable();
        });

        // Views Table
        $schema->dropIfExists($config['streams:views_table']);

        $schema->create($config['streams:views_table'], function($table) {
            $table->increments('id');
            $table->string('namespace', 100);
            $table->string('stream', 100);
            $table->string('slug', 100);
            $table->string('title', 100);
            $table->enum('is_locked', array('yes', 'no'))->default('no');
            $table->string('order_by', 100);
            $table->enum('sort', array('ASC', 'DESC'))->default('ASC');
            $table->text('search')->nullable();
            $table->text('columns')->nullable();
            $table->text('filters')->nullable();
        });

		return true;
	}

	/**
	 * Uninstall Streams Core
	 *
	 * This is a very dangerous function. It removes the core streams tables so
	 * watch out.
	 *
	 * @return bool
	 */
	public function uninstall($pdb, $schema)
	{
		if ( ! ($config = $this->loadConfig())) {
			return false;
		}

		// Streams Table
        $schema->dropIfExists($config['streams:streams_table']);
        $schema->dropIfExists($config['streams:fields_table']);
        $schema->dropIfExists($config['streams:assignments_table']);
        $schema->dropIfExists($config['streams:searches_table']);

		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}

	/**
	 * Manually load config that has all of our streams table data.
	 *
	 * @return mixed False or the config array
	 */
	private function loadConfig()
	{
		if (defined('PYROPATH')) {
			require_once(PYROPATH.'modules/streams_core/config/streams.php');
		} elseif (defined('APPPATH')) {
			require_once(APPPATH.'modules/streams_core/config/streams.php');
		}

		return (isset($config)) ? $config : false;
	}
}
