<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Format Plugin
 *
 * Allows you to format text with:
 *
 * - Markdown
 * - Textile
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
 */
class Plugin_format extends Plugin {

	/**
	 * Markdown the content
	 */
	public function format()
	{
		$this->CI = get_instance();

		$method = $this->get_param('method', 'markdown');
		
		// Prep our content
		$content = trim($this->tag_content);
		
		// Run our content through the parser
		$parser = new Lex_Parser();
		$parser->scope_glue(':');
				
		$content = $parser->parse($content, $this->CI->vars, array($this->CI->parse, 'callback'));
		
		switch($method):
		
			// Textile
			case 'textile':
				require_once('textile.php');
				return TextileThis($content);
				break;
		
			// Default is markdown
			default:
				require_once('markdown.php');
				return Markdown($content);
				break;
		
		endswitch;
	}	

}