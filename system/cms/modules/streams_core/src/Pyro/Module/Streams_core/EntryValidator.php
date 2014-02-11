<?php namespace Pyro\Module\Streams_core;

use Illuminate\Support\Str;

class EntryValidator
{
    /**
     * Rules
     * @var array
     */
    protected $rules = array();

    /**
     * Model
     * @var null
     */
    protected $model = null;

    public function __construct()
    {
        ci()->load->library('form_validation');
    }

    /**
     * Make validator
     * @param $model
     * @return $this
     */
    public function make($model)
    {
        $this->setModel($model);

        $this->setRequiredRules();

        return $this;
    }

    protected function setRequiredRules()
    {
        foreach ($this->model->assignments as $field) {
            if ($field->required) {
                $this->addRule($field, 'required');
            }
        }
    }

    /**
     * Add a validation rule for a field
     * @param $field
     * @param $rule
     */
    protected function addRule($field, $rule)
    {
        if (!isset($this->rules[$field->field_slug]) and $type = $field->getType()) {
            $this->rules[$field->field_slug] = array(
                'field'   => $type->getColumnName(),
                'label'   => $field->field_name,
                'rules'   => '',
            );
        }

        $this->rules[$field->field_slug]['rules'] .= $rule;
    }

    /**
     * Set model
     * @param null $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }
}
