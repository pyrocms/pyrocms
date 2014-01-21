<?php namespace Pyro\Module\Streams_core;

use Illuminate\Support\Str;
use Pyro\Support\Fluent;

class EntryFormatter extends Fluent
{
    /**
     * Format Data Constant
     */
    const FORMAT_DATA       = 'data';

    /**
     * Format Plugin Constant
     */
    const FORMAT_PLUGIN     = 'plugin';

    /**
     * Format Plugin Constant
     */
    const FORMAT_STRING     = 'string';

    /**
     * Get default attributes
     * @return array
     */
    public function getDefaultAttributes()
    {
        return array();
    }

    /**
     * Get view options
     * @return array
     */
    public function getViewOptions()
    {
        $entryViewOptions = array();

        $viewOptions = $this->get('viewOptions', $this->entry->getStream()->view_options);

        if (! empty($viewOptions)) {

	        foreach ($viewOptions as $key => $value) {

                if (is_string($key) and is_array($value)) {

                    $attributes = array_merge(
                        $value,
                        array('field_slug' => $key)
                    );
                    
                } elseif (is_string($key) and is_string($value)) {

                    $attributes = array(
                        'field_slug' => $key,
                        'template' => $value
                    );
            
                } else {
            
                    $attributes = array('field_slug' => $value);
                }

	            $entryViewOptions[] = new EntryViewOption($attributes);
	        }
        }

        return new EntryViewOptionCollection($entryViewOptions, $this->entry->getAssignments());
    }

    /**
     * Get view options field names
     * @return array
     */
    public function getViewOptionsFieldNames()
    {
    	return $this->getViewOptions()->getFieldNames();
    }

    /**
     * Format entry as data
     * @param  array $attribute_keys
     * @return object
     */
    public function asData($attribute_keys = null)
    {
        $this->format = static::FORMAT_DATA;

        return $this->replicateWithOutput($attribute_keys);
    }

    /**
     * Format entry for Plugin use
     * @param  array $attribute_keys
     * @return object
     */
    public function asPlugin($attribute_keys = null)
    {
        $this->format = static::FORMAT_PLUGIN;

        return $this->replicateWithOutput($attribute_keys);
    }

    public function replicateWithOutput($attribute_keys = null)
    {
        if (is_string($attribute_keys)) {
            $attribute_keys = array($attribute_keys);
        }

        $clone = $this->entry->replicate();

        if (empty($attribute_keys)) {
            $attribute_keys = $this->entry->getAttributeKeys();
        }

        foreach ($attribute_keys as $attribute) {
            $clone->setAttribute($attribute, $this->getOutput($attribute));
        }

        return $clone;
    }

    public function disableFieldMaps($disable_field_maps = false)
    {
        $this->disable_field_maps = $disable_field_maps;

        return $this;
    }

    public function getOutput($attribute)
    {
        // Disable field maps to avoid recursion
        $this->disableFieldMaps(true);

        // Get formatted output
        $output = $this->{'get'.Str::studly($this->format).'Output'}($attribute);

        // Reenable field maps
        $this->disableFieldMaps(false);

        return $output;
    }

    public function toOutputArray()
    {
        $output = array();

        foreach ($this->getAttributeKeys() as $attribute) {

            $output[$attribute] = $this->getOutput($attribute);

        }

        return $output;
    }

    public function getPluginOutput($fieldSlug)
    {
        if ($type = $this->entry->getFieldType($fieldSlug)) {
            return $type->pluginOutput();
        }

        return $this->entry->getAttribute($fieldSlug);
    }

    /**
     * String output
     * @param  string
     * @return string
     */
    public function getStringOutput($fieldSlug)
    {


        if ($fieldSlug instanceof EntryViewOption) {
            $viewOption = $fieldSlug;
            $fieldSlug = $viewOption->get('field_slug');
            $this->template($viewOption->get('template'));
        }

        if ($this->template and ! $this->disable_field_maps) {

            $entry = $this;

/*                $format = isset($template['format']) ? $template['format'] : null;

                switch ($format) {

                    case 'string':
                        $entry = $this->asString($fieldSlug);
                        break;

                    case 'plugin':
                        $entry = $this->asPlugin($fieldSlug);
                        break;

                    case 'data':
                        $entry = $this->asData($fieldSlug);
                        break;

                    default:
                        // nada
                }*/
            //}

            return ci()->parser->parse_string($this->template, array('entry' => $this->entry->toArray()), true, false, array(
                'stream' => $this->stream_slug,
                'namespace' => $this->stream_namespace
            ));

        } elseif ($type = $this->entry->getFieldType($fieldSlug)) {

            return $type->stringOutput();

        }

        return $this->entry->getAttribute($fieldSlug);
    }

    public function setFieldMaps($field_maps = array())
    {
        $this->field_maps = $field_maps;

        return $this;
    }

    /**
     * Is data format
     * @return boolean
     */
    public function isDataFormat()
    {
        return ($this->format == static::FORMAT_DATA);
    }

    /**
     * Is eloquent format
     * @return boolean
     */
    public function isEloquentFormat()
    {
        return ($this->format == static::FORMAT_ELOQUENT);
    }

    /**
     * Is original format
     * @return boolean
     */
    public function isOriginalFormat()
    {
        return ($this->format == static::FORMAT_ORIGINAL);
    }

    /**
     * Is plugin format
     * @return boolean
     */
    public function isPluginFormat()
    {
        return ($this->format == static::FORMAT_PLUGIN);
    }

    /**
     * Is string format
     * @return boolean
     */
    public function isStringFormat()
    {
        return ($this->format == static::FORMAT_STRING);
    }

    /**
     * What format dawg?
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
}