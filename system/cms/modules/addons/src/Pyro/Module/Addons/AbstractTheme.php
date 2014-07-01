<?php namespace Pyro\Module\Addons;

/**
 * PyroCMS Theme Definition
 *
 * This class should be extended to allow for theme management.
 *
 * @author		Stephen Cozart
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Libraries
 * @abstract
 */
abstract class AbstractTheme
{
    /**
     * The theme slug.
     *
     * @var
     */
    public $slug;

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
    public $type = null;

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
     * @return	mixed
     */
    public function __get($var)
    {
        return ci()->{$var};
    }
}

/* End of file AbstractTheme.php */
