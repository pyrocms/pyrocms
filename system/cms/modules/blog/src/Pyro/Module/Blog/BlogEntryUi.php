<?php namespace Pyro\Module\Blog;

use Pyro\Module\Streams_core\EntryUi;

class BlogEntryUi extends EntryUi
{
    /**
     * Get default attributes
     * @return array
     */
    public function getDefaultAttributes()
    {
        // Filters to display on our table
        $filters = array(
            'title',
            'status',
        );

        // Fields to display in our table
        $fields = array(
            'title' => array(
                'title',
            ),
        );

        // Buttons to display in our table
        $buttons = array(
            array(
                'url' => '{{ url }}',
                'label' => lang('global:view'),
                'class' => 'btn-sm btn-info',
            ),
            array(
                'url' => 'admin/blog/edit/{{ id }}',
                'label' => lang('global:edit'),
                'class' => 'btn-sm btn-warning',
            ),
            array(
                'url' => 'admin/blog/delete/{{ id }}',
                'label' => lang('global:delete'),
                'class' => 'btn-sm btn-danger',
                'confirm' => true
            )
        );

        // Tab structure for our form
        $tabs = array(
            array(
                'title'     => lang('blog:content_label'),
                'id'        => 'blog-content-tab',
                'fields'    => array(
                    'title',
                    'slug',
                    'status',
                    'body',
                ),
            ),
            array(
                'title'     => lang('global:custom_fields'),
                'id'        => 'profile-fields',
                'fields'    => '*'
            ),
        );

        return array_merge(
            parent::getDefaultAttributes(), array(
                'filters' => $filters,
                'fields' => $fields,
                'buttons' => $buttons,
                'tabs' => $tabs,
                'skips' => array(),
            )
        );
    }
}
