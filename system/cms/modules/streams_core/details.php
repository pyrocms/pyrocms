<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Core Module
 *
 * @package        PyroCMS\Core\Modules\Streams Core
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Module_Streams_core extends Module
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
				'fr' => 'Noyau Flux',
				'el' => 'Πυρήνας Ροών',
				'se' => 'Streams grundmodul',
				'tw' => 'Streams 核心',
				'cn' => 'Streams 核心',
				'ar' => 'الجداول الأساسية',
			),
			'description' => array(
				'en' => 'Core data module for streams.',
				'pt' => 'Módulo central de dados para fluxos.',
				'fr' => 'Noyau de données pour les Flux.',
				'el' => 'Προγραμματιστικός πυρήνας για την λειτουργία ροών δεδομένων.',
				'se' => 'Streams grundmodul för enklare hantering av data.',
				'tw' => 'Streams 核心資料模組。',
				'cn' => 'Streams 核心资料模组。',
				'ar' => 'وحدة البيانات الأساسية للجداول',
			),
			'frontend' => false,
			'backend' => false,
			'skip_xss' => true,
			'author' => 'Parse19',
		);
	}

	/**
	 * Install PyroStreams Core Tables
	 *
	 * @return bool
	 */
	public function install()
	{
		if ( ! ($config = $this->_load_config()))
		{
			return false;
		}

		$schema = $this->pdb->getSchemaBuilder();

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
            $table->text('instructions');
            $table->string('field_name', 60);

            // $table->foreign('stream_id'); //TODO Set up foreign keys
            // $table->foreign('field_id'); //TODO Set up foreign keys
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
	public function uninstall()
	{
		if ( ! ($config = $this->_load_config()))
		{
			return false;
		}

		$schema = $this->pdb->getSchemaBuilder();

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
	private function _load_config()
	{
		if (defined('PYROPATH'))
		{
			require_once(PYROPATH.'modules/streams_core/config/streams.php');
		}
		elseif (defined('APPPATH'))
		{
			require_once(APPPATH.'modules/streams_core/config/streams.php');
		}

		return (isset($config)) ? $config : false;
	}
}
