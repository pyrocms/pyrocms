<?php
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
		// @todo - add buttons to manage fields
		$extra['buttons'] = array();

		$extra['title'] = lang('variables:fields_title');

		$this->streams->cp->fields_table('variables', null, null, true, $extra, array('name', 'syntax', 'data'));
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