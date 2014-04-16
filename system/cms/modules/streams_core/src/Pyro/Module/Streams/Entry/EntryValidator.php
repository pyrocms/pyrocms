<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Support\Str;
use Pyro\Module\Streams\Field\FieldModel;

class EntryValidator
{
    /**
     * Rules
     *
     * @var array
     */
    protected $rules = array();

    /**
     * Model
     *
     * @var EntryModel|null
     */
    protected $model = null;

    protected $data = array();

    public function __construct(EntryModel $model = null)
    {
        ci()->load->library('form_validation');

        if ($model) {
            $this->setModel($model, $skips);
        }
    }

    public function validate($data = array())
    {
        // If no input is passed use the model data
        if (empty($data)) {
            $data = $this->data;
        }

        ci()->form_validation->reset_validation();
        ci()->form_validation->set_data($data);
        ci()->form_validation->set_rules($this->rules);

        if ($this->rules) {
            return ci()->form_validation->run();
        } else {
            return true;
        }
    }

    /**
     * Set model
     *
     * @param null $model
     */
    public function setModel(EntryModel $model, $skips = array())
    {
        $this->model = $model;

        $stream = $this->model->getStream();

        $attributes = $this->model->getAttributes();

        // Get non-relation attributes
        foreach ($this->model->getAssignments() as $field) {

            $type = $field->getType();

            if (!in_array($field->field_slug, $skips) and !$type->alt_process) {
                $this->data[$type->setStream($stream)->getFormSlug()] = isset($attributes[$type->getColumnName(
                )]) ? $attributes[$type->getColumnName()] : null;
                $this->setRequiredRule($field);
                $this->setUniqueRule($field);
                $this->setSameRule($field);
                $this->setMinRule($field);
                $this->setMaxRule($field);
            }
        }

        return $this;
    }

    /**
     * Set required rule
     *
     * @param $field
     */
    protected function setRequiredRule(FieldModel $field)
    {
        if ($field->is_required) {
            $this->addRule($field, 'required');
        }
    }

    /**
     * Set unique rule
     *
     * @param $field
     */
    protected function setUniqueRule(FieldModel $field)
    {
        if ($field->is_unique and !$this->model->getKey()) {
            $table  = $this->model->getTable();
            $column = $field->getType()->getColumnName();

            $this->addRule($field, 'unique[' . $table . '.' . $column . ']'); // CI unique[table.column]
        }
    }

    /**
     * Set same rule
     *
     * @param $field
     */
    protected function setSameRule(FieldModel $field)
    {
        if ($same = $field->getParameter('same')) {
            $this->addRule($field, 'matches[' . $same . ']'); // CI matches[field]
        }
    }

    /**
     * Set min rule
     *
     * @param $field
     */
    protected function setMinRule(FieldModel $field)
    {
        if ($min = $field->getParameter('min')) {
            $this->addRule($field, 'greater_than[' . $min . ']'); // CI greater_than[value]
        }
    }

    /**
     * Set max rule
     *
     * @param $field
     */
    protected function setMaxRule(FieldModel $field)
    {
        if ($max = $field->getParameter('max')) {
            $this->addRule($field, 'less_than[' . $max . ']'); // CI less_than[value]
        }
    }

    /**
     * Add a validation rule for a field
     *
     * @param $field
     * @param $rule
     */
    protected function addRule(FieldModel $field, $rule)
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
}
