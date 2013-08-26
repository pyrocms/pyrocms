<?php

use Pyro\Module\Streams_core\Cp;

/**
 * Admin fields controller for the variables module
 *
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Variables\Controllers
 */
class Admin_fields extends Admin_Controller
{
	/**
	 * Variable's ID
	 *
	 * @var		int
	 */
	public $id = 0;

	public $section = 'fields';

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		$this->lang->load('variables/variables');
		
		$this->load->driver('Streams');
	}

	/**
	 * The selectable fields table
	 */
	public function index()
	{
		$buttons = array(
			array(
				'label' => lang('global:edit'),
				'url' => 'admin/variables/fields/edit/-field_id-'
			),
			array(
				'label' => lang('global:delete'),
				'url' => 'admin/variables/fields/delete/-field_id-',
				'confirm' => true
			)
		);

		Cp\Fields::namespaceTable('variables')
			->skips(array('name', 'syntax', 'data'))
			->title(lang('variables:fields_title'))
			->buttons($buttons)
			->render();

	}

	public function create()
	{

	}

	/**
	 * The field form that allows creating and configuring field instances
	 */
	public function edit()
	{
		// @todo - We need a form to manage fields in a namespace without assigning them to the stream
		// $this->streams->cp->field_form() assigns to the stream so it doesn't do what we need here
	}

	public function delete()
	{

	}
}