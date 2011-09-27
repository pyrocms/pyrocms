<?php
/**
 * This file contains a CodeIgniter helper for PHP Markdown. The Parser
 *  is a third-party library found at:
 *  @link http://michelf.com/projects/php-markdown/
 */

if(!function_exists('parse_markdown'))
{
    /**
     * Parse a block of markdown and get HTML back
     * @param string $markdown MArkdown text
     * @return string HTML
     */
    function parse_markdown($markdown)
    {
        $ci =& get_instance();
        $ci->load->library('markdown_parser');
        
        return Markdown($markdown);
    }
}