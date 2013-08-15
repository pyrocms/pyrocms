<?php namespace Pyro\Module\Streams_core\Cp;

// The CP driver is broken down into more logical classes

use Closure;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Module\Streams_core\Core\Support\AbstractCp;

class Entries extends AbstractCp
{

	public static $fields = null;

	/**
	 * Entries Table
	 *
	 * Creates a table of entries.
 	 *
	 * @param	string - the stream slug
	 * @param	string - the stream namespace slug
	 * @param	[mixed - pagination, either null for no pagination or a number for per page]
	 * @param	[null - pagination uri without offset]
	 * @param	[bool - setting this to true will take care of the static::$template business
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
	public static function table($stream_slug, $namespace_slug, $pagination = null, $pagination_uri = null, $extra = array())
	{		
		static::$render = __function__;

		// Get stream
/*		static::$stream = $stream_obj($stream_slug, $namespace_slug);
		if ( ! $stream) static::$log_error('invalid_stream', 'entries_table');*/

		static::$query = Model\Entry::stream($stream_slug, $namespace_slug);

		static::$stream = static::$query->getStream();

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

  		static::$fields = static::$stream->getRelation('assignments')->getFields();

  		$stream_fields = new \stdClass;


  		static::$fields->each(function($field) use ($stream_fields) {

  			$stream_fields->{$field->field_slug} = $field;

  		});

  		// -------------------------------------
		// Sorting
		// @since 2.1.5
		// -------------------------------------

		if (static::$stream->sorting == 'custom' or (isset($extra['sorting']) and $extra['sorting'] === true))
		{
			static::$stream->sorting = 'custom';

			// As an added measure of obsurity, we are going to encrypt the
			// slug of the module so it isn't easily changed.
			ci()->load->library('encrypt');

			// We need some variables to use in the sort.
			ci()->template->append_metadata('<script type="text/javascript" language="javascript">var stream_id='.static::$stream->id.'; var stream_offset='.$offset.'; var streams_module="'.ci()->encrypt->encode(ci()->module_details['slug']).'";
				</script>');
			ci()->template->append_js('streams/entry_sorting.js');
		}
  
  		static::$data = array(
  			'stream'		=> static::$stream,
  			'stream_fields'	=> $stream_fields,
  			'buttons'		=> isset($extra['buttons']) ? $extra['buttons'] : null,
  			'filters'		=> isset($extra['filters']) ? $extra['filters'] : null,
  			'search_id'		=> isset($_COOKIE['streams_core_filters']) ? $_COOKIE['streams_core_filters'] : null,
  		);
 
 		
 		// -------------------------------------
		// Filter API
		// -------------------------------------

		if (ci()->input->get('filter-'.static::$stream->stream_slug))
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
						static::$where[] = static::$stream->stream_prefix.static::$stream->stream_slug.'.'.$filter.' != "'.urldecode($value).'"';
					}
					else
					{
						static::$where[] = static::$stream->stream_prefix.static::$stream->stream_slug.'.'.$filter.' = "'.urldecode($value).'"';
					}
				}
				else
				{
					if ($not)
					{
						static::$where[] = static::$stream->stream_prefix.static::$stream->stream_slug.'.'.$filter.' NOT LIKE "%'.urldecode($value).'%"';
					}
					else
					{
						static::$where[] = static::$stream->stream_prefix.static::$stream->stream_slug.'.'.$filter.' LIKE "%'.urldecode($value).'%"';
					}
				}
			}
		}

		$filter_data = array();

 		// -------------------------------------
		// Get Entries
		// -------------------------------------
		
		$limit = (static::$pagination) ? $pagination : null;



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
		if (isset($extra['title']))
		{
			ci()->template->title(lang_label($extra['title']));
		}

		// Set custom no data message
		if (isset($extra['no_entries_message']))
		{
			static::$data['no_entries_message'] = $extra['no_entries_message'];
		}

		return new static;
	}

	public static function render($return = false)
	{
		
		switch(static::$render)
		{
			case 'table':

		  		// -------------------------------------
				// Columns
				// @since 2.1.5
				// -------------------------------------

				if (static::$columns)
				{
					static::$stream->view_options = ! static::$columns_exclude ? static::$columns : static::$fields->getFieldsSlugsExclusive(static::$columns);
				}

				static::$data['entries'] = static::$query->get(static::$columns, static::$columns_exclude);


				static::$data['pagination'] = create_pagination(
											static::$pagination_uri,
											ci()->db->select('id')->count_all_results(static::$stream->stream_prefix.static::$stream->stream_slug),
											static::$pagination,
											static::$offset_uri
										);

				$table = ci()->load->view('admin/partials/streams/entries', static::$data, true);

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

				break;

			default:
				// do nothing

		}
	}


}