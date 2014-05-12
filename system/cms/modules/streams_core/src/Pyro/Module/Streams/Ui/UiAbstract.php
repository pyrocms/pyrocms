<?php namespace Pyro\Module\Streams\Ui;

use Closure;
use Illuminate\Support\Str;
use Pyro\Model\Eloquent;
use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Support\Fluent;

abstract class UiAbstract extends Fluent
{
    /**
     * Set the model
     *
     * @param Eloquent $model
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function model(Eloquent $model)
    {
        $this->model = $model;
        $this->query = $model->newQuery();

        return $this;
    }


    /**
     * Get the model
     *
     * @return Pyro\Model\Eloquent;
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Messages
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function messages(array $messages = array())
    {
        foreach ($messages as $key => $value) {
            $method = 'message' . Str::studly($key);
            $this->{$method}($value);
        }

        return $this;
    }

    public function errors($start = null, $end = null)
    {
        return $this->errorStart($start)->errorEnd($end);
    }

    /**
     * Get entry model class
     *
     * @param $stream_slug
     * @param $stream_namespace
     *
     * @return string
     */
    public function getEntryModelClass($stream_slug, $stream_namespace)
    {
        return StreamModel::getEntryModelClass($stream_slug, $stream_namespace);
    }

    /**
     * Get is multi form value
     *
     * @return boolean
     */
    public function getIsMultiForm()
    {
        return !empty($this->nested_fields);
    }

    /**
     * Get the object after triggering all the modifiers
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function getUi()
    {
        $this->render(true);

        return $this;
    }

    /**
     * Set render
     *
     * @param  boolean $return
     *
     * @return object
     */
    public function render($return = false)
    {
        $this->{$this->getTriggerMethod()}();

        if ($return) {
            return $this->content;
        }

        ci()->template->build($this->getViewWrapper('admin/partials/blank_section'), $this->attributes);
    }

    /**
     * Set title
     *
     * @param  string $title
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function title($title = null)
    {
        ci()->template->title(lang_label($title));

        $this->attributes['title'] = $title;

        return $this;
    }

    /**
     * View wrapper
     *
     * @param  string $viewWrapper
     * @param  array  $data
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function viewWrapper($viewWrapper = null, array $attributes = array())
    {
        $this->viewWrapper = $viewWrapper;

        $this->mergeAttributes($attributes);

        return $this;
    }

    /**
     * On form callback
     *
     * @param  function $callback
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function onForm(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On table callback
     *
     * @param  function $callback
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function onTable(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On query callback
     *
     * @param  function $callback
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function onQuery(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On saved callback
     *
     * @param  function $callback
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function onSaved(Closure $callback)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On saving callback
     *
     * @param  function $callback
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function onSaving(Closure $callback)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * Set pagination config
     *
     * @param  integer $pagination
     * @param  string  $paginationUri
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function pagination($limit = null, $paginationUri = null)
    {
        $this->limit         = $limit;
        $this->paginationUri = $paginationUri;

        // -------------------------------------
        // Find offset URI from array
        // -------------------------------------

        if (is_numeric($this->limit)) {
            $segs            = explode('/', $this->$paginationUri);
            $this->offsetUri = count($segs) + 1;

            $this->offset = ci()->input->get('page');

            // Calculate actual offset if not first page
            if ($this->offset > 0) {
                $this->offset = ($this->offset - 1) * $this->limit;
            }
        } else {
            $this->offsetUri = null;
            $this->offset    = 0;
        }

        return $this;
    }

    /**
     * Redirects
     *
     * @param string|array $redirect
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function redirects($redirects = null)
    {
        if (is_string($redirects)) {

            $this->redirectSave($redirects);

        } elseif (is_array($redirects)) {

            foreach ($redirects as $key => $value) {

                $this->{'redirect' . Str::studly($key)}($value);
            }
        }

        return $this;
    }

    /**
     * Redirect save
     *
     * @param string $redirect
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function redirectSave($redirect)
    {
        $this->attributes['redirectSave'] = $redirect;

        // There is a high probability this will be the same as uriCancel
        // so we set a default here and you can still override it
        if (!$this->uriCancel) {
            $this->uriCancel($redirect);
        }

        return $this;
    }

    /**
     * Uris
     *
     * @param array $uris
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    public function uris(array $uris = array())
    {
        if (is_array($uris)) {
            foreach ($uris as $key => $value) {
                $this->{'uri' . Str::studly($key)}($value);
            }
        }

        return $this;
    }

    /**
     * Set excluded types
     *
     * @param  array $exclude_types
     *
     * @return object
     */
    /*    public function excludeTypes(array $exclude_types = array())
        {
            $this->exclude_types = $exclude_types;

            return $this;
        }*/

