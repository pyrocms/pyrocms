<?php namespace Pyro\Module\Streams\Entry;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Pyro\Module\Users\Model\User;
use Pyro\Support\Presenter;

class EntryPresenter extends Presenter
{
    /**
     * Entry view options
     *
     * @var EntryViewOptions
     */
    protected $entryViewOptions;

    /**
     * Appends to array
     *
     * @var array
     */
    protected $appends = array(
        'createdByUser',
        'linkEdit',
        'linkDetails',
    );

    /**
     * Create a new EntryPresenter instance
     *
     * @param EntryModel       $model
     * @param EntryViewOptions $entryViewOptions
     */
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
        $resourceArray = $this->getResourceArray();

        foreach (array_keys($resourceArray) as $key) {
            $resourceArray[Str::snake($key)] = $this->getPresenterAttribute($key, $resourceArray);
        }

        return $resourceArray;
    }

    /**
     * Get presenter formatted attribute
     *
     * @param  string $key
     * @return mixed
     */
    public function getPresenterAttribute($key, $resourceArray = null)
    {
        $method = Str::camel($key);

        $viewOption = $this->entryViewOptions->getBySlug($key);

        if ($viewOption and $callback = $viewOption->getCallback()) {

            return call_user_func($callback, $this->resource);

        } elseif ($viewOption and $template = $viewOption->getTemplate()) {

            return ci()->parser->parse_string(
                $template,
                array('entry' => $resourceArray ? : $this->getResourceArray()),
                true,
                false,
                array(
                    'stream'    => $this->resource->getStreamSlug(),
                    'namespace' => $this->resource->getStreamNamespace()
                ),
                false
            );

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

        return $this->resource->getAttribute($key);
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
     * @return string
     */
    protected function getUserOutput($value)
    {
        return ci()->parser->parse_string('<a href="admin/users/edit/{{ id }}">{{ username }}</a>', $value, true);
    }

    /**
     * Link edit
     *
     * @return string
     */
    public function linkEdit()
    {
        $url    = $this->urlEdit();
        $string = $this->resource->getTitleColumnValue();

        return anchor($url, $string, 'class="link"');
    }

    /**
     * Url edit
     *
     * @return string
     */
    public function urlEdit()
    {
        $stream = $this->resource->getStream();
        $key    = $this->resource->getKey();
        return site_url('admin/' . $stream->stream_namespace . '/' . $stream->stream_slug . '/edit/' . $key);
    }

    /**
     * Link details
     *
     * @return string
     */
    public function linkDetails()
    {
        $url    = $this->urlDetails();
        $string = $this->resource->getTitleColumnValue();

        return anchor($url, $string, 'class="link"');
    }

    /**
     * Url details
     *
     * @return string
     */
    public function urlDetails()
    {
        $stream = $this->resource->getStream();
        $key    = $this->resource->getKey();
        return site_url('admin/' . $stream->stream_namespace . '/' . $stream->stream_slug . '/details/' . $key);
    }

    /**
     * String output
     *
     * @param  string
     * @return string
     */
    protected function getStringOutput($key = null)
    {
        if ($type = $this->resource->getFieldType($key)) {

            return $type->stringOutput();

        } elseif ($this->isDate($value = $this->resource->getAttribute($key))) {

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
     * @return bool
     */
    protected function isUser($value = null)
    {
        return $value instanceof User;
    }

    public function getResourceTitle()
    {
        if (method_exists($this->resource, 'getTitleColumnValue')) {
            return $this->resource->getTitleColumnValue();
        }

        return null;
    }

    /**
     * Get field type relationship item template
     *
     * @return string
     */
    public function getFieldTypeRelationshipItemTemplate()
    {
        return "'<div>' + item.{$this->resource->getTitleColumn()} + '</div>'";
    }

    /**
     * Get field type relationship option template
     *
     * @return string
     */
    public function getFieldTypeRelationshipOptionTemplate()
    {
        return "'<div>' + item.{$this->resource->getTitleColumn()} + '</div>'";
    }
}
