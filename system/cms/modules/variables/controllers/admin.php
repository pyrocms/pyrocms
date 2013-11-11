<?php

use Pyro\Module\Streams_core\Cp;
use Pyro\Module\Streams_core\Core\Field;
use Pyro\Module\Streams_core\Core\Model\Entry;
use Pyro\Module\Streams_core\Core\Model\Stream;
use Pyro\Module\Variables\Model\Variable;

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
		Cp\Entries::table('Pyro\Module\Variables\Model\Variable')
			->title(lang('variables:name').$form)
			->buttons($buttons)
			->filters(array('name'))
			->fields(array(
				'name',
				'data',
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
			$defaults['data'] = $field_slug;
		}

		Cp\Entries::form('Pyro\Module\Variables\Model\Variable')
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

		$variable = Variable::find($id);

		$form = $this->selectable_fields_form($variable, '---', true);

		Cp\Entries::form($variable)
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
		$variable = Variable::find($id);

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
		$stream = Stream::findBySlugAndNamespace('variables', 'variables');

		$field_type = Field\Type::getType('field');

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