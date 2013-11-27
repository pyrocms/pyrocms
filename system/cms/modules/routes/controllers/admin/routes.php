<?php

use Illuminate\Support\Str;
use Pyro\Module\Streams_core\EntryUi;
use Pyro\Module\Streams_core\EntryModel;

/**
 *
 * Routes Module
 *
 * @author 		Ryan Thompson - AI Web Systems, Inc.
 * @package 	CMS
 * @subpackage 	Routes Module
 * @category 	Modules
 */
class Routes extends Admin_Controller
{
	
	// Set the section	
	protected $section = 'routes';

	// EntryUi::form hidden
	protected static $_hidden = array(
		'module',
		);

	// EntryUi::table filters
	protected static $_filters = array(
		'module',
		'name',
		);

	// EntryUi::table fields
	protected static $_fields = array(
		'module' => '{{ helper:humanize string=entry:module }}',
		'name',
		'route_key',
		'route_value',
		);

	// EntryUi::table buttons
	protected static $_buttons = array(
		array(
			'label' => 'lang:global:edit',
			'url' => 'admin/routes/edit/{{ id }}',
			'class' => 'btn-sm btn-warning',
			),
		array(
			'label' => 'lang:global:delete',
			'url' => 'admin/routes/delete/{{ id }}',
			'class' => 'btn-sm btn-danger confirm',
			),
		);

	///////////////////////////////////////////////////////////////////////////////
	// --------------------------	   METHODS 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Construct
	 */
	public function __construct()
	{
		parent::__construct();

		// Langizzle my nizzle
		$this->lang->load($this->module_details['slug']);
	}

	/**
	 * Go to entries
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Default to entries
		redirect(site_url('admin/routes/entries'));
	}

	/**
	 * List all existing routes
	 *
	 * @access public
	 * @return void
	 */
	public function entries($type = 'route', $grouping = 'all')
	{
		// Build out the UI with core
		$table = EntryUi::table('routes', 'routes')
			->title(lang('routes:routes.plural'))
			->filters(self::$_filters)
			->fields(self::$_fields)
			->buttons(self::$_buttons)
			->pagination(Settings::get('records_per_page'), 'admin/routes/entries')
			->redirect('admin/routes/entries')
			->render(false);
	}

	/**
	 * Create a new testimonial
	 * @return void 
	 */
	public function create()
	{
		EntryUi::form('routes', 'routes')
			->title(lang('global:create').' '.lang('routes:routes.singular'))
			->defaults(
				array(
					'module' => 'routes',
					)
				)
			->hidden(self::$_hidden)
			->redirect('admin/routes/edit/{{ id }}')
			->exitRedirect('admin/routes/entries')
			->createRedirect('admin/routes/create')
			->cancelUri('admin/routes/entries')
			->render();
	}

	/**
	 * Edit an existing route
	 * @param  integer $id 
	 * @return void     
	 */
	public function edit($id)
	{
		EntryUi::form('routes', 'routes', $id)
			->title(lang('global:edit').' '.lang('routes:routes.singular'))
			->hidden(self::$_hidden)
			->redirect('admin/routes/edit/{{ id }}')
			->exitRedirect('admin/routes/entries')
			->createRedirect('admin/routes/create')
			->cancelUri('admin/routes/entries')
			->render();
	}

	/**
	 * Delete testimonial
	 * @param  integer $id 
	 * @return void     
	 */
	public function delete($id)
	{
		// Delete the entry
		EntryModel::stream('routes', 'routes')->find($id)->delete();

		// Go back to entries
		redirect(site_url('admin/routes/entries'));
	}
}