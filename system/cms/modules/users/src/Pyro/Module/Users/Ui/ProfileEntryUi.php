<?php namespace Pyro\Module\Users\Ui;

use Pyro\Module\Streams_core\EntryUi;

class ProfileEntryUi extends EntryUi
{
    /**
     * Get default attributes
     * @return array
     */
    public function getDefaultAttributes()
    {
        // Filters to display on our table
        // Filters
        $filters = array(
            'user' => array(
                'type' => 'text',
                'title' => 'lang:global:user',
                'slug' => 'user',
            ),
            'email' => array(
                'type' => 'text',
                'title' => 'lang:global:email',
                'slug' => 'email',
            ),
            'is_activated' => array(
                'type' => 'select',
                'title' => 'lang:user:active',
                'slug' => 'is_activated',
                'options' => array(
                    null => '-- '.lang('user:active').' --',
                    '1' => lang('global:yes'),
                    '0' => lang('global:no'),
                ),
            ),
        );

        // Fields to display in our table
        $fields = array(
            'first_name',
            'last_name',
            'lang:user:activated_account_title' => '{{ if entry:is_activated }}{{ helper:lang line="global:yes" }}{{ else }}{{ helper:lang line="global:no" }}{{ endif }}',
            'lang:global:user' => '{{ entry:username }}',
            'lang:global:email' => '{{ entry:email }}',
        );

        // Buttons to display in our table
        $buttons = array(
            array(
                'label' => lang('global:edit'),
                'url' => 'admin/users/edit/{{ id }}',
                'class' => 'btn-sm btn-warning',
            ),
            array(
                'label' => lang('global:delete'),
                'url' => 'admin/users/delete/{{ id }}',
                'class' => 'btn-sm btn-danger confirm',
            ),
        );

        return array_merge(
            parent::getDefaultAttributes(), array(
                'filters' => $filters,
                'fields' => $fields,
                'buttons' => $buttons,
                'skips' => array(),
            )
        );
    }
}
