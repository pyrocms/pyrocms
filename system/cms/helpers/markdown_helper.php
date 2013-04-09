<?php

use dflydev\markdown\MarkdownExtraParser;

/**
 * Markdown helper for PyroCMS.
 *
 * This file contains a CodeIgniter helper for PHP Markdown.
 * The Parser is a third-party library.
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package 	PyroCMS\Core\Helpers
 * @see 		https://github.com/dflydev/dflydev-markdown
 * @deprecated
 */
if ( ! function_exists('parse_markdown')) {
	/**
	 * Parse a block of markdown and get HTML back
	 *
	 * @param string $markdown The markdown text.
	 * @return string The HTML
	 */
	function parse_markdown($markdown)
	{
		$parser = new MarkdownExtraParser;

		return $parser->transformMarkdown($markdown);
	}

}
