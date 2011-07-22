<?php  defined('BASEPATH') or exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0
 * @filesource
 */

/**
 * PyroCMS Theme Definition
 *
 * This class should be extended to allow for theme management.
 *
 * @author		Stephen Cozart
 * @package		PyroCMS
 * @subpackage	Themes
 * @abstract
 */
abstract class Theme {
	
	/**
	 * @var theme name
	 */
	public $name;

	/**
	 * @var author name
	 */
	public $author;

	/**
	 * @var authors website
	 */
	public $author_website;

	/**
	 * @var theme website
	 */
	public $website;

	/**
	 * @var theme description
	 */
	public $description;

	/**
	 * @var The version of the theme.
	 */
	public $version;
	
	/**
	 * @var Front-end or back-end.
	 */
	public $type;
	
	/**
	 * @var Designer defined options.
	 */
	public $options;
	
	/**
	 * __get
	 *
	 * Allows this class and classes that extend this to use $this-> just like
	 * you were in a controller.
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function __get($var)
	{
		static $ci;
		isset($ci) OR $ci =& get_instance();
		return $ci->{$var};
	}
}

/* End of file Theme.php */