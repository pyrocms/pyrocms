<?php namespace Pyro\Module\Variables;

use Pyro\Module\Variables\Model\VariableEntryModel;

/**
 * Variable Library
 *
 * Handles the variables data
 *
 * @author		PyroCMS Dev Team
 * @package  	PyroCMS\Core\Modules\Variables\Libraries
 */
class Variables
{
    private static $_vars = null;

    // ------------------------------------------------------------------------

    /**
     * Magic get
     *
     * Used to pull out a variable's data
     *
     * @param	string
     * @return 	mixed
     */
    public function __get($name)
    {
        // Variables are being used on this site and they
        // haven't been loaded yet... now eager load them

        // the requested variable isn't in the database or cache; set it to null
        return $this->get($name);
    }

    // ------------------------------------------------------------------------

    /**
     * Magic set
     *
     * Used to set a variable's data
     *
     * @param	string
     * @return 	mixed
     */
    public function __set($name, $value)
    {
        // if $this->_vars is null then load them all as this is
        // the first time this library has been touched
        $this->all();

        $this->set($name, $value);
    }

    public static function get($name)
    {
        return isset(static::$_vars[$name]) ? static::$_vars[$name] : null;
    }

    public static function set($name, $value = null)
    {
        return static::$_vars[$name] = $value;
    }

    // ------------------------------------------------------------------------

    /**
     * Get all
     *
     * Get an array of all the vars
     *
     * @return array
     */
    public static function all()
    {
        $variables = new VariableEntryModel;

        // the variables haven't been fetched yet, load them
        if ( ! static::$_vars) {
            $entries = $variables->setCacheMinutes(30)->get(array('name', 'data'));

            foreach ($entries as $var) {
                static::set($var['name'], $var['data']);
            }
        }

        return static::$_vars;
    }
}

/* End of file Variables.php */
