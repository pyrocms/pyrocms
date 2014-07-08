<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Email Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Email extends FieldTypeAbstract
{
    public $field_type_slug				= 'email';

    public $db_col_type					= 'string';

    public $extra_validation			= 'valid_email';

    public $version						= '1.0.0';

    public $author						= array('name'=>'Parse19', 'url'=>'http://parse19.com');

    // --------------------------------------------------------------------------

    /**
     * Output form input
     *
     * @param	array
     * @param	array
     * @return	string
     */
    public function formInput()
    {
        $options['name'] 	= $this->getFormSlug();
        $options['id']		= $this->getFormSlug();
        $options['value']	= $this->value;

        return form_input($options);
    }

    // --------------------------------------------------------------------------

    /**
     * Pre Output
     *
     * No PyroCMS tags in email fields.
     *
     * @return string
     */
    public function stringOutput()
    {
        ci()->load->helper('text');
        return escape_tags($this->value);
    }

    // --------------------------------------------------------------------------

    /**
     * Process before outputting for the plugin
     *
     * This creates an array of data to be merged with the
     * tag array so relationship data can be called with
     * a {field.column} syntax
     *
     * @param	string
     * @param	string
     * @param	array
     * @return	array
     */
    public function pluginOutput()
    {
        $data = array();

        $data['email_address']		= $this->value;
        $data['mailto_link']			= mailto($this->value, $this->value);
        $data['safe_mailto_link']	= safe_mailto($this->value, $this->value);

        return $data;
    }

    // --------------------------------------------------------------------------

    /**
     * Process before outputting for PHP
     *
     * @return  object
     */
    public function dataOutput()
    {
        $data = new \stdClass;

        $data->email_address       = $this->value;
        $data->mailto_link         = mailto($this->value, $this->value);
        $data->safe_mailto_link    = safe_mailto($this->value, $this->value);

        return $data;
    }
}