    /**
     * Set included types
     *
     * @param  array $include_types
     *
     * @return object
     */
    /*    public function includeTypes(array $include_types = array())
        {
            $this->include_types = $include_types;

            return $this;
        }*/

    /**
     * Set fields
     *
     * @param  string  $columns
     * @param  boolean $exclude
     *
     * @return object
     */
    /*    public function fields($view_options = '*', $exclude = false)
    {
        $this->data->view_options = is_string($view_options) ? array($view_options) : $view_options;
        $this->exclude = $exclude;

        return $this;
    }*/

    /**
     * Get buttons
     *
     * @return array|null
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Get fields
     *
     * @return array|null
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get filters
     *
     * @return array|null
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Render the object when treated as a string
     *
     * @return string [description]
     */
    public function __toString()
    {
        return $this->render(true);
    }

    /**
     * Get default attributes
     *
     * @return array
     */
    protected function boot()
    {
        ci()->load->language('streams_core/pyrostreams');
        ci()->load->config('streams_core/streams');

        // Load the language file
        if (is_dir(APPPATH . 'libraries/Streams')) {
            ci()->lang->load('streams_api', 'english', false, true, APPPATH . 'libraries/Streams/');
        }

        $this
            ->assignments(array())
            ->buttons(array())
            ->content(null)
            ->defaults(array())
            ->disableFilters(false)
            ->disableFormOpen(false)
            ->enableNestedForm(false)
            ->enableSetColumnTitle(false)
            ->enableSave(true)
            ->enableSortableHeaders(true)
            ->errorStart(null)
            ->errorEnd('<br>')
            ->fieldTypeEventsRun(array())
            ->fieldTypePublicEventsRun(array())
            ->fieldTypes(array())
            ->fields(null)
            ->filters(array())
            ->formUrl(null)
            ->hidden(array())
            ->index(false)
            ->limit(\Settings::get('records_per_page'))
            ->messageError('There was an error.')
            ->messageSuccess('Entry saved.')
            ->method('new')
            ->mode('new')
            ->new(true)
            ->noEntriesMessage(null)
            ->noFieldsMessage(null)
            /*->orderBy('id')
            ->sort('desc')*/
            ->paginationUri(uri_string())
            ->returnValidationRules(false)
            ->recaptcha(false)
            ->redirect(uri_string())
            ->redirectSave(index_uri())
            ->result(null)
            ->select(array('*'))
            ->showColumnHeaders(true)
            ->showFooter(true)
            ->showFilters(true)
            ->showPagination(true)
            ->showLimitDropdown(true)
            ->showResultsCount(true)
            ->skips(array())
            ->stream(null)
            ->tabs(null)
            ->tableClass('table table-hover n-m')
            ->tableRowClass(null)
            ->uriAdd(null)
            ->uriCancel(index_uri())
            ->viewOverride(false)
            ->formOverride(false)
            ->values(array());
    }

    /**
     * Total Records
     *
     * @param  integer $totalRecords The total records
     *
     * @return Pyro\Module\Streams\AbstractUi
     */
    protected function paginationTotalRecords($paginationTotalRecords = null)
    {
        if ($this->limit > 0 and $paginationTotalRecords) {
            $pagination = create_pagination(
                $this->paginationUri,
                $this->paginationTotalRecords = $paginationTotalRecords,
                $this->limit, // Limit per page
                $this->offsetUri // URI segment
            );

            $pagination['links'] = str_replace('-1', '1', $pagination['links']);

            $this->attributes['pagination'] = $pagination;

        }

        return $this;
    }

    /**
     * Run redirect
     *
     * @param null|object|array $data
     *
     * @return void
     */
    protected function runRedirect($data = null, $actionName = 'btnAction')
    {
        $uri = site_url(uri_string());

        $action = ci()->input->post($actionName);

        foreach ($this->getValidRedirects() as $name) {
            if ($action == Str::camel($name)) {
                $uri = site_url(ci()->parser->parse_string($this->{'redirect' . Str::studly($name)}, $data, true));
            }
        }

        redirect($uri);
    }

    /**
     * Get valid redirects
     *
     * @return array
     */
    public function getValidRedirects()
    {
        return array(
            'create',
            'save',
            'exit',
            'continue'
        );
    }

}
