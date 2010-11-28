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

}

/* End of file Theme.php */