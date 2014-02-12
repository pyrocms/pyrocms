<?php namespace Pyro\Module\Streams\Entry;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Pyro\Module\Users\Model\User;
use Pyro\Support\Presenter;

class EntryPresenter extends Presenter
{
    protected $entryViewOptions;

    protected $appends = array('createdByUser');

    public function __construct(EntryModel $model, EntryViewOptions $entryViewOptions)
    {
        $this->resource = $model;

        $this->entryViewOptions = $entryViewOptions;
    }

    /**
     * Convert the object to an array
     *
     * @return array
     */
    public function toArray()
    {
        $presenterArray = $this->getAppendsAttributes();

        foreach ($this->resource->getAttributeKeys() as $key) {
            $resourceArray[$key] = $this->getPresenterAttribute($key);
        }

        return array_merge($resourceArray, $presenterArray);
    }

    /**
     * Get presenter formatted attribute
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function getPresenterAttribute($key)
    {
        $method = Str::camel($key);

        $viewOption = $this->entryViewOptions->getBySlug($key);

        if ($viewOption and $callback = $viewOption->getCallback()) {

            return call_user_func($callback, $this->resource);

        } elseif (method_exists($this, $method)) {

            return $this->{$method}();

        } elseif ($viewOption and $format = $viewOption->getFormat()) {

            $fieldTypeMethod = Str::studly($format) . 'Output';

            $method = 'get' . $fieldTypeMethod;

            if (method_exists($this, $method)) {
                return $this->{$method}($key);
            }

            if ($fieldType = $this->resource->getFieldType($key)) {
                return $fieldType->{$fieldTypeMethod}();
            }
        }

        return $this->resource->$key;
    }

    /**
     * Get created by user
     *
     * @return string
     */
    public function createdByUser()
    {
        return $this->getUserOutput($this->resource->createdByUser);
    }

    /**
     * Get user output
     *
     * @param $value
     *
     * @return string
     */
    protected function getUserOutput($value)
    {
        return ci()->parser->parse_string('<a href="admin/users/edit/{{ id }}">{{ username }}</a>', $value, true);
    }

    /**
     * String output
     *
     * @param  string
     *
     * @return string
     */
    protected function getStringOutput($key = null)
    {
        $template = null;

        if ($viewOption = $this->entryViewOptions->getBySlug($key)) {
            $template = $viewOption->getTemplate();
        }

        $value = $this->resource->getAttribute($key);

        if ($template) {

            return ci()->parser->parse_string(
                $template,
                array('entry' => $this->resource),
                true,
                false,
                array(
                    'stream'    => $this->resource->getStreamSlug(),
                    'namespace' => $this->resource->getStreamNamespace()
                )
            );

        } elseif ($type = $this->resource->getFieldType($key)) {

            return $type->stringOutput();

        } elseif ($this->isDate($value)) {

            return $this->getDateOutput($value);

        } elseif ($this->isUser($value)) {

            return $this->getUserOutput($value);

        }

        return $value;
    }

    /**
     * Its datetime object?
     *
     * @param null $value
     *
     * @return bool
     */
    protected function isDate($value = null)
    {
        return $value instanceof Carbon;
    }

    /**
     * Get date output
     *
     * @param $value
     *
     * @return mixed
     */
    protected function getDateOutput($value)
    {
        return $value->format(\Settings::get('date_format'));
    }

    /**
     * Its a User model?
     *
     * @param null $value
     *
     * @return bool
     */
    protected function isUser($value = null)
    {
        return $value instanceof User;
    }
}