<?php namespace Pyro\Module\Users\Ui;

use Pyro\Module\Streams\Ui\EntryUi;

class ProfileEntryUi extends EntryUi
{
    /**
     * Get default attributes
     *
     * @return array
     */
    public function boot()
    {
        parent::boot();

        $this
            ->with(array('user'))
            ->filters(
                array(
                    'user|username',
                    'user|email',
                    'is_activated'  => array(
                        'type'    => 'select',
                        'title'   => 'lang:user:active',
                        'slug'    => 'is_activated',
                        'options' => array(
                            null => '-- ' . lang('user:active') . ' --',
                            '1'  => lang('global:yes'),
                            '0'  => lang('global:no'),
                        ),
                    ),
                )
            )
            // Fields to display in our table
            ->fields(
                array(
                    'first_name',
                    'last_name',
                    'activated' => array(
                        'name'     => 'lang:user:activated_account_title',
                        'template' => '{{ if entry:is_activated }}{{ helper:lang line="global:yes" }}{{ else }}{{ helper:lang line="global:no" }}{{ endif }}',
                    ),
                    'user'      => array(
                        'name'     => 'lang:global:user',
                        'template' => '{{ entry:user:username }}',
                    ),
                    'email'     => array(
                        'name'     => 'lang:global:email',
                        'template' => '{{ entry:user:email }}',
                    ),
                )
            )
            // Buttons to display in our table
            ->buttons(
                array(
                    array(
                        'label' => lang('global:edit'),
                        'url'   => 'admin/users/edit/{{ id }}',
                        'class' => 'btn-sm btn-warning',
                    ),
                    array(
                        'label' => lang('global:delete'),
                        'url'   => 'admin/users/delete/{{ id }}',
                        'class' => 'btn-sm btn-danger confirm',
                    ),
                )
            )
            ->messages(
                array(
                    'success' => 'User saved.'
                )
            ) // @todo - language
            ->redirects('admin/users');
    }
}
