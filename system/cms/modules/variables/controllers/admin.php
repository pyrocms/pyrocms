<?php

use Pyro\Module\Streams_core\Cp;
use Pyro\Module\Streams_core\Core\Field;
use Pyro\Module\Streams_core\Core\Model;

/**
 * Admin controller for the variables module
 *
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Variables\Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Variable's ID
	 *
	 * @var		int
	 */
	public $id = 0;

	public $section = 'variables';

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		$this->lang->load('variables/variables');

		$this->template->append_css('module::variables.css');
		
		$this->load->driver('Streams');
	}

	/**
	 * List all variables
	 */
	public function index()
	{
		$buttons = array(
			array(
				'label' => lang('global:edit'),
				'url'	=>'admin/variables/edit/-entry_id-'
			),
			array(
				'label' => lang('global:delete'),
				'url'	=>'admin/variables/delete/-entry_id-',
				'confirm' => true
			),
		);

		$form = $this->selectable_fields_form();

/*		$extra['title'] = lang('variables:name').$form;

		$extra['return'] = 'admin/variables';
*/
		Cp\Entries::table('variables', 'variables')
			->title(lang('variables:name').$form)
			->buttons($buttons)
			->redirect('admin/variables')
			->render();

		//$this->streams->cp->entries_table('variables', 'variables', 10, 'admin/variables/index', true, $extra);
	}

	/**
	 * Create a new variable
	 */
	public function create($field_slug = null)
	{
		$form = $this->selectable_fields_form($field_slug);

		$extra['return'] = $extra['cancel_uri'] = 'admin/variables/edit/-id-';

		$defaults = array();

		// Override selected field
		if (is_string($field_slug))
		{
			$defaults['data'] = $field_slug;
		}
		
		Cp\Entries::form('variables', 'variables')
			->title(lang('variables:create_title').$form)
			->successMessage(lang('variables:add_success'))
			->hidden(array('syntax'))
			->defaults($defaults)
			->redirect('admin/variables')
			->render();
		//$this->streams->cp->entry_form('variables', 'variables', 'new', null, true, $extra, array(), false, array('syntax'), $defaults);
	}

	/**
	 * Edit an existing variable
	 * 
	 * @param	int $id The ID of the variable
	 */
	public function edit($id = null)
	{
		// From cancel_uri?
		if ($id == '-id-') redirect(site_url('admin/variables'));

		$variable = Model\Entry::stream('variables', 'variables')->findEntry($id);

		$form = $this->selectable_fields_form($variable, '---', true);

		// This is a bit redundant but we want a nice message.
		//$variable = $this->streams->entries->get_entry($id, 'variables', 'variables');

		Cp\Entries::form($variable)
			->title('Edit '.$form)
			->successMessage(sprintf(lang('variables:edit_success'), $variable->name))
			->hidden(array('syntax'))
			->redirect('admin/variables')
			->render();
		//$this->streams->cp->entry_form('variables', 'variables', 'edit', $id, true, $extra, array(), false, array('syntax'));
	}

	/**
	 * Delete an existing variable
	 *
	 * @param	int $id The ID of the variable
	 */
	public function delete($id = null)
	{
		$variable = $this->streams->entries->get_entry($id, 'variables', 'variables');

		if ($this->streams->entries->delete_entry($id, 'variables', 'variables'))
		{
			$this->session->set_flashdata('success', sprintf(lang('variables:delete_success'), $variable->name));

			redirect('admin/variables');
		}
	}

		/**
	 * Generate a selectable fields form
	 */
	private function selectable_fields_form($field_slug = null)
	{
		$stream = Model\Stream::findBySlugAndNamespace('variables', 'variables');

		$field_type = Field\Type::getLoader()->getType('field');

		$field_type->setStream($stream);

		$options = $field_type->get_selectable_fields('variables', 'variables', 'variables');

		if ( ! $field_slug)
		{
			$unselected = array('---' => '---');

			$options = array_merge($unselected, $options);
		}

		$js = 'onchange="javascript:var field_slug = $(this).val(); if (field_slug != \'---\') { window.open(SITE_URL+\'admin/variables/create/\'+field_slug, \'_self\'); }"';

		return '<span class="variables-selectable-fields-form">'.lang('streams:label.field').' '.form_dropdown('data', $options, $field_slug, $js).'</span>';
	}
}