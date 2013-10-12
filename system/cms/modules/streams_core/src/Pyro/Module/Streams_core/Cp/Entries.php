<?php namespace Pyro\Module\Streams_core\Cp;

// The CP driver is broken down into more logical classes

use Closure;
use Pyro\Module\Streams_core\Data;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Module\Streams_core\Core\Support\AbstractCp;

class Entries extends AbstractCp
{
	/**
	 * Search index params or false
	 * @var mixed
	 */
	protected $index = false;

	/**
	 * Set the auto index params or false
	 * @param  mixed $params $params array or false
	 * @return object          [description]
	 */
	public function index($params = false)
	{
		$this->index = $params;

		return $this;
	}

	/**
	 * Entries Table
	 *
	 * Creates a table of entries.
 	 *
	 * @param	string - the stream slug
	 * @param	string - the stream namespace slug
	 * @param	[mixed - pagination, either null for no pagination or a number for per page]
	 * @param	[null - pagination uri without offset]
	 * @param	[bool - setting this to true will take care of the $this->template business
	 * @param	[array - extra params (see below)]
	 * @return	mixed - void or string
	 *
	 * Extra parameters to pass in $extra array:
	 *
	 * title	- Title of the page header (if using view override)
	 *			$extra['title'] = 'Streams Sample';
	 * 
	 * buttons	- an array of buttons (if using view override)
	 *			$extra['buttons'] = array(
	 *				'label' 	=> 'Delete',
	 *				'url'		=> 'admin/streams_sample/delete/-entry_id-',
	 *				'confirm'	= true
	 *			);
	 * columns  - an array of field slugs to display. This overrides view options.
	 * 			$extra['columns'] = array('field_one', 'field_two');
	 *
 	 * sorting  - bool. Whether or not to turn on the drag/drop sorting of entries. This defaults
 	 * 			to the sorting option of the stream.
	 *
	 * see docs for more explanation
	 */
	public static function table($stream_slug, $stream_namespace, $pagination = null, $pagination_uri = null, $extra = array())
	{	
		// Prepare the stream, model and render method
		$instance = static::instance(__FUNCTION__);

		$instance->model = Model\Entry::stream($stream_slug, $stream_namespace)->enableEagerFieldRelations(true);

		$instance->data->stream = $instance->model->getStream();

  		$instance->fields = $instance->model->getFields();

  		$instance->field_slugs = $instance->fields->getFieldSlugs();

  		//$instance->columns = $instance->standard_columns = $instance->model->getStandardColumns();

  		$instance->stream_fields = new \stdClass;

/*  		foreach ($instance->fields as $field)
  		{
  			$instance->stream_fields->{$field->field_slug} = $field;
  		}*/

  		// -------------------------------------
		// Sorting
		// @since 2.1.5
		// -------------------------------------

		if ($instance->data->stream->sorting == 'custom' or (isset($extra['sorting']) and $extra['sorting'] === true))
		{
			$instance->data->stream->sorting = 'custom';

			// As an added measure of obsurity, we are going to encrypt the
			// slug of the module so it isn't easily changed.
			ci()->load->library('encrypt');

			// We need some variables to use in the sort.
			ci()->template->append_metadata('<script type="text/javascript" language="javascript">var stream_id='.$instance->data->stream->id.'; var stream_offset='.$offset.'; var streams_module="'.ci()->encrypt->encode(ci()->module_details['slug']).'";
				</script>');
			ci()->template->append_js('streams/entry_sorting.js');
		}
 
 		
 		// -------------------------------------
		// Filter API
		// -------------------------------------

		if (ci()->input->get('filter-'.$instance->data->stream->stream_slug))
		{
			// Get all URL variables
			$url_variables = ci()->input->get();

			$processed = array();

			// Loop and process
			foreach ($url_variables as $filter => $value)
			{
				// -------------------------------------
				// Filter API Params
				// -------------------------------------
				// They all start with f-
				// No value? No soup for you!
				// -------------------------------------

				if (substr($filter, 0, 2) != 'f-') continue;	// Not a filter API parameter

				if (strlen($value) == 0) continue;				// No value.. boo

				$filter = substr($filter, 2);					// Remove identifier


				// -------------------------------------
				// Not
				// -------------------------------------
				// Default: false
				// -------------------------------------

				$not = substr($filter, 0, 4) == 'not-';

				if ($not) $filter = substr($filter, 4);			// Remove identifier


				// -------------------------------------
				// Exact
				// -------------------------------------
				// Default: false
				// -------------------------------------

				$exact = substr($filter, 0, 6) == 'exact-';

				if ($exact) $filter = substr($filter, 6);		// Remove identifier


				// -------------------------------------
				// Construct the where segment
				// -------------------------------------

				if ($exact)
				{
					if ($not)
					{
						$instance->where[] = $instance->data->stream->stream_prefix.$instance->data->stream->stream_slug.'.'.$filter.' != "'.urldecode($value).'"';
					}
					else
					{
						$instance->where[] = $instance->data->stream->stream_prefix.$instance->data->stream->stream_slug.'.'.$filter.' = "'.urldecode($value).'"';
					}
				}
				else
				{
					if ($not)
					{
						$instance->where[] = $instance->data->stream->stream_prefix.$instance->data->stream->stream_slug.'.'.$filter.' NOT LIKE "%'.urldecode($value).'%"';
					}
					else
					{
						$instance->where[] = $instance->data->stream->stream_prefix.$instance->data->stream->stream_slug.'.'.$filter.' LIKE "%'.urldecode($value).'%"';
					}
				}
			}
		}

		$filter_data = array();

 		// -------------------------------------
		// Get Entries
		// -------------------------------------
		
		$limit = ($instance->pagination) ? $pagination : null;



		// -------------------------------------
		// Pagination
		// -------------------------------------

		foreach ($filter_data as $filter)
		{
			ci()->db->where($filter, null, false);
		}
		
		// -------------------------------------
		// Build Pages
		// -------------------------------------
		
		// Set title
/*		if (isset($extra['title']))
		{
			ci()->template->title(lang_label($extra['title']));
		}*/

		// Set custom no data message
		if (isset($extra['no_entries_message']))
		{
			$instance->data->no_entries_message = $extra['no_entries_message'];
		}

		return $instance;
	}

	protected function renderTable($return = false)
	{		
		$this->data->stream_fields 	= $this->model->getFields();

		$this->data->buttons		= $this->buttons;

		$this->data->filters 		= isset($extra['filters']) ? $extra['filters'] : null;

		$this->data->search_id 		= isset($_COOKIE['streams_core_filters']) ? $_COOKIE['streams_core_filters'] : null;

		// Allow to modify the query before we execute it
		if ($model = $this->fireOnQuery($this->model))
		{
			$this->model = $model;
		}

		$this->model = $this->model->take($this->limit)->skip($this->offset);

  		$this->data->entries 		= $this->model->get($this->columns, $this->exclude);

 		$this->data->view_options 	= $this->model->getModel()->getViewOptions();

  		$this->data->field_names 	= $this->model->getModel()->getViewOptionsFieldNames();

  		// @todo - fix pagination

		if ($this->limit > 0)
		{
			$this->data->pagination = $this->getPagination($this->model->count());
		}
		else
		{
			$this->data->pagination = null;
		}

		$table = ci()->load->view('admin/partials/streams/entries', $this->data, true);

		if ( ! $return)
		{
			// Hooray, we are building the template ourself.
			ci()->template->build('admin/partials/blank_section', array('content' => $table));
		}
		else
		{
			// Otherwise, we are returning the table
			return $table;
		}
	}

	/**
	 * [form description]
	 * @param  string|Pyro\Module\Streams_core\Core\Model\Entry $mixed            [description]
	 * @param  [type] $stream_namespace [description]
	 * @param  [type] $id               [description]
	 * @return [type]                   [description]
	 */
	public static function form($mixed, $stream_namespace = null, $id = null)
	{	
		// Load up things we'll need for the form
		ci()->load->library(array('form_validation'));

		// Prepare the stream, model and render method
		$instance = static::instance(__FUNCTION__);

		if ($mixed instanceof Model\Entry and $mixed->getKey())
		{
			$instance->model = $mixed->getModel();

			$instance->entry = $mixed->unformatted();
		}
		else
		{
			$instance->model = Model\Entry::stream($mixed, $stream_namespace);

			if ($id)
			{
				$instance->entry = $instance->model->setFormat(false)->find($id);
			}
			else
			{
				$instance->entry = $instance->model->setFormat(false);
			}
		}

		return $instance;	
	}

	/**
	 * Render the form
	 * @return string The rendered HTML
	 */
	public function renderForm()
	{
		$this->fireOnSaving($this->entry);

		$this->form = $this->entry->newFormBuilder();
		$this->form->setDefaults($this->defaults);
		$this->form->enablePost($this->enable_post);
		$this->form->successMessage($this->success_message);
		$this->form->redirect($this->return);

		$this->data->stream 	= $this->entry->getStream();
		$this->data->tabs		= $this->tabs;
		$this->data->hidden 	= $this->hidden;
		$this->data->defaults	= $this->defaults;
		$this->data->entry		= $this->entry;
		$this->data->mode		= $this->mode;
		$this->data->fields		= $this->form->buildForm();

		if ($saved = $this->form->result() and $this->enable_post)
		{
			$this->fireOnSaved($saved);
		
			if ($this->return)
			{
				$url = ci()->parser->parse_string($this->return, $saved->toArray(), true);

				$url = str_replace('-id-', $saved->getKey(), $url);					
			}
			else
			{
				$url = current_url();
			}

			redirect($url);
		}

		// Set return uri
		$this->data->return	= $this->return;
    	
    	$this->data->form_url  = $_SERVER['QUERY_STRING'] ? uri_string().'?'.$_SERVER['QUERY_STRING'] : uri_string();

		// Set the no fields mesage. This has a lang default.
		$this->data->no_fields_message	= $this->no_fields_message;

		if (empty($this->data->tabs))
		{
			$form = ci()->load->view('admin/partials/streams/form', $this->data, true);
		}
		else
		{
			$available_fields = $this->entry->getFieldSlugs(); 

			$this->data->tabs = $this->distributeFields($this->data->tabs, $available_fields);

			$form = ci()->load->view('admin/partials/streams/tabbed_form', $this->data, true);
		}
		
		if ($this->view_override === false) return $form;
		
		$this->data->content = $form;

		ci()->template->build('admin/partials/blank_section', $this->data);
	}

	/**
	 * Distribute fields across tabs
	 * @param  array  $tabs             
	 * @param  array  $available_fields 
	 * @return array
	 */
	protected function distributeFields($tabs = array(), $available_fields = array())
	{
		foreach ($tabs as &$tab)
		{
			if ( ! empty($tab['fields']) and is_array($tab['fields']))
			{
				foreach ($tab['fields'] as $field)
				{
					if (isset($available_fields[$field])) unset($available_fields[$field]);
				}
			}
		}

		foreach ($tabs as &$tab)
		{
			if ( ! empty($tab['fields']) and $tab['fields'] === '*')
			{
				$tab['fields'] = $available_fields;

				break;
			}
		}

		return $tabs;
	}
}
