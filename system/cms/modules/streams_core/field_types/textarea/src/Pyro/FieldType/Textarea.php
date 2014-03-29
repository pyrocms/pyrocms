<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Textarea Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Adam Fairholm
 * @copyright      Copyright (c) 2011 - 2012, Adam Fairholm
 */
class Textarea extends FieldTypeAbstract
{
    public $field_type_slug = 'textarea';

    public $db_col_type = 'text';

    public $admin_display = 'full';

    public $version = '1.1.0';

    public $author = array('name' => 'Adam Fairholm', 'url' => 'http://adamfairholm.com');

    public $custom_parameters = array('allow_tags', 'content_type');

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
        // Value
        // We only use the default value if this is a new entry
        if (!$this->entry->getKey()) {
            // If we still don't have a default value, maybe we have it in
            // the old default value string. So backwards compat.
            $value = $this->getParameter('default_value');
        } else {
            $value = $this->value;
        }

        return form_textarea(
            array(
                'name'  => $this->getFormSlug(),
                'id'    => $this->getFormSlug(),
                'value' => $value
            )
        );
    }

    /**
     * Pre-Ouput content
     *
     * @return    string
     */
    public function stringOutput()
    {
        $parse_tags   = $this->getParameter('allow_tags', 'n');
        $content_type = $this->getParameter('content_type', 'html');

        // If this is the admin, show only the source
        // @TODO This is hacky, there will be times when the admin wants to see a preview or something
        if (defined('ADMIN_THEME')) {
            return $this->value;
        }

        // If this isn't the admin and we want to allow tags,
        // let it through. Otherwise we will escape them.
        if ($parse_tags == 'y') {
            $content = ci()->parser->parse_string($this->value, array(), true);
        } else {
            ci()->load->helper('text');
            $content = escape_tags($this->value);
        }

        // Not that we know what content is there, what format should we treat is as?
        switch ($content_type) {
            case 'md':
                ci()->load->helper('markdown');

                return parse_markdown($content);

            case 'html':
                return $content;

            default:
                return strip_tags($content);
        }

    }

    /**
     * Content Type
     *
     * Is this plain text, HTML or Markdown?
     */
    public function paramContentType($value = null)
    {
        $options = array(
            'text' => lang('global:plain-text'),
            'html' => 'HTML',
            'md'   => 'Markdown',
        );

        // Defaults to Plain Text
        $value or $value = 'text';

        return form_dropdown('content_type', $options, $value);
    }

    /**
     * Default Textarea Value
     *
     * @param    [string - value]
     *
     * @return    string
     */
    public function paramDefaultValue($value = null)
    {
        return form_textarea(
            array(
                'name'  => 'default_value',
                'id'    => 'default_value',
                'value' => $value,
            )
        );
    }
}
