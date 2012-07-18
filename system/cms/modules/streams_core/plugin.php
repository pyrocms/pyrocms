<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Streams Core Plugin
 *
 * This plugin houses common Streams functions that need to be
 * globally accessible by streams tags, not just PyroStreams.
 *
 * @package		PyroStreams
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Plugin_Streams_core extends Plugin
{
	/**
	 * Field Function
	 * 
	 * Calls the plugin override function
	 */ 
	public function field()
	{
		$attr = $this->attributes();

		// Setting this in a separte var so we can unset it
		// from the array later that is passed to the parse_override function.
		$field_type = $attr['field_type'];

		// Call the field method
		if (method_exists($this->type->types->{$field_type}, 'plugin_override'))
		{
			// Get the actual field.
			$field = $this->fields_m->get_field_by_slug($attr['field_slug'], $attr['namespace']);

			if ( ! $field) return null;

			// We don't need these anymore
			unset($attr['field_type']);
			unset($attr['field_slug']);
			unset($attr['namespace']);

			return $this->type->types->{$field_type}->plugin_override($field, $attr);	
		}
	}

}