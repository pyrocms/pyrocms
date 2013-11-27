<?php

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Streams_core\StreamModel;
use Pyro\Module\Streams_core\FieldModel;
use Pyro\Module\Streams_core\SchemaUtility;

/**
 * @package 	PyroCMS\Core\Modules\Routes
 * @author  	Ryan Thompson - AI Web Systems, Inc.
 * @copyright   Copyright (c) 2008 - 2013, AI Web Systems, Inc.
 * @license     http://aiwebsystems.com/docs/license
 * @link        http://aiwebsystems.com/
 */
class Module_Routes extends AbstractModule
{

	public $version = '1.1';



	/**
	 * Return module information
	 * @return array
	 */
	public function info()
	{
		// Module information
		$info =  array(
			'name' => array(
				'en' => 'Routes'
			),
			'description' => array(
				'en' => 'Manage custom routes.'
			),
			'skip_xss' => false,
			'frontend' => false,
			'backend' => true,
			'menu' => 'structure',
			'sections' => array()
			/*'roles' => array(
				'upload_file',
				'download_file',
				),*/
			);


		// Routes
		$info['sections']['routes'] =  array(
			'name' 	=> 'routes:section.routes',
			'uri' 	=> 'admin/routes',
			'shortcuts' => array(
				'add_route' => array(
					'name' 	=> 'global:add',
					'uri' 	=> 'admin/routes/create',
					'class' => 'btn-sm btn-success'
					),
				),
			);

		return $info;
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
		// Clean house
		self::uninstall($pdb, $schema);



		/* Install Streams Data
		----------------------------------------------------------------------------*/

		// Add Contacts
		StreamModel::addStream(
			$slug = 'routes',
			$namespace = 'routes',
			$name = 'Routes',
			$prefix = '',
			$about = NULL,
			$extra = array('title_column' => 'name')
			);

		

		// Build the fields
		$fields = array(
			array(
				'name'			=> 'lang:routes:module',
				'slug'			=> 'module',
				'namespace'		=> 'routes',
				'locked'		=> true,
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:routes:name',
				'slug'			=> 'name',
				'namespace'		=> 'routes',
				'locked'		=> true,
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:routes:route_key',
				'slug'			=> 'route_key',
				'namespace'		=> 'routes',
				'locked'		=> true,
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:routes:route_value',
				'slug'			=> 'route_value',
				'namespace'		=> 'routes',
				'locked'		=> true,
				'type'			=> 'text',
				),
			);

		// Add all the fields
		FieldModel::addFields($fields, null, 'routes');



		/* Routes assignments
		-----------------------------------------------------------*/
		FieldModel::assignField('routes', 'routes', 'module',		array('instructions' => 'lang:routes:instructions.module'));
		FieldModel::assignField('routes', 'routes', 'name',			array('is_unique' => true, 'instructions' => 'lang:routes:instructions.name'));
		FieldModel::assignField('routes', 'routes', 'route_key',	array('is_required' => true, 'instructions' => 'lang:routes:instructions.route_key'));
		FieldModel::assignField('routes', 'routes', 'route_value',	array('is_required' => true, 'instructions' => 'lang:routes:instructions.route_value'));



		// Good to go
		return true;
	}

	/**
	 * Uninstall
	 *
	 * This function is run to uninstall the module
	 *
	 * @return bool
	 */
	public function uninstall($pdb, $schema)
	{
		// Remove namespace and kill everyone
		SchemaUtility::destroyNamespace('routes');
		
		return true;
	}

	/**
	 * Upgrade migrations
	 * @param  string $old_version Decimal of the version type
	 * @return bool
	 */
	public function upgrade($old_version)
	{
		return true;
	}

	/**
	 * Admin menu hook
	 * @param  array &$menu
	 * @return void
	 */
	public function admin_menu(&$menu)
	{
		// Do nothing!
	}

	/**
	 * Halp
	 * @return string
	 */
	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return 'http://docs.pyrocms.com/2.3/manual/modules/routes';
	}
}
