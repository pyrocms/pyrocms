<?php

use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Entry\EntryModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * Streams Parse Driver
 *
 * The Streams Parse provides special functionality
 * for tag parsing for PyroStreams. Central to this is the
 * parse_tag_content function which takes care of all sorts of special
 * tag tomfoolery which allows Streams to do some interesting
 * things while keeping the tag structure nice and clean.
 * 
 * @author  	Adam Fairholm - PyroCMS Dev Team
 * @package  	PyroCMS\Core\Libraries\Streams\Drivers
 */ 
class Streams_parse extends CI_Driver {

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

		$rep = array('{{ streams_core:related', '{{ streams_core:related');
		$content = str_replace($rep, '{{ streams:related stream="'.$stream_slug.'" base_namespace="'.$stream_namespace.'" entry=id ', $content);

		$rep = array('{{ streams_core:multiple', '{{ streams_core:multiple');
		$content = str_replace($rep, '{{ streams_core:multiple stream="'.$stream_slug.'" base_namespace="'.$stream_namespace.'" entry=id ', $content);
		// -------------------------------------
		// Make sure we have our stream fields
		// -------------------------------------

		if (is_null($fields))
		{
            $entryModelClass = StreamModel::getEntryModelClass($stream_slug, $stream_namespace);

            $entryModel = new $entryModelClass;

			if (!empty($entryModel)) {
                $stream = $entryModel->getStream();
                $fields = $stream->assignments->getTypes();
            }
		}

		// -------------------------------------
		// Custom Call Provision
		// -------------------------------------
		// Go through the fields for this stream, and
		// see if any of them have the magic 'plugin_override'
		// function. This will allow us to call functions
		// from within the field type itself.
		// -------------------------------------

		$original_content = $content;

		if (! $fields->isEmpty() and preg_match('/="/', $content))
		{
			foreach ($fields as $field)
			{
				if ($type = $field->getType() and $type->plugin_override)
				{
					$content = preg_replace('/\{\{\s?entry:'.$field->field_slug.'\s?/', '{{ streams_core:field entry_id="{{ '.
						$id_name.' }}" stream_slug="'.
						$stream_slug.'" field_slug="'.$field->field_slug.'" namespace="'.
						$stream_namespace.'" field_type="'.$field->field_type.'" ', $content);

					$content = preg_replace('/\{\{\s?\/entry:'.$field->field_slug.'\s?\}\}/', '{{ /streams_core:field }}', $content);
				}
			}
			if ($original_content != $content)
			{
				$data = $data['entry'];
			}
		}

		// -------------------------------------
		// Parse
		// -------------------------------------

		$parser = new Lex\Parser();
		$parser->scopeGlue(':');
		$parser->cumulativeNoparse(true);

		if ( ! $loop)
		{
			return $parser->parse($content, $data, array(ci()->parser, 'parser_callback'));
		}

		$out = '';

		foreach ($data as $item)
		{
			$out .= $parser->parse($content, $item, array(ci()->parser, 'parser_callback'));
		}

		return $out;
	}

}