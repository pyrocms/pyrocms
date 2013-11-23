<?php

use Pyro\Module\Streams_core\StreamModel;
use Pyro\Module\Streams_core\EntryModel;

/**
 * Streams Plugin
 *
 * @package		Streams
 * @author		Ryan Thompson - PyroCMS
 * @copyright	Copyright (c) 2008 - 2013, Ryan Thompson - PyroCMS
 * @license		http://www.aiwebsystems.com/docs/streams
 * @link		http://www.aiwebsystems.com/streams
 */
class Plugin_Streams_core extends Plugin
{
	
	/**
	 * Cache Vars
	 *
	 * These variables control the cache of
	 * PyroStreams tags.
	 */
	public $cache_type				= 'query';		// tag or query
	public $cache_time_format		= 'minutes'; 	// minutes or seconds
	public $cache_ttl				= null;			// num of seconds or minutes
	public $cache_hash				= null;
	public $write_tag_cache			= false;		// Whether or not we need

	/**
	 * Possible entries parameters
	 * @var array
	 */
	public $entries_parameters = array(
		'stream'			=> null,
		'namespace'			=> null,
		'limit'				=> null,
		'offset'			=> 0,
		'single'			=> 'no',
		'id'				=> null,
		'date_by'			=> 'created',
		'year'				=> null,
		'month'				=> null,
		'day'				=> null,
		'show_upcoming'		=> 'yes',
		'show_past'			=> 'yes',
		'restrict_user'		=> 'no',
		'where'				=> null,
		'exclude'			=> null,
		'exclude_by'		=> 'id',
		'include'			=> null,
		'include_by'		=> 'id',
		'disable'			=> null,
		'order_by'			=> 'created',
		'sort'				=> 'desc',
		'exclude_called'	=> 'no',
		'paginate'			=> 'no',
		'pag_method'		=> 'offset',	// 'offset' or 'page'
		'pag_uri_method'	=> 'segment',	// 'segment' or 'query_string'
		'pag_segment'		=> 2,
		'pag_query_var'		=> 'page',		// Only used if 'pag_uri_method' is query_string
		'pag_base'			=> null,		// If null, this is automatically set
		'partial'			=> null,
		'site_ref'			=> SITE_REF
		);

	/**
	 * Possible pagination configuration parameters
	 * @var array
	 */
	public $pagination_configuration = array(
		'num_links',
		'full_tag_open',
		'full_tag_close',
		'first_link',
		'first_tag_open',
		'first_tag_close',
		'prev_link',
		'prev_tag_open',
		'prev_tag_close',
		'cur_tag_open',
		'cur_tag_close',
		'num_tag_open',
		'num_tag_close',
		'next_link',
		'next_tag_open',
		'next_tag_close',
		'last_link',
		'last_tag_open',
		'last_tag_close',
		'suffix',
		'first_url',
		'reuse_query_string'
		);

	///////////////////////////////////////////////////////////////////////////////
	// --------------------------	METHODS 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////
	
	/**
	 * PyroStreams Plugin Construct
	 *
	 * Just a bunch of loads and prep
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		
	}

	/**
	 * _call
	 *
	 * Fun little method to call a stream without
	 * using cycle. Like:
	 *
	 * {{ streams:stream }}
	 *
	 * @access 	public
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function __call($stream, $data)
	{
		return $this->entries($stream);
	}

	/**
	 * PyroStreams attribute function
	 *
	 * Allows you to pass stuff like [segment_1], etc.
	 *
	 * In PyroCMS 2.2, this has been deprecated by the
	 * parse_parameter() function in the Plugins library.
	 *
	 * However, since the syntax is slightly different,
	 * we will keep this around for backwards compat.
	 *
	 * @access	public
	 * @param	string
	 * @param	[string]
	 * @return	string
	 */	
	public function getAttribute($attribute, $default = null)
	{
		$value = $this->attribute($attribute, $default);

		// Variables
		$segments = array();

		// See if we have any vars in there
		if(strpos($value, '[') !== false):
		
			// Pile em in
			for($i = 1; $i < 20; $i++)
				$variables['segment_'.$i] = $this->uri->segment($i);
						
			// We can only get the user data if it is available
			if($this->current_user):
			
				$variables['user_id']	= $this->current_user->id;
				$variables['username']	= $this->current_user->username;
			
			endif;

			foreach($variables as $variable => $value):
			
				$value = str_replace("[$variable]", $value, $attribute);
			
			endforeach;
		
		endif;
		
		return $value;
	}

	/**
	 * Field Function
	 *
	 * Calls the plugin override function
	 */
	public function field()
	{
		$attributes = $this->attributes();

		if ($attributes)
		{
			$attributes_keys = array_keys($attributes);

			EntryModel::stream($attributes['stream_slug'], $attributes['namespace'])->find($attributes['entry_id']);

			// Setting this in a separate var so we can unset it
			// from the array later that is passed to the parse_override function.
			$field_type = $attributes['field_type'];

			// Call the field method
			if ($type = FieldTypeManager::getType($field_type) and $type->plugin_override) {
				// Get the actual field.
				$field = FieldModel::findBySlugAndNamespace($attributes['field_slug'], $attributes['namespace']);
				
				if ( ! $field) return null;

				// We don't need these anymore
				unset($attributes['field_type']);
				unset($attributes['field_slug']);
				unset($attributes['namespace']);
				unset($attributes['stream_slug']);

				foreach ($attributes_keys as $attribute)
				{
					$method = 'plugin'.Str::studly($attribute.'Override');
					if (method_exists($type, $method)) {
						$arguments = explode('|', $attributes[$attribute]);

						return call_user_func_array(array($type, $method), $arguments);
					}
				}
			}						
		}
	}
	
