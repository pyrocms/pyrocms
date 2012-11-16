<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Markdown helper for PyroCMS.
 * 
 * This file contains a CodeIgniter helper for PHP Markdown. 
 * The Parser is a third-party library.
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package 	PyroCMS\Core\Helpers
 * @see 		http://michelf.com/projects/php-markdown/
 */
if ( ! function_exists('parse_markdown'))
{
	/**
	 * Parse a block of markdown and get HTML back
	 *
	 * @param string $markdown The markdown text.
	 * @return string The HTML 
	 */
	function parse_markdown($markdown)
	{
		$ci = & get_instance();
		$ci->load->library('markdown_parser');

		return Markdown($markdown);
	}

}