<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams URL Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Url extends FieldTypeAbstract
{
    public $field_type_slug = 'url';

    public $db_col_type = 'string';

    public $extra_validation = 'valid_url';

    public $version = '1.0.0';

    public $custom_parameters = array(
        'placeholder',
    );

    public $author = array(
        'name' => 'Ryan Thompson - PyroCMS',
        'url'  => 'http://pyrocms.com/',
    );

    ///////////////////////////////////////////////////////////////////////////////
    // -------------------------	METHODS 	  ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Output form input
     *
     * @param    array
     * @param    array
     *
     * @return    string
     */
    public function formInput()
    {
        $options['name']        = $this->getFormSlug();
        $options['id']          = $this->getFormSlug();
        $options['value']       = $this->value;
        $options['class']       = 'form-control';
        $options['placeholder'] = 'http://example.com';

        return form_input($options);
    }

    /**
     * Pre Output
     *
     * No PyroCMS tags in URL fields.
     *
     * @return string
     */
    public function stringOutput()
    {
        ci()->load->helper('text');

        return escape_tags($this->value);
    }

    ///////////////////////////////////////////////////////////////////////////////
    // -------------------------	PARAMETERS 	  ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Placeholder!
     *
     * @return    string
     */
    public function paramPlaceholder($value = 'http://example.com/')
    {
        return form_input('placeholder', $value);
    }
}
