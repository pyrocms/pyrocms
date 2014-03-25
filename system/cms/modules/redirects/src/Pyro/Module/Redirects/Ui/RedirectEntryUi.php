<?php namespace Pyro\Module\Redirects\Ui;

use Pyro\Module\Streams\Ui\EntryUi;

class RedirectEntryUi extends EntryUi
{
    /**
     * Boot
     *
     * @return array
     */
    public function boot()
    {
        parent::boot();

        $this
            ->orderBy('from')
            ->sort('asc')
            ->filters(
                array(
                    'from',
                    'to',
                    'type',
                )
            )
            ->fields(
                array(
                    'from',
                    'to',
                    'type',
                )
            )
            ->buttons(
                array(
                    array(
                        'label' => 'lang:global:edit',
                        'url'   => 'admin/redirects/edit/{{ id }}',
                        'class' => 'btn-sm btn-warning',
                    ),
                    array(
                        'label' => 'lang:global:delete',
                        'url'   => 'admin/redirects/delete/{{ id }}',
                        'class' => 'btn-sm btn-danger confirm',
                    ),
                )
            )
            ->messages(
                array(
                    'success' => lang('redirects:edit_success'),
                    'error'   => lang('redirects:edit_error'),
                )
            )
            ->redirects(
                'admin/redirects'
            );
    }
}