	/**
	 * Entries
	 *
	 * Get entries in a stream.
	 *
	 * @access	public
	 * @param 	string 	[$stream]	Option stream slug to pass.
	 * @return 	string
	 */
	public function entries($stream = null)
	{
		// Toggle debug mode
		$this->debug_status = $this->getAttribute('debug', 'on');

		$return = array();

		// -------------------------------------
		// Get Plugin Attributes
		// -------------------------------------
		
		$parameters = array();
		
		foreach ($this->entries_parameters as $parameter => $parameter_default)
		{
			$parameters[$parameter] = $this->getAttribute($parameter, $parameter_default);
		}

		// -------------------------------------
		// Stream Slug Override
		// -------------------------------------
		// If we have a stream slug that has been
		// passed, we will take that value over
		// the passed $parameters value. This is so
		// if we have {{ streams:stream stream="another" }}
		// We will ignore "another" in favor of "stream"
		// -------------------------------------

		if ($stream)
		{
			$parameters['stream'] = $stream;
		}

		// -------------------------------------
		// Cache
		// -------------------------------------
		// Setup cache. If we have a full tag cache,
		// we will just go ahead and return that.
		// -------------------------------------

		$this->setup_cache();

		/*if ( ! is_null($full_tag_cache = $this->full_tag_cache()))
		{
			return $full_tag_cache;
		}*/

		// -------------------------------------
		// Pagination & Limit
		// -------------------------------------
		// Gather any pagination config overrides
		// from the plugin. Also, set limit if 
		// there is none and we are using pagination.
		// -------------------------------------
		
		$pagination_configuration = array();
		
		foreach ($this->pagination_configuration as $configuration)
		{
			if ($this->attribute($configuration))
			{
				$pagination_config[$configuration] = $this->attribute($configuration);
			}
		}

		if ($parameters['paginate'] == 'yes' and ! $parameters['limit'])
		{
			$parameters['limit'] = Settings::get('records_per_page');
		}

		// -------------------------------------
		// Set Namespace
		// -------------------------------------
		// We can manually set the namespace
		// via a namespce="" parameter.
		// -------------------------------------

		$parameters['namespace'] = ($parameters['namespace']) ? $parameters['namespace'] : 'streams';

		// -------------------------------------
		// Stream Data Check
		// -------------------------------------
		// Check for a retrieve our stream.
		// -------------------------------------
		
		if ( ! isset($parameters['stream']))
		{
			$this->_error_out(lang('streams:no_stream_provided'));
		}


		$stream = StreamModel::getStream($parameters['stream'], $parameters['namespace']);

		if ( ! $stream)
		{
			$this->_error_out(lang('streams:invalid_stream'));
		}

		// -------------------------------------
		// Get Entries
		// -------------------------------------

		if ($this->cache_type == 'query' and is_numeric($this->cache_ttl))
		{
			$entries = EntryModel::stream($stream)
				->select('*')
				->get()
				->toArray();
		}
		else
		{
			$entries = EntryModel::stream($stream)
				->select('*')
				->get()
				->toArray();
		}
		
		// -------------------------------------
		// Rename
		// -------------------------------------
		// Allows us to rename variables in our
		// parameters. So, rename:old_name="new_name"
		// -------------------------------------

		$renames = array();

		foreach ($this->attributes() as $key => $to)
		{
			if (substr($key, 0, 7) == 'rename:' and strlen($key) > 7)
			{
				$pieces = explode(':', $key);
			
				$renames[$pieces[1]] = $to;
			}
		}

		if ($renames)
		{
			foreach ($entries as $k => &$entry)
			{
				foreach ($renames as $from => $to)
				{
					if (isset($entry->{$from}))
					{
						$entry->{$to} = $entry->$from;
						unset($entry->{$from});
					}
				}
			}
		}

		// -------------------------------------
		// Set rows to 'entries' var
		// -------------------------------------

		//$return['entries'] = $entries;
				
		// -------------------------------------
		// Pagination
		// -------------------------------------
		
		if ($parameters['paginate'] == 'yes')
		{
			$return['total'] 	= $entries['pag_count'];
			
			$pag_segment = (isset($parameters['pag_segment'])) ? $parameters['pag_segment'] : null;
			
			$return['pagination'] = $this->row_m->build_pagination($parameters['pag_segment'], $parameters['limit'], $return['total'], $pagination_config);
		}	
		else
		{	
			$return['pagination'] 	= null;
			$return['total'] 		= count($entries);
		}
				
		// -------------------------------------
		// No Results
		// -------------------------------------
		// In the case of no results, we will return
		// our no_results paramter value.
		// -------------------------------------
		
		if ($return['total'] == 0)
		{
			return $this->getAttribute('no_results', lang('streams:no_results'));
		}

		// -------------------------------------
		// {{ entries }} Bypass
		// -------------------------------------
		// If we don't want to use {{ entries }},
		// we don't have to!
		// -------------------------------------

		$loop = false;

		if (preg_match('/\{\{\s?entries\s?\}\}/', $this->content()) == 0)
		{
			$return = $return['entries'];
			$loop = true;
		}

		// -------------------------------------
		// Parse Ouput Content
		// -------------------------------------
		
		/*$return_content = $this->streams->parse->parse_tag_content(
			$this->content(),
			$return,
			$parameters['stream'],
			$this->core_namespace,
			$loop,
			$this->fields
			);*/
	
		// -------------------------------------
		// Cache End Procedures
		// -------------------------------------

		//$this->tag_cache_write($return);
		$this->clear_cache_vars();

		// -------------------------------------
		//print_r($return);die;
		return $return;
	}

