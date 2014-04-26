<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Streams Parse Driver
 *
 * The Streams Parse provides special functionality
 * for tag parsing for PyroStreams. Central to this is the
 * parse_tag_content function which takes care of all sorts of special
 * tag tomfoolery which allows Streams to do some interesting
 * things while keeping the tag structure nice and clean.
 * 
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */ 
class Streams_parse extends CI_Driver {

	/**
	 * The CodeIgniter instance
	 *
	 * @access 	private
	 * @var 	object 
	 */
	private $CI;

	// --------------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		$this->CI = get_instance();
	}

	// --------------------------------------------------------------------------

	/**
	 * Streams content parse
	 *
	 * Special content parser for streams. This accomplishes the following
	 * important functions:
	 *
	 * a. Takes care of legacy multiple relationship parsing
	 * b. Finds and formats special plugin fields
	 *
	 * @access	public
	 * @param	string - the tag content
	 * @param	array - the return data
	 * @param	string - stream slug
	 * @param 	string - stream namespace
	 * @param 	[bool - whether or not to loop through the results or not]
	 * @param 	[mixed - null or obj - stream fields. If they are availble, it will
	 * 				save a mysql query.]
	 * @param 	string [$id_name] The name of the id we want to pass via 'row_id'. This is almost alway 'id'
	 * @return 	string - the parsed data
	 */
	public function parse_tag_content($content, $data, $stream_slug, $stream_namespace, $loop = false, $fields = null, $id_name = 'id')
	{
		// -------------------------------------
		// Legacy multiple relationship provision
		// -------------------------------------
		// We should respect our elders. This makes
		// sure older instances of multiple
		// relationships won't break. We can probably
		// remove this after PyroCMS 2.2
		// -------------------------------------

		$rep = array('{{ streams_core:related', '{{streams_core:related');
		$content = str_replace($rep, '{{ streams:related stream="'.$stream_slug.'" base_namespace="'.$stream_namespace.'" entry=id ', $content);

		$rep = array('{{ streams_core:multiple', '{{streams_core:multiple');
		$content = str_replace($rep, '{{ streams_core:multiple stream="'.$stream_slug.'" base_namespace="'.$stream_namespace.'" entry=id ', $content);

		// -------------------------------------
		// Make sure we have our stream fields
		// -------------------------------------

		if (is_null($fields))
		{
			$stream = $this->stream_obj($stream_slug, $stream_namespace);
			$fields = $this->CI->streams_m->get_stream_fields($stream->id);
		}

		// -------------------------------------
		// Custom Call Provision
		// -------------------------------------
		// Go through the fields for this stream, and
		// see if any of them have the magic 'plugin_override'
		// function. This will allow us to call functions
		// from within the field type itself.
		// -------------------------------------

		if ($fields)
		{
			foreach ($fields as $field)
			{
				if (method_exists($this->CI->type->types->{$field->field_type}, 'plugin_override'))
				{
					$content = preg_replace('/\{\{\s?'.$field->field_slug.'\s?/', '{{ streams_core:field row_id="{{ '.
						$id_name.' }}" stream_slug="'.
						$stream_slug.'" field_slug="'.$field->field_slug.'" namespace="'.
						$stream_namespace.'" field_type="'.$field->field_type.'" ', $content);

					$content = preg_replace('/\{\{\s?\/'.$field->field_slug.'\s?\}\}/', '{{ /streams_core:field }}', $content);
				}
			}
		}

		// -------------------------------------
		// Parse
		// -------------------------------------

		$parser = new Lex_Parser();
		$parser->scope_glue(':');
		$parser->cumulative_noparse(true);

		if ( ! $loop)
		{
			return $parser->parse($content, $data, array($this->CI->parser, 'parser_callback'));
		}

		$out = '';

		foreach ($data as $item)
		{
			$out .= $parser->parse($content, $item, array($this->CI->parser, 'parser_callback'));
		}

		return $out;
	}

}