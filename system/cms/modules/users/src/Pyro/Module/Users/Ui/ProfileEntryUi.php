<?php namespace Pyro\Module\Users\Ui;

use Pyro\Module\Streams\Ui\EntryUi;
use Pyro\Module\Users\Model\Group;

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

        // Group Filter
        $groups         = new Group;
        $groups_options = array();
        foreach ($groups->orderBy('description', 'ASC')->get() as $group) {
            $groups_options[$group->id] = $group->description;
        }
        $placeholder    = array(null => '-- ' . lang('users:group') . ' --');
        $groups_options = $placeholder + $groups_options;


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
                            null  => '-- ' . lang('user:active') . ' --',
                            'yes' => lang('global:yes'),
                            'no'  => lang('global:no'),
                        ),
                    ),
                    'is_blocked'   => array(
                        'type'    => 'select',
                        'title'   => 'lang:user:blocked',
                        'slug'    => 'is_blocked',
                        'options' => array(
                            null  => '-- ' . lang('user:blocked') . ' --',
                            'yes' => lang('global:yes'),
                            'no'  => lang('global:no'),
                        ),
                    ),
                    'country'      => array(
                        'title'   => lang('users:group'),
                        'type'    => 'select',
                        'slug'    => 'group',
                        'options' => $groups_options,
                    )
                )
            // Changes to Query
            )->onQuery(
                function ($query) {

                    $filters = ci()->session->userdata(
                        uri_string()
                        . $this->stream->stream_namespace
                        . '-'
                        . $this->stream->stream_slug
                    );

                    $group = isset($filters['group']) ? $filters['group'] : false;

                    if ($group) {

                        $query = $query
                            ->join('users_groups', 'users_groups.user_id', '=', 'profiles.user_id')
                            ->where('users_groups.group_id', '=', $group);

                    }

                    return $query;
                }
            )
            // Fields to display in our table
            ->fields(
                array(
                    'first_name',
                    'last_name',
                    'email'             => array(
                        'name'     => 'lang:global:email',
                        'template' => '{{ entry:user:email }}',
                    ),
                    'user'              => array(
                        'name'     => 'lang:global:user',
                        'template' => '{{ entry:user:username }}',
                    ),
                    'user_is_activated' => array(
                        'name' => 'lang:user:activated',
                    ),
                    'user_is_blocked'   => array(
                        'name' => 'lang:user:blocked',
                    )
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
