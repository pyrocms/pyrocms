<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Support\Str;
use Pyro\Support\Fluent;

class EntryViewOptions extends Fluent
{
    protected $fieldNames = array();

    protected $model;

    public function __construct(EntryModel $model, $viewOptions = array(), $defaultFormat = null)
    {
        $this->model = $model;

        $this->viewOptions($viewOptions, $defaultFormat);
    }

    /**
     * Get view options
     *
     * @return array
     */
    public function viewOptions($options = array(), $defaultFormat = null)
    {
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

                $viewOption = new Fluent(array(
                    'slug'   => $slug,
                    'format' => $format,
                ));

                $relationMethod = Str::camel($slug);

                if ($this->model->hasRelationMethod($relationMethod)) {
                    $viewOption->eager($relationMethod);
                }

                $viewOptions[$slug] = $viewOption;
            }

        } else {

            foreach ($options as $key => $value) {

                if (is_string($key) and is_callable($value)) {

                    $attributes = array(
                        'slug'     => $key,
                        'callback' => $value,
                    );
                } elseif (is_string($key) and is_array($value)) {

                    $attributes = array_merge($value, array('slug' => $key));

                } elseif (is_string($key) and is_string($value) and
                    !in_array($value, $this->getValidFormats())
                ) {

                    $attributes = array(
                        'slug'     => $key,
                        'format'   => 'string',
                        'template' => $value,
                    );

                } elseif (is_string($key) and is_string($value) and
                    in_array($value, $this->getValidFormats())
                ) {

                    $attributes = array(
                        'slug'   => $key,
                        'format' => $value,
                    );

                } else {

                    $attributes = array(
                        'slug' => $value
                    );
                }

                $attributes['format'] = isset($attributes['format']) ? $attributes['format'] : $defaultFormat;

                $relationMethod = Str::camel($attributes['slug']);

                if ($this->model->hasRelationMethod($relationMethod)) {
                    $attributes['eager'] = isset($attributes['eager']) ? $attributes['eager'] : $relationMethod;
                }

                $viewOption = new Fluent($attributes);

                $viewOptions[$viewOption->getSlug()] = $viewOption;
            }
        }

        $this->attributes['viewOptions'] = $viewOptions;

        return $this;
    }

    protected function getValidFormats()
    {
        return array(
            'data',
            'plugin',
            'string',
        );
    }

    public static function make(EntryModel $model, $viewOptions = array(), $defaultFormat = null)
    {
        if ($viewOptions instanceof static) {
            return $viewOptions;
        }

        return new static($model, $viewOptions, $defaultFormat);
    }

    public function getEagerLoads()
    {
        $eagerLoads = array('createdByUser');

        $addEagerLoads = $this->getAddEagerLoads();

        foreach ($this->viewOptions as $key => $viewOption) {

            if ($eager = $viewOption->getEager()) {
                is_array($eager) or $eager = array($eager);

                foreach($eager as &$eagerLoad) {
                    $eagerLoad = Str::camel($eagerLoad);
                }

                $eagerLoads = array_merge($eagerLoads, $eager);
            }
        }

        if (is_array($addEagerLoads) and !empty($addEagerLoads)) {
            $eagerLoads = array_merge($eagerLoads, $addEagerLoads);
        }

        return $eagerLoads;
    }

    /**
     * Get view options field names
     *
     * @return array
     */
    public function getFieldNames()
    {
        if (!empty($this->fieldNames)) {
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

                    $fieldName = lang_label('lang:streams:' . $fieldSlug . '.name');

                }
            }

            $this->fieldNames[$key] = $fieldName;
        }

        return $this->fieldNames;
    }

    /**
     * Get view options field names
     *
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
