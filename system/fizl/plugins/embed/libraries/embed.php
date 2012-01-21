<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Embed Plugin
 *
 * Allows you to embed templates
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
 */
class Embed extends Plugin {

	/**
	 * Return a parsed embedded template
	 */
	public function embed()
	{
		$CI = get_instance();
	
		if ( ! $this->get_param('file')) return NULL;
		
		$CI->load->helper('file');
	
		// Load the file. Always an .html
		$embed_content = read_file(FCPATH.$CI->vars['assets_folder'].'/embeds/'.$this->get_param('file').'.html');
		
		if ( ! $embed_content) return NULL;
		
		// We don't want our file variable
		// being parsed with the rest. 
		unset($this->attributes['file']);
		
		$vars = array_merge($this->attributes, $CI->vars);
		
		$parser = new Lex_Parser();
		$parser->scope_glue(':');
		
		return $parser->parse($embed_content, $CI->vars, array($CI->parse, 'callback'));
	}
	
}