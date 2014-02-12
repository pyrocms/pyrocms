<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Text Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Text extends FieldTypeAbstract
{
    public $field_type_slug = 'text';

    public $db_col_type = 'string';

    public $version = '1.0.0';

    public $author = array('name' => 'Parse19', 'url' => 'http://parse19.com');

    public $custom_parameters = array('max_length', 'default_value');

    /**
     * Pre Output
     *
     * No PyroCMS tags in text input fields.
     *
     * @return string
     */
    public function stringOutput()
    {
        ci()->load->helper('text');

        return escape_tags($this->value);
    }
}
