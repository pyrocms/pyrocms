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

        // Filters to display on our table
        $this
            ->with(array('user'))
            ->filters(
                array(
                    'user|username',
                    'user|email',
                    'is_activated' => array(
                        'type'    => 'select',
                        'title'   => 'lang:user:active',
                        'slug'    => 'is_activated',
                        'options' => array(
                            null => '-- ' . lang('user:active') . ' --',
                            'yes'  => lang('global:yes'),
                            'no'  => lang('global:no'),
                        ),
                    ),
                    'is_blocked'   => array(
                        'type'    => 'select',
                        'title'   => 'lang:user:blocked',
                        'slug'    => 'is_blocked',
                        'options' => array(
                            null => '-- ' . lang('user:blocked') . ' --',
                            'yes'  => lang('global:yes'),
                            'no'  => lang('global:no'),
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
                        'template' => '{{ entry:is_activated_lang }}',
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
                        'url'   => 'admin/users/edit/{{ user:id }}',
                        'class' => 'btn-sm btn-warning',
                    ),
                    array(
                        'label' => lang('global:delete'),
                        'url'   => 'admin/users/delete/{{ user:id }}',
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
