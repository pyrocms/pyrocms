<?php namespace Pyro\Module\Templates\Presenter;

use Pyro\Module\Streams\Entry\EntryPresenter;

class TemplateEntryPresenter extends EntryPresenter
{
    /**
     * Link preview
     *
     * @return string
     */
    public function linkPreview()
    {
        $uri        = 'admin/templates/preview/' . $this->resource->id;
        $string     = $this->resource->name;
        $attributes = 'class="link" data-toggle="modal" data-target="#modal"';

        return anchor($uri, $string, $attributes);
    }

    /**
     * Buttons
     *
     * @return string
     */
    public function buttons()
    {
        $uri     = 'admin/templates/edit/' . $this->resource->id;
        $string  = lang('global:edit');
        $class   = 'btn-sm btn-warning';
        $buttons = '<a href="' . $uri . '" class="' . $class . '">' . $string . '</a>';

        if (!$this->resource->is_default) {
            $uri     = 'admin/templates/delete/' . $this->resource->id;
            $string  = lang('global:delete');
            $class   = 'btn-sm btn-danger confirm';
            $buttons = '<a href="' . $uri . '" class="' . $class . '">' . $string . '</a> ' . $buttons;
        } else {
            $uri     = '#';
            $string  = lang('global:delete');
            $class   = 'btn-sm btn-default';
            $buttons = '<a onclick="return false;" href="' . $uri . '" class="' . $class . '">' . $string . '</a> ' . $buttons;
        }

        return $buttons;
    }
}
