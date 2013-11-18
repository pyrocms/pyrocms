<?php

use Pyro\Module\Streams_core\FieldTypeManager;
use Pyro\Module\Streams_core\EntryModel;
use Pyro\Module\Streams_core\EntryUi;
use Pyro\Module\Streams_core\StreamModel;
use Pyro\Module\Variables\VariableEntryModel;

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
		EntryUi::table('Pyro\Module\Variables\VariableEntryModel')
			->title(lang('variables:name').$form)
			->buttons($buttons)
			->filters(array('name'))
			->fields(array(
				'name',
				'data' => array(
					'format' => 'string',
					'template' => '{{ entry:data }} <span class="muted">{{ entry:data_field_slug }}</span>'
				),
				'lang:streams:column_syntax' => '<span class="syntax">&#123;&#123; variables:{{ entry:name }} &#125;&#125;</span>'
			))
			->redirect('admin/variables')
			->render();
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
			$defaults['data_field_slug'] = $field_slug;
		}

		EntryUi::form('Pyro\Module\Variables\VariableEntryModel')
			->title(lang('variables:create_title').$form)
			->successMessage(lang('variables:add_success'))
			->defaults($defaults)
			->redirect('admin/variables')
			->render();
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

		$variable = VariableEntryModel::find($id);

		$form = $this->selectable_fields_form($variable, '---', true);

		EntryUi::form($variable)
			->title('Edit '.$form)
			->successMessage(sprintf(lang('variables:edit_success'), $variable->name))
			->redirect('admin/variables')
			->render();
	}

	/**
	 * Delete an existing variable
	 *
	 * @param	int $id The ID of the variable
	 */
	public function delete($id = null)
	{
		$variable = VariableEntryModel::find($id);

		$name = $variable->name;

		if ($variable and $variable->delete())
		{
			$this->session->set_flashdata('success', sprintf(lang('variables:delete_success'), $name));

			redirect('admin/variables');
		}
	}

		/**
	 * Generate a selectable fields form
	 */
	private function selectable_fields_form($field_slug = null)
	{
		$stream = StreamModel::findBySlugAndNamespace('variables', 'variables');

		$field_type = FieldTypeManager::getType('field');

		$field_type->setStream($stream);

		$options = $field_type->getSelectableFields('variables');

		if ( ! $field_slug)
		{
			$unselected = array('---' => '---');

			$options = array_merge($unselected, $options);
		}

		$js = 'onchange="javascript:var field_slug = $(this).val(); if (field_slug != \'---\') { window.open(SITE_URL+\'admin/variables/create/\'+field_slug, \'_self\'); }"';

		return '<span class="variables-selectable-fields-form">'.lang('streams:label.field').' '.form_dropdown('data', $options, $field_slug, $js).'</span>';
	}
}