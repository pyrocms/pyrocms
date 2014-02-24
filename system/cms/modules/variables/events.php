<?php

class Events_Variables
{
    public function __construct()
    {
        Events::register('field_field_type_updated', array($this, 'field_field_type_updated'));
    }

    public function field_field_type_updated($data)
    {
        if ($data['stream']->stream_namespace == 'variables' and $data['stream']->stream_slug == 'variables') {
            ci()->cache->forget('variables.variables');
        }
    }
}
