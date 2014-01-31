<?php namespace Pyro\Module\Streams_core;

use Pyro\Support\Fluent;

class EntryViewOptions extends Fluent
{
    protected $fieldNames = array();

	public function __construct(EntryModel $model, $viewOptions = array(), $defaultFormat = null)
	{
        $this
            ->model($model)
            ->viewOptions($viewOptions, $defaultFormat);
	}

    protected function getValidFormats()
    {
        return array(
            'data',
            'plugin',
            'string',
        );
    }

    /**
     * Get view options
     * @return array
     */
    public function viewOptions($options = array(), $defaultFormat = null)
    {
        if ($options instanceof static) {
            
            $this->attributes['viewOptions'] = $options->getViewOptions();
            
            return $this;
        }

        $viewOptions = array();

        if (empty($options)) {
            $options = $this->model->getStream()->view_options;
        }

        if (empty($options)) {
            $options = $this->model->getDefaultFields();
        }

        if (is_string($options)) {

            $format = $options;

            foreach ($this->model->getFieldSlugs() as $slug) {

                $viewOptions[$slug] = new Fluent(array(
                    'slug' => $slug,
                    'format' => $format,
                ));
            }

        } else {

            foreach ($options as $key => $value) {
                
                if (is_string($key) and is_callable($value)) {
                    
                    $attributes = array(
                        'slug' => $key,
                        'callback' => $value,
                    );                
                }
                elseif (is_string($key) and is_array($value)) {

                    $attributes = array_merge($value, array('slug' => $key));
                
                } elseif (is_string($key) and is_string($value) and 
                    ! in_array($value, $this->getValidFormats())) {

                    $attributes = array(
                        'slug' => $key,
                        'format' => 'string',
                        'template' => $value,
                    );
            
                } elseif (is_string($key) and is_string($value) and 
                    in_array($value, $this->getValidFormats())) {

                    $attributes = array(
                        'slug' => $key,
                        'format' => $value,
                    );
            
                } else {
            
                    $attributes = array(
                        'slug' => $value
                    );
                }

                $attributes['format'] = isset($attributes['format']) ? $attributes['format'] : $defaultFormat;

                $viewOption = new Fluent($attributes);

                $viewOptions[$viewOption->getSlug()] = $viewOption;
            }  
        }

        $this->attributes['viewOptions'] = $viewOptions;

        return $this;
    }


    /**
     * Get view options field names
     * @return array
     */
    public function getFieldNames()
    {
        if (! empty($this->fieldNames)) {
            return $this->fieldNames;
        }

        foreach ($this->viewOptions as $key => $viewOption) {

            if ($viewOption->getName()) {
                
                $fieldName = lang_label($viewOption->getName());
            
            } else {

                $fieldSlug = $viewOption->getSlug();

                if ($field = $this->model->getField($fieldSlug)) {

                    $fieldName = $field->field_name;
                
                } else {
                
                    $fieldName = lang_label('lang:streams:'.$fieldSlug.'.name');

                }
            }

            $this->fieldNames[$key] = $fieldName;
        }

        return $this->fieldNames;
    }

    /**
     * Get view options field names
     * @return array
     */
    public function getFieldSlugs()
    {
        return array_keys($this->viewOptions);
    }

    public function getBySlug($slug = null)
    {
        return isset($this->viewOptions[$slug]) ? $this->viewOptions[$slug] : null;
    }
}