	// --------------------------------------------------------------------------

	/**
	 * Setup the Cache Vars
	 *
	 * Set cache type, time format, and hash
	 *
	 * @access 	private
	 * @return 	void
	 */
	private function setup_cache()
	{
		// 'tag' or 'query'
		$this->cache_type				= $this->getAttribute('cache_type', 'query');	

		// 'minutes' or 'seconds'
		$this->cache_time_format		= $this->getAttribute('cache_time_format', 'minutes'); 

		// num of seconds or minutes
		$this->cache_ttl				= $this->getAttribute('cache', null);

		// Format the cache time. It can either be in seconds
		// or minutes depending on a param.
		if (is_numeric($this->cache_ttl))
		{
			if ($this->cache_time_format == 'minutes')
			{
				// If they specified minutes we just need to
				// convert it to second
				$this->cache_ttl = $this->cache_ttl*60;
			}
		}

		$this->set_cache_hash();
	}

	// --------------------------------------------------------------------------

	/**
	 * Set the cache hash
	 *
	 * This creates a unique cache hash based on the
	 * unique set of tag parameters.
	 *
	 * @access 	private
	 * @return 	void
	 */
	private function set_cache_hash()
	{
		$this->cache_hash = md5(implode('-', $this->attributes()).$this->content());
	}

	// --------------------------------------------------------------------------

	/**
	 * Write tag cache if we need to
	 *
	 * @access 	private
	 * @param 	string - the content to write
	 * @return 	void
	 */
	private function tag_cache_write($content)
	{
		if ($this->write_tag_cache === true)
		{
			$this->pyrocache->write($content, 'pyrostreams'.DIRECTORY_SEPARATOR.$this->cache_hash, $this->cache_ttl);
		}		
	}

	// --------------------------------------------------------------------------

	/**
	 * Full tag cache
	 *
	 * @access 	private
	 * @return 	mixed - null or string
	 */
	private function full_tag_cache()
	{
		if ( ! $this->cache_hash)
		{
			$this->set_cache_hash();
		}

		// Check to see if we have a tag cache.
		if ($this->cache_type == 'tag' and ! is_null($this->cache_ttl))
		{
			if ( ! $tag_cache_content = $this->pyrocache->get('pyrostreams'.DIRECTORY_SEPARATOR.$this->cache_hash))
			{
				// Set this so functions know to write the
				// cache when necesary.
				$this->write_tag_cache = true;
			}
			else
			{
				return $tag_cache_content;
			}
		}

		return null;
	}

	// --------------------------------------------------------------------------

	/**
	 * Reset the cache vars to their defaults
	 *
	 * @access 	private
	 * @return 	void
	 */
	private function clear_cache_vars()
	{
		$this->cache_type			= 'query';
		$this->cache_time_format	= 'minutes';
		$this->cache_ttl			= null;
		$this->cache_hash			= null;
		$this->write_tag_cache		= false;
	}

	// --------------------------------------------------------------------------

	/**
	 * Total
	 *
	 * Get the total number of rows for a stream.
	 *
	 * @access	public
	 * @return	int
	 */
	public function total()
	{
		if ( ! $this->getAttribute('stream'))
		{
			return null;
		}

		$this->setup_cache();

		$this->load->config('streams/streams');

		if ( ! is_null($this->cache_ttl))
		{
			if ( ! $cache_content = $this->pyrocache->get('pyrostreams'.DIRECTORY_SEPARATOR.$this->cache_hash))
			{
				return $this->pyrocache->write(
					$this->db->count_all(STR_PRE.$this->getAttribute('stream')),
					'pyrostreams'.DIRECTORY_SEPARATOR.$this->cache_hash, $this->cache_ttl);

			}
			else
			{
				return $cache_content;
			}
		}
		else
		{
			return $this->db->count_all(STR_PRE.$this->getAttribute('stream'));
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Single
	 *
	 * Show a single stream entry.
	 *
	 * @access	public
	 * @return	array
	 */
	public function single()
	{	
		$this->set_attribute('limit', 1);

		return $this->cycle();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Output an input form for a stream
	 *
	 * @access	public
	 * @return	array
	 */
	public function form()
	{
		// -------------------------------------
		// General Loads
		// -------------------------------------

		$data = new stdClass;
		
		$this->load->library(array('form_validation', 'streams_core/Fields'));
 
		// -------------------------------------
		// Get vars
		// -------------------------------------
		
		$extra = array();

		$mode 					= $this->getAttribute('mode', 'new');
		
		// Make sure that we have a valid mode.
		if ($mode != 'new' and $mode != 'edit') $mode = 'new';

		$edit_id 				= $this->getAttribute('edit_id', false);
		$edit_segment 			= $this->getAttribute('edit_segment', false);
		$stream 			= $this->getAttribute('stream');
		$stream_segment 		= $this->getAttribute('stream_segment');
		$where 					= $this->getAttribute('where');
		$include 				= $this->getAttribute('include');
		$exclude 				= $this->getAttribute('exclude');
		$recaptcha 				= $this->getAttribute('use_recaptcha', 'no');
		$creator_only	   	= $this->getAttribute('creator_only', false);
		$namespace 				= $this->getAttribute('namespace', $this->core_namespace);

		$extra['required'] 		= $this->getAttribute('required', '<span class="required">* required</span>');
		$extra['return'] 		= $this->getAttribute('return', $this->uri->uri_string());
		$extra['error_start'] 	= $this->getAttribute('error_start', '<span class="error">');
		$extra['error_end']		= $this->getAttribute('error_end', '</span>');
		
		$this->getAttribute('use_recaptcha', 'no') == 'yes' ? $recaptcha = TRUE : $recaptcha = false;

		// -------------------------------------
		// Messages
		// -------------------------------------
		// Lang line references:
		// - new_entry_success
		// - new_entry_error
		// - edit_entry_success
		// - edit_entry_error
		// -------------------------------------
		
		$extra['success_message'] 	= $this->getAttribute('success_message', "lang:streams:{$mode}_entry_success");
		$extra['failure_message'] 	= $this->getAttribute('failure_message', "lang:streams:{$mode}_entry_error");
							
		// -------------------------------------
		// Get Stream Data
		// -------------------------------------
		
		$data->stream			= $this->streams_m->get_stream($stream, true, $namespace);
		
		if ( ! $data->stream) return lang('streams:invalid_stream');
		
		$data->stream_id		= $data->stream->id;

		// -------------------------------------
		// Collect Email Notification Data
		// -------------------------------------
		// Default is two notifications. We collect
		// this data no matter what and the 
		// form library takes care of the rest.
		// -------------------------------------
	
		$notifications 			= array();

		$numbers = array('a', 'b');
	
		foreach ($numbers as $notify_num)
		{
			$notifications[$notify_num]['notify'] 		= $this->getAttribute('notify_'.$notify_num);
			$notifications[$notify_num]['template'] 	= $this->getAttribute('notify_template_'.$notify_num);
			$notifications[$notify_num]['from'] 		= $this->getAttribute('notify_from_'.$notify_num);
		}		
		
		$extra['email_notifications'] = $notifications;
		
		// -------------------------------------
		// Get Edit ID from URL if in Edit Mode
		// -------------------------------------
		
		$entry = false;
		
		if ($mode == 'edit')
		{
			// Do they want us to grab the ID from the URL?
			if (is_numeric($edit_segment))
			{
				$edit_id = $this->uri->segment($edit_segment);
			}
			
			// Do they want a where?
			// This overrides the edit_id
			if ($where)
			{
				$bits = explode('==', $where);
				
				if (count($bits) == 2)
				{
					$query = $this->db->limit(1)->where($bits[0], $bits[1])->get($data->stream->stream_prefix.$data->stream->stream);
					
					if($query->num_rows() == 1)
					{
						// WTF is this doing? It gets
						// overwritten anyways.
						$entry = $query->row();	
						$edit_id = $entry->id;
					}
				}
			}
			else
			{
				// Get the row
				$entry = $this->row_m->get_row($edit_id, $data->stream, false);
			}			
		}

		// -------------------------------------
		// Check Author Only
		// -------------------------------------
		// If this mode is on edit, and it is set
		// to creator_only, we can check to see
		// if the editor is the creator.
		// -------------------------------------

		if ($creator_only == 'yes' and $mode == 'edit')
		{
			// Must be logged in
			if ( ! isset($this->current_user->id))
			{
				return null;
			}

			if ($this->current_user->id != $entry->created_by)
			{
				return null;
			}
		}

		// -------------------------------------
		// Include/Exclude
		// -------------------------------------

		$skips = $this->determine_skips($include, $exclude, $data->stream_id);

		// -------------------------------------
		// Form key
		// -------------------------------------
		// Add a unique identifier to the form. This is needed if
		// you have multiple stream forms per page. If they are new entry forms,
		// there is no real way to determine a unique identifer, so the user
		// will need to add one themselves. This is a little different for editing
		// forms, 
		// -------------------------------------

		$hidden = array();

		if ($form_key = $this->getAttribute('form_key'))
		{
			$hidden['_streams_form_key'] = $form_key;
			$extra['form_key'] = $form_key;
		}
		elseif ($mode == 'edit')
		{
			$hidden['_streams_form_key'] = $data->stream->stream_namespace.'_'.$data->stream->stream.'_'.$entry->id;
			$extra['form_key'] = $hidden['_streams_form_key'];
		}

		// -------------------------------------
		// Process and Output Form Data
		// -------------------------------------
	
		$vars['fields'] = $this->fields->build_form($data->stream, $mode, $entry, true, $recaptcha, $skips, $extra);

		// We can't have a form if we have no fields.
		if ( ! $vars['fields']) return;

		// -------------------------------------
		// Individual Field Access 
		// -------------------------------------
		// For greater form control, this allows
		// users to access each form item
		// indivudally.
		// -------------------------------------

		foreach($vars['fields'] as $field)
		{
			$vars[$field['input_slug']]['label'] 			= lang_label($field['input_title']);
			$vars[$field['input_slug']]['slug'] 			= $field['input_slug'];
			$vars[$field['input_slug']]['value'] 			= $field['value'];

			if($field['input_parts'] !== false)
			{
				$vars[$field['input_slug']]['input']		= $field['input_parts'];
				$vars[$field['input_slug']]['input_built']	= $field['input'];
			}
			else
			{
				$vars[$field['input_slug']]['input']		= $field['input'];
				$vars[$field['input_slug']]['input_built']	= $field['input'];
			}

			$vars[$field['input_slug']]['error_raw'] 		= $field['error_raw'];
			$vars[$field['input_slug']]['error'] 			= $field['error'];
			$vars[$field['input_slug']]['is_required'] 		= ($field['required']) ? true : false;
			$vars[$field['input_slug']]['required'] 		= $field['required'];
			$vars[$field['input_slug']]['odd_even'] 		= $field['odd_even'];
			$vars[$field['input_slug']]['instructions']		= $field['instructions'];
		}
		
		// -------------------------------------
		// reCAPTCHA
		// -------------------------------------
		
		if ($recaptcha)
		{
			$this->recaptcha->_rConfig['theme'] = $this->getAttribute('recaptcha_theme', 'red');

			$vars['recaptcha'] = $this->recaptcha->get_html();

			// Output the error if we have one
			if ($this->form_validation->field_data('recaptcha_response_field'))
			{
				$vars['recaptcha_error'] = $this->form_validation->error('recaptcha_response_field');
			}	
			else
			{
				$vars['recaptcha_error'] = '';
			}
		}
		
		// -------------------------------------
		// Basic Form elements
		// -------------------------------------
		
		$parameters['class']		= $this->getAttribute('form_class', 'crud_form');
		$parameters['id']			= $this->getAttribute('form_id');
				
		// Add a row_edit_id where needed
		if ($mode == 'edit')
		{
			$hidden['row_edit_id'] = $entry->id;
		}

		// Always add a stream_id to the form.
		$hidden['stream_id'] = $data->stream_id;

		// -------------------------------------
		// Compile {{ tag }} form elements
		// -------------------------------------

		$vars['form_open']		= form_open_multipart($this->uri->uri_string(), $parameters, $hidden);	
		$vars['form_close']		= '</form>';
		$vars['form_submit']	= '<input type="submit" value="'.lang('save_label').'" />';
		$vars['form_reset']		= '<input type="reset" value="'.lang('streams:reset').'" />';
		$vars['validation_errors'] = validation_errors($extra['error_start'], $extra['error_end']);

		// -------------------------------------
		
		return array($vars);				
	}

	// --------------------------------------------------------------------------

	/**
	 * Determine the fields to skip
	 * based on include/exclude
	 */
	private function determine_skips($include, $exclude, $stream_id, $stream_fields = null)
	{
		$skips = array();

		if ($include)
		{
			$includes = explode('|', $include);

			if (is_null($stream_fields))
			{
				$stream_fields = $this->streams_m->get_stream_fields($stream_id);
			}

			// We need to skip everything else
			foreach ($stream_fields as $field)
			{
				if ( ! in_array($field->field_slug, $includes))
				{
					$skips[] = $field->field_slug;
				}
			}
		}
		if ($exclude)
		{
			// Exlcudes are just our skips
			$excludes = explode('|', $exclude);
		
			$skips = array_merge($excludes, $skips);
		}

		return $skips;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Form assets
	 *
	 * @access	public
	 * @return	string
	 */	
	public function form_assets()
	{
		if ( ! empty($this->type->assets))
		{
			// Weird fix that seems to work for fixing WYSIWYG
			// since it is throwing missing variable errors
			$html = '<script type="text/javascript">var SITE_URL = "'.$this->config->item('base_url').'";</script>';
		
			foreach($this->type->assets as $asset)
			{
				$html .= $asset."\n";
			}
			
			return $html;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Form CSRF input
	 *
	 * You might need this if you are not using the {{ form_open }} variable.
	 *
	 * @access 	public
	 * @return 	mixed - null or string
	 */
	public function form_csrf()
	{
		if ($this->config->item('csrf_protection'))
		{
			return form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());
		}		
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Form Fields
	 *
	 * Allows you to simple show form fields without 
	 */
	public function form_fields()
	{
		$this->load->library(array('form_validation', 'streams_core/Fields'));

		$mode 				= $this->getAttribute('mode', 'new');
		$edit_id 			= $this->getAttribute('edit_id', false);
		$stream 		= $this->getAttribute('stream');
		$namespace 			= $this->getAttribute('namespace', $this->core_namespace);
		$include 			= $this->getAttribute('include');
		$exclude 			= $this->getAttribute('exclude');
		$required 			= $this->getAttribute('required', '<span class="required">* required</span>');
		
		// -------------------------------------
		// Get Stream Data
		// -------------------------------------
		
		$data->stream			= $this->streams_m->get_stream($stream, true, $namespace);
		
		if ( ! $data->stream) return lang('streams:invalid_stream');
		
		$data->stream_id		= $data->stream->id;
		$vars = array();

		// -------------------------------------
		// Get the row in edit mode
		// -------------------------------------
		
		$entry = false;
		
		if ($mode == 'edit')
		{
			$entry = $this->row_m->get_row($edit_id, $data->stream, false);
		}

		// -------------------------------------
		// Set up skips & values
		// -------------------------------------

		$stream_fields = $this->streams_m->get_stream_fields($data->stream_id);

		$skips = $this->determine_skips($include, $exclude, $data->stream_id, $stream_fields);

		$values = $this->fields->set_values($stream_fields, $entry, $mode, $skips);

		// -------------------------------------
		// Get & Return Fields
		// -------------------------------------

		$vars['fields'] = $this->fields->build_fields($stream_fields, $values, $entry, $mode, $skips, $required);		

		// -------------------------------------
		// Individual Field Access 
		// -------------------------------------
		// For greater form control, this allows
		// users to access each form item
		// indivudally.
		// -------------------------------------

		foreach($vars['fields'] as $field)
		{
			$vars[$field['input_slug']]['label'] 			= $field['input_title'];
			$vars[$field['input_slug']]['slug'] 			= $field['input_slug'];
			$vars[$field['input_slug']]['value'] 			= $field['value'];

			if($field['input_parts'] !== false)
			{
				$vars[$field['input_slug']]['input']		= $field['input_parts'];
				$vars[$field['input_slug']]['input_built']	= $field['input'];
			}
			else
			{
				$vars[$field['input_slug']]['input']		= $field['input'];
				$vars[$field['input_slug']]['input_built']	= $field['input'];
			}

			$vars[$field['input_slug']]['error_raw'] 		= $field['error_raw'];
			$vars[$field['input_slug']]['error'] 			= $field['error'];
			$vars[$field['input_slug']]['is_required'] 		= ($field['required']) ? true : false;
			$vars[$field['input_slug']]['required'] 		= $field['required'];
			$vars[$field['input_slug']]['odd_even'] 		= $field['odd_even'];
		}

		return array($vars);				
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Delete a row field
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function delete_entry()
	{
		// -------------------------------------
		// General Loads
		// -------------------------------------

		$this->load->library(array('form_validation', 'streams_core/Fields'));

		// -------------------------------------
		// Get vars
		// -------------------------------------

		$stream 			= $this->getAttribute('stream');
		$namespace 				= $this->getAttribute('namespace', $this->core_namespace);
		$entry_id 				= $this->getAttribute('entry_id', false);
		$return 				= $this->getAttribute('return', '');
		$vars					= array();

		// -------------------------------------
		// Create Hidden Hash
		// -------------------------------------

		$hidden['delete_id'] = md5($stream.$entry_id);

		// -------------------------------------
		// Get Stream Data
		// -------------------------------------
		
		$stream			= $this->streams_m->get_stream($stream, true, $namespace);
		
		if ( ! $stream) show_error(lang('streams:invalid_stream'));
	
		// -------------------------------------
		// Check Delete
		// -------------------------------------
	
		if (
			$this->input->post('delete_confirm')
			and $this->input->post('delete_id') == $hidden['delete_id']
		)
		{
			$this->db->where('id', $entry_id)->delete($stream->stream_prefix.$stream->stream);
			
			$this->load->helper('url');
			
			redirect(str_replace('-id-', $entry_id, $return));
		}	
		else
		{
			// -------------------------------------
			// Get stream fields
			// -------------------------------------
			
			$this->fields = $this->streams_m->get_stream_fields($stream->id);

			// -------------------------------------
			// Get entry data
			// -------------------------------------
			// We may want to display it 
			// -------------------------------------
			
			$parameters = array(
				'stream'		=> $stream->stream,
				'namespace'		=> $namespace,
				'id' 			=> $entry_id,
				'limit'			=> 1,
				'offset'		=> 0,
				'order_by'		=> false,
				'exclude'		=> false,
				'show_upcoming'	=> null,
				'show_past'		=> null,
				'where'			=> null,
				'disable'		=> array(),
				'year'			=> null,
				'month'			=> null,
				'day'			=> null,
				'restrict_user'	=> 'no',
				'single'		=> 'yes'
			);

			$entries = $this->row_m->get_rows($parameters, $this->fields, $stream);
			
			if ( ! isset($entries['rows'][0])) return $this->getAttribute('no_entry', lang('streams:no_entry'));
			
			$vars['entry'][0] = $entries['rows'][0];
	
			// -------------------------------------
			// Parse other vars
			// -------------------------------------

			$vars['form_open'] 		= form_open($this->uri->uri_string(), null, $hidden);
			$vars['form_close']		= '</form>';
			$vars['delete_confirm']	= '<input type="submit" name="delete_confirm" value="'.lang('streams:delete').'" />';
			
			$entries = null;
			
			return array($vars);
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Default Calendar Template
	 *
	 * @access	public
	 * @var		string
	 */
	public $calendar_template = '
	
	   {table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}
	
	   {heading_row_start}<tr>{/heading_row_start}
	
	   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
	   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
	   {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
	
	   {heading_row_end}</tr>{/heading_row_end}
	
	   {week_row_start}<tr>{/week_row_start}
	   {week_day_cell}<td>{week_day}</td>{/week_day_cell}
	   {week_row_end}</tr>{/week_row_end}
	
	   {cal_row_start}<tr>{/cal_row_start}
	   {cal_cell_start}<td>{/cal_cell_start}
	
	   {cal_cell_content}{day}{content}{/cal_cell_content}
	   {cal_cell_content_today}<div class="highlight">{day}{content}</div>{/cal_cell_content_today}
	
	   {cal_cell_no_content}{day}{/cal_cell_no_content}
	   {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}
	
	   {cal_cell_blank}&nbsp;{/cal_cell_blank}
	
	   {cal_cell_end}</td>{/cal_cell_end}
	   {cal_row_end}</tr>{/cal_row_end}
	
	   {table_close}</table>{/table_close}
	';

	// --------------------------------------------------------------------------

	/**
	 * Calendar
	 *
	 * @access	public
	 * @return	string
	 */
	public function calendar()
	{
		// -------------------------------------
		// Cache
		// -------------------------------------

		$this->setup_cache();

		if ( ! is_null($full_tag_cache = $this->full_tag_cache()))
		{
			return $full_tag_cache;
		}

		// -------------------------------------
		// Get vars
		// -------------------------------------
	
		$passed_streams 		= $this->getAttribute('stream');
		$date_fields_passed		= $this->getAttribute('date_field', 'created');
		$year 					= $this->getAttribute('year', date('Y'));
		$year_segment 			= $this->getAttribute('year_segment');
		$month 					= $this->getAttribute('month', date('n'));
		$month_segment 			= $this->getAttribute('month_segment');
		$passed_display 		= $this->getAttribute('display', '<strong>[id]</strong>');
		$passed_link 			= $this->getAttribute('link', '');
		$title_col				= $this->getAttribute('title_col', 'id');
		$template				= $this->getAttribute('template', false);

		// -------------------------------------
		// Figure out year & month
		// -------------------------------------

		if (is_numeric($year_segment) AND is_numeric($this->uri->segment($year_segment)))
		{
			$year = $this->uri->segment($year_segment);
		}

		if (is_numeric($month_segment) and is_numeric($this->uri->segment($month_segment)))
		{
			$month = $this->uri->segment($month_segment);
		}

		// Default to current
		if ( ! is_numeric($year)) $year = date('Y');
		if ( ! is_numeric($month)) $month = date('n');

		// -------------------------------------
		// Run through streams & create
		// calendar data
		// -------------------------------------
		
		$calendar = array();
		
		$displays		= explode("|", $passed_display);
		$links			= explode("|", $passed_link);
		$streams 		= explode("|", $passed_streams);
		$date_fields 	= explode("|", $date_fields_passed);
		
		$count = 0;
				
		foreach ($streams as $stream)
		{
			$date_field = $date_fields[$count];

			$stream = $this->streams_m->get_stream($stream, TRUE, $this->core_namespace);
	
			$this->fields = $this->streams_m->get_stream_fields($stream->id);
			
			$parameters = array(
				'date_by'	 	=> $date_field,
				'get_day' 		=> TRUE,
				'year' 			=> $year,
				'month' 		=> $month
			);

			// -------------------------------------
			// Get rows
			// -------------------------------------

			if ($this->cache_type == 'query' and ! is_null($this->cache_ttl))
			{
				$entries = $this->pyrocache->model('row_m', 'get_rows', array($parameters, $this->fields, $stream), $this->cache_ttl);
			}
			else
			{
				$entries = $this->row_m->get_rows($parameters, $this->fields, $stream);
			}

			$this->clear_cache_vars();
				
			// -------------------------------------
			// Format Calendar Data
			// -------------------------------------
			
			foreach ($entries as $above)
			{
				foreach ($above as $entry)
				{
					if (isset($displays[$count]))
					{
						// Replace fields				
						$display_content 	= $displays[$count];
						$link_content 		= $links[$count];
			
						$parser = new Lex_Parser();
						$parser->scope_glue(':');
						
						$display_content = str_replace(array('[', ']'), array('{{ ', ' }}'), $display_content);
						$link_content = str_replace(array('[', ']'), array('{{ ', ' }}'), $link_content);
													
						$display_content = $parser->parse($display_content, $entry, array($this->parser, 'parser_callback'));
						$link_content = $parser->parse($link_content, $entry, array($this->parser, 'parser_callback'));
									
						// Link
						if ($link_content != '' )
						{
							$display_content = '<a href="'.site_url($link_content).'" class="'.$stream.'_link">'.$display_content.'</a>';
						}							
						
						// Adding to the array
						if (isset($calendar[$entry['pyrostreams_cal_day']]))
						{
							$calendar[$entry['pyrostreams_cal_day']] .= $display_content.'<br />';
						}
						else
						{
							$calendar[$entry['pyrostreams_cal_day']]  = $display_content.'<br />';
						}
					}
				}
			}
					
			$count++;
		}
				
		// -------------------------------------
		// Get Template
		// -------------------------------------

		if ($template)
		{
			$this->db->limit(1)->select('body')->where('title', $template);
			$db_obj = $this->db->get('page_layouts');
			
			if($db_obj->num_rows() > 0)
			{
				$layout = $db_obj->row();
				$this->calendar_template = $layout->body;
			}
		}
	
		// -------------------------------------
		// Generate Calendar
		// -------------------------------------
		
		$calendar_prefs['template']			= $this->calendar_template;
		$calendar_prefs['start_day']		= strtolower($this->getAttribute('start_day', 'sunday'));
		$calendar_prefs['month_type']		= $this->getAttribute('month_type', 'long');
		$calendar_prefs['day_type']			= $this->getAttribute('day_type', 'abr');
		$calendar_prefs['show_next_prev']	= $this->getAttribute('show_next_prev', 'yes');
		$calendar_prefs['next_prev_url']	= $this->getAttribute('next_prev_uri', '');

		if ($calendar_prefs['show_next_prev'] == 'yes')
		{
			$calendar_prefs['show_next_prev'] = true;
		}
		else
		{
			$calendar_prefs['show_next_prev'] = false;
		}

		$this->load->library('calendar', $calendar_prefs);

		$return_content = $this->calendar->generate($year, $month, $calendar);

		// -------------------------------------
		// Cache End Procedures
		// -------------------------------------

		$this->tag_cache_write($return_content);

		$this->clear_cache_vars();

		// -------------------------------------

		return $return_content;
	}

	// --------------------------------------------------------------------------

	/**
	 * Seach Form
	 *
	 * @access	public
	 * @return	string
	 */
	function search_form()
	{
		$this->load->helper('form');
	
		$stream 	= $this->getAttribute('stream');
		$namespace 		= $this->getAttribute('namespace', $this->core_namespace);
		$fields 		= $this->getAttribute('fields');
		
		$search_types 	= array('keywords', 'full_phrase');
		
		$search_type 	= strtolower($this->getAttribute('search_type', 'full_phrase'));
		$results_page	= $this->getAttribute('results_page');
		$variables		= array();

		// -------------------------------------
		// Check our search type
		// -------------------------------------
		
		if ( ! in_array($search_type, $search_types))
		{
			show_error($search_type.' '.lang('streams:invalid_search_type'));
		}

		// -------------------------------------
		// Check for our search term
		// -------------------------------------
		
		if (isset($_POST['search_term']))
		{
			$this->load->model('streams/search_m');
			
			// Write cache
			$cache_id = $this->search_m->perform_search(
				$this->input->post('search_term'),
				$search_type,
				$stream,
				$fields,
				$this->core_namespace);
		
			// Redirect
			$this->load->helper('url');
			redirect($results_page.'/'.$cache_id);
		}
		
		// -------------------------------------
		// Build Form
		// -------------------------------------

		$vars['form_open']			= form_open($this->uri->uri_string());

		$search_input = array(
					  'name'		=> 'search_term',
					  'id'		  => 'search_term');
		
		$vars['search_input'] 		= form_input($search_input);
		$vars['form_submit'] 		= form_submit('search_submit', lang('streams:search'));
		$vars['form_close'] 		= '</form>';

		return array($vars);
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Search Results
	 *
	 * @access	public
	 * @return	string
	 */
	function search_results()
	{
		$paginate		= $this->getAttribute('paginate', 'yes');
		$cache_segment	= $this->getAttribute('cache_segment', 3);
		$per_page		= $this->getAttribute('per_page', 25);
		$variables		= array();

		// Pagination segment is always right after the cache hash segment
		$pag_segment	= $cache_segment+1;

		// -------------------------------------
		// Check for Cached Search Query
		// -------------------------------------

		$this->load->model('streams/search_m');

		if ( ! $cache = $this->search_m->get_cache($this->uri->segment($cache_segment)))
		{
			// Invalid search
			show_error(lang('streams:search_not_found'));
		}

		$stream = $this->streams_m->get_stream($cache->stream, true, $cache->stream_namespace);

		$this->fields = $this->streams_m->get_stream_fields($stream->id);

		// Easy out for no results
		if ($cache->total_results == 0)
		{
			return array(
				'no_results' 		=> $this->getAttribute('no_results', lang('streams:no_results')),
				'results_exist'		=> false,
				'results'			=> array(),
				'pagination'		=> null,
				'search_term' 		=> $this->getAttribute('search_term', $cache->search_term),
				'total_results'		=> (string)'0'
			);		
		}
		
		// -------------------------------------
		// Pagination
		// -------------------------------------
		
		$return = array();
	
		$return['total'] 	= $cache->total_results;

		if ($paginate == 'yes')
		{
			// Add in our pagination config
			// override varaibles.
			foreach($this->pagination_config as $key => $var)
			{
				$this->pagination_config[$key] = $this->attribute($key, $this->pagination_config[$key]);
				
				// Make sure we obey the false parameters
				if($this->pagination_config[$key] == 'false') $this->pagination_config[$key] = false;
			}

			$return['pagination'] = $this->row_m->build_pagination($pag_segment, $per_page, $return['total'], $this->pagination_config);
			
			$offset = $this->uri->segment($pag_segment, 0);
			
			$query_string = $cache->query_string." LIMIT $offset, $per_page";
		}
		else
		{
			$return['pagination'] 	= null;	
			$query_string = $cache->query_string;
		}

		// -------------------------------------
		// Get & Format Results
		// -------------------------------------

		$return['results'] = $this->row_m->format_rows(
									$this->db->query($query_string)->result_array(),
									$stream);

		// -------------------------------------
		// Extra Data
		// -------------------------------------

		$return['no_results'] 		= '';
		$return['total_results'] 	= $cache->total_results;
		$return['results_exist'] 	= true;				
		$return['search_term'] 		= $cache->search_term;
		
		return $this->streams_content_parse($this->content(), $return, $cache->stream);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Output debug message or just
	 * return false.
	 *
	 * @access	private
	 * @param	string
	 * @return 	mixed
	 */	
	private function _error_out($msg)
	{
		return ($this->debug_status == 'on') ? show_error($msg) : false;
	}

	// --------------------------------------------------------------------------
	// Legacy Functions
	// --------------------------------------------------------------------------
	
	/**
	 * Format date variables
	 *
	 * Legacy. This is now done by the date helper
	 * or in the datetime field type.
	 *
	 * @access	public
	 * @return	string - formatted date
	 */
	public function date()
	{
	 	$date_formats = array('DATE_ATOM', 'DATE_COOKIE', 'DATE_ISO8601', 'DATE_RFC822', 'DATE_RFC850', 'DATE_RFC1036', 'DATE_RFC1123', 'DATE_RFC2822', 'DATE_RSS', 'DATE_W3C');
	 	
		$date 		= $this->attribute('date');
		$format 	= $this->attribute('format');
		
		// No sense in trying to get down
		// with somedata that isn't there
		if ( ! $date or ! $format) return null;
		
		$this->load->helper('date');
	
		// Make sure we have a UNIX date
		if ( ! is_numeric($date)) $date = mysql_to_unix($date);
		
		// Is this a preset?
		if (in_array($format, $date_formats)) return standard_date($format, $date);

		// Default is PHP date		
		return date($format, $date);
	}

}