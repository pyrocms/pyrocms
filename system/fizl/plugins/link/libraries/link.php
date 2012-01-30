<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Link Plugin
 *
 * Allows you to generate links
 *
 * @package		Fizl
 * @author		Adam Fairholm (@adamfairholm)
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @license		http://parse19.com/fizl/docs/license.html
 * @link		http://parse19.com/fizl
 */
class Link extends Plugin {

	/**
	 * Simple anchor link
	 */
	public function link()
	{
		return '<a href="'.site_url($this->get_param('uri')).'">'.$this->get_param('title').'</a>';
	}	

}