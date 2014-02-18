<?php namespace Pyro\Module\Streams\Entry;

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
    public function make($model, $skips = array())
    {
        $this->setModel($model);

        foreach ($this->model->getAssignments() as $field) {
            if (!in_array($field->field_slug, $skips)) {
                $this->setRequiredRule($field);
                $this->setUniqueRule($field);
                $this->setSameRule($field);
                $this->setMinRule($field);
                $this->setMaxRule($field);
            }
        }

        ci()->form_validation->set_rules($this->rules);

        return $this;
    }

    /**
     * Set required rule
     * @param $field
     */
    protected function setRequiredRule($field)
    {
        if ($field->required) {
            $this->addRule($field, 'required');
        }
    }

    /**
     * Set unique rule
     * @param $field
     */
    protected function setUniqueRule($field)
    {
        if ($field->unique) {
            $table  = $this->model->getTable();
            $column = $field->getType()->getColumnName();

            $this->addRule($field, 'unique[' . $table . '.' . $column . ']'); // CI unique[table.column]
        }
    }

    /**
     * Set same rule
     * @param $field
     */
    protected function setSameRule($field)
    {
        if ($same = $field->getParameter('same')) {
            $this->addRule($field, 'matches[' . $same . ']'); // CI matches[field]
        }
    }

    /**
     * Set min rule
     * @param $field
     */
    protected function setMinRule($field)
    {
        if ($min = $field->getParameter('min')) {
            $this->addRule($field, 'greater_than[' . $min . ']'); // CI greater_than[value]
        }
    }

    /**
     * Set max rule
     * @param $field
     */
    protected function setMaxRule($field)
    {
        if ($max = $field->getParameter('max')) {
            $this->addRule($field, 'less_than[' . $max . ']'); // CI less_than[value]
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
                'field' => $type->setStream($this->model->getStream())->getFormSlug(),
                'label' => $field->field_name,
                'rules' => '',
            );
        }

        if (!empty($this->rules[$field->field_slug]['rules'])) {
            $this->rules[$field->field_slug]['rules'] .= '|';
        }

        $this->rules[$field->field_slug]['rules'] .= $rule;
    }

    /**
     * Passes
     * @return bool
     */
    public function passes()
    {
        return ci()->form_validation->run();
    }

    /**
     * Fails
     * @return bool
     */
    public function fails()
    {
        return !ci()->form_validation->run();
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
