<?php namespace Pyro\Module\Streams_core\Cp;

// The CP driver is broken down into more logical classes

use Closure;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Module\Streams_core\Core\Support\AbstractCp;

class Entries extends AbstractCp
{
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
		$instance = static::instance(__function__);

		$instance->model = Model\Entry::stream($stream_slug, $stream_namespace);

		$instance->data['stream'] = $instance->stream = $instance->model->getStream();

 		// -------------------------------------
		// Get Header Fields
		// -------------------------------------
		
 		// $stream_fields = ci()->streams_m->get_stream_fields(static::$stream->id);

 		// We need to make sure that stream_fields is 
 		// at least an empty object.
/* 		if ( ! is_object($stream_fields))
 		{
 			$stream_fields = new stdClass;
 		}

 		$stream_fields->id = new stdClass;
  		$stream_fields->created = new stdClass;
 		$stream_fields->updated = new stdClass;
 		$stream_fields->created_by = new stdClass;

  		$stream_fields->id->field_name 				= lang('streams:id');
		$stream_fields->created->field_name 		= lang('streams:created_date');
 		$stream_fields->updated->field_name 		= lang('streams:updated_date');
 		$stream_fields->created_by->field_name 		= lang('streams:created_by');*/

  		$instance->fields = $instance->model->getFields();

  		$instance->field_slugs = $instance->fields->getFieldSlugs();

  		$instance->columns = $instance->standard_columns = $instance->fields->getStandardColumns();

  		$instance->stream_fields = new \stdClass;

  		foreach ($instance->fields as $field)
  		{
  			$instance->stream_fields->{$field->field_slug} = $field;
  		}

  		// -------------------------------------
		// Sorting
		// @since 2.1.5
		// -------------------------------------

		if ($instance->data['stream']->sorting == 'custom' or (isset($extra['sorting']) and $extra['sorting'] === true))
		{
			$instance->data['stream']->sorting = 'custom';

			// As an added measure of obsurity, we are going to encrypt the
			// slug of the module so it isn't easily changed.
			ci()->load->library('encrypt');

			// We need some variables to use in the sort.
			ci()->template->append_metadata('<script type="text/javascript" language="javascript">var stream_id='.$instance->data['stream']->id.'; var stream_offset='.$offset.'; var streams_module="'.ci()->encrypt->encode(ci()->module_details['slug']).'";
				</script>');
			ci()->template->append_js('streams/entry_sorting.js');
		}
 
 		
 		// -------------------------------------
		// Filter API
		// -------------------------------------

		if (ci()->input->get('filter-'.$instance->data['stream']->stream_slug))
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
						$instance->where[] = $instance->data['stream']->stream_prefix.$instance->data['stream']->stream_slug.'.'.$filter.' != "'.urldecode($value).'"';
					}
					else
					{
						$instance->where[] = $instance->data['stream']->stream_prefix.$instance->data['stream']->stream_slug.'.'.$filter.' = "'.urldecode($value).'"';
					}
				}
				else
				{
					if ($not)
					{
						$instance->where[] = $instance->data['stream']->stream_prefix.$instance->data['stream']->stream_slug.'.'.$filter.' NOT LIKE "%'.urldecode($value).'%"';
					}
					else
					{
						$instance->where[] = $instance->data['stream']->stream_prefix.$instance->data['stream']->stream_slug.'.'.$filter.' LIKE "%'.urldecode($value).'%"';
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
			$instance->data['no_entries_message'] = $extra['no_entries_message'];
		}

		return $instance;
	}

	public static function form($stream_slug, $stream_namespace, $id = null)
	{	
		// Load up things we'll need for the form
		ci()->load->library(array('form_validation'));

		// Prepare the stream, model and render method
		$instance = static::instance(__function__);

		$instance->model = Model\Entry::stream($stream_slug, $stream_namespace);

		if ($id)
		{
			$instance->entry = $instance->model->getEntry($id);
		}
		else
		{
			$instance->entry = $instance->model->newEntry();
		}

		$instance->form = new \Pyro\Module\Streams_core\Core\Field\Form($instance->entry);

		return $instance;	
	}

	protected function renderTable($return = false)
	{
  		$this->data = array(
  			'stream'		=> $this->data['stream'],
  			'stream_fields'	=> $this->stream_fields,
  			'buttons'		=> $this->buttons,
  			'filters'		=> isset($extra['filters']) ? $extra['filters'] : null,
  			'search_id'		=> isset($_COOKIE['streams_core_filters']) ? $_COOKIE['streams_core_filters'] : null,
  		);

  		// -------------------------------------
		// Columns 
		// @since 2.3
		// -------------------------------------
		// If we have array('*'), get all columns
		// We do it this way to mirror how the model builder selects columns
		if ( ! empty($this->columns) and $this->columns[0] === '*')
		{
			$this->data['stream']->view_options = array_merge($this->standard_columns, $this->field_slugs);
		}
		// If exclude is set to true, get all columns except the ones passed
		elseif ($this->exclude)
		{
			$this->data['stream']->view_options = $this->fields->getFieldSlugsExclude($this->columns);
		}
		// Or get just the columns that were passed
		elseif ($this->columns)
		{
			$this->data['stream']->view_options = $this->columns;
		}
		// Or default to use the standard columns
		else
		{
			$this->data['stream']->view_options = $this->standard_columns;
		}

  		$this->data['field_names'] = array();

  		foreach ($this->data['stream']->view_options as $view_option)
  		{
  			$this->data['field_names'][] = in_array($view_option, $this->field_slugs) ? lang_label($this->stream_fields->{$view_option}->field_name) : lang('streams:'.$view_option);
  		}

		$this->data['entries'] = $this->model->get($this->data['stream']->view_options, $this->exclude);

//echo $this->data['entries']; exit;
/*		$this->data['pagination'] = create_pagination(
									$this->pagination_uri,
									ci()->db->select('id')->count_all_results($this->stream->stream_prefix.$this->stream->stream_slug),
									$this->pagination,
									$this->offset_uri
								);*/

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

	public function renderForm()
	{
		$this->form->redirect($this->return);

		$this->form_fields = $this->form->buildForm();

		$this->data['fields']	= $this->form_fields;
		$this->data['tabs']		= $this->tabs;
		$this->data['hidden']	= $this->hidden;
		$this->data['defaults']	= $this->defaults;
		$this->data['entry']	= $this->entry;
		$this->data['fields']	= $this->form_fields;
		$this->data['mode']		= $this->mode;

		// Set return uri
		$this->data['return']	= $this->return;

		// Set the no fields mesage. This has a lang default.
		$this->data['no_fields_message']	= $this->no_fields_message;
		
		if (empty($this->data['tabs']))
		{
			$form = ci()->load->view('admin/partials/streams/form', $this->data, true);
		}
		else
		{
			$form = ci()->load->view('admin/partials/streams/tabbed_form', $this->data, true);
		}
		
		if ($this->view_override === false) return $form;
		
		$this->data['content'] = $form;
		
		ci()->template->build('admin/partials/blank_section', $this->data);
	}
}