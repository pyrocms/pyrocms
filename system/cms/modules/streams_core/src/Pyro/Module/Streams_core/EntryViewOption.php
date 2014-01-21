<?php namespace Pyro\Module\Streams_core;

use Illuminate\Support\Fluent;

class EntryViewOption extends Fluent
{
	public function getFieldName()
	{
        if ($this->fieldName) {
            
            return lang_label($this->fieldName);
        }

		$field = $this->fields->findBySlug($this->field_slug);

        return $field ? $field->field_name : lang_label('lang:streams:'.$this->field_slug.'.name');
	}
}