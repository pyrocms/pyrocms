<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Encrypt Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Encrypt extends FieldTypeAbstract
{
    public $field_type_slug			= 'encrypt';

    public $db_col_type				= 'long_text';

    public $custom_parameters		= array('hide_typing');

    public $version					= '1.1.0';

    public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

    // --------------------------------------------------------------------------

    /**
     * Process before saving to database
     *
     * @param	array
     * @return	string
     */
    public function preSave()
    {
        ci()->load->library('encrypt');

        return ci()->encrypt->encode($this->value);
    }

    // --------------------------------------------------------------------------

    /**
     * Process before outputting
     *
     * @param	array
     * @return	string
     */
    public function stringOutput()
    {
        ci()->load->library('encrypt');

        $out = ci()->encrypt->decode($this->value);

        // No PyroCMS tags in your ouput!
        return escape_tags($out);
    }

    // --------------------------------------------------------------------------

    /**
     * Output form input
     *
     * @param	array
     * @return	string
     */
    public function formInput()
    {
        ci()->load->library('encrypt');

        $options['name'] 	= $this->getFormSlug();
        $options['id']		= $this->getFormSlug();

        // If we have post data and are returning form
        // values (because of most likely a form validation error),
        // we will just have the posted plain text value
        $options['value'] = ($_POST) ? $this->value : ci()->encrypt->decode($this->value);

        if ($this->getParameter('hide_typing') == 'yes') {
            return form_password($options);
        } else {
            return form_input($options);
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Yes or no box to hide typing
     *
     * @param	[array - param]
     * @return	string
     */
    public function paramHideTyping($value = null)
    {
        $selected 		= ($value == 'no') ? 'no' : 'yes';

        $yes_select 	= ($selected == 'yes') ? true : false;
        $no_select 		= ($selected == 'no') ? true : false;

        $form  = '<ul><li><label>'.form_radio('hide_typing', 'yes', $yes_select).' Yes </label></li>';

        $form .= '<li><label>'.form_radio('hide_typing', 'no', $no_select).' No </label></li></ul>';

        return $form;
    }

}
