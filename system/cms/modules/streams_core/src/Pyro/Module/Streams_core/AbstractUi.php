<?php namespace Pyro\Module\Streams_core;

use Closure;
use Illuminate\Support\Str;
use Pyro\Support\Fluent;

abstract class AbstractUi extends Fluent
{
    /**
     * Boot
     * 
     * @return void
     */
    public function boot()
    {
        ci()->load->language('streams_core/pyrostreams');
        ci()->load->config('streams_core/streams');

        // Load the language file
        if (is_dir(APPPATH.'libraries/Streams')) {
            ci()->lang->load('streams_api', 'english', false, true, APPPATH.'libraries/Streams/');
        }
    }

    /**
     * Get default attributes
     * 
     * @return array
     */
    public function getDefaultAttributes()
    {
        $defaultAttributes = array(
            'assignments' => array(),
            'buttons' => null,
            'content' => null,
            'defaults' => array(),
            'disableFormOpen' => false,
            'enableNestedForm' => false,
            'enableSetColumnTitle' => false,
            'enableSave' => true,
            'errorStart' => null,
            'errorEnd' => null,
            'fieldTypeEventsRun' => array(),
            'fieldTypePublicEventsRun' => array(),
            'fieldTypes' => array(),
            'fields' => null,
            'filters' => array(),
            'formUrl' => null,
            'hidden' => array(),
            'index' => false,
            'limit' => \Settings::get('records_per_page'),
            'messageError' => null,
            'messageSuccess' => null,
            'method' => 'new',
            'mode' => 'new',
            'noEntriesMessage' => null,
            'noFieldsMessage' => null,
            'orderBy' => null,
            'orderDirection' => 'asc',
            'pagination' => null,
            'paginationUri' => index_uri(),
            'returnValidationRules' => false,
            'recaptcha' => false,
            'redirect' => uri_string(),
            'redirectSave' => index_uri(),
            'result' => null,
            'select' => array('*'),
            'skips' => array(),
            'stream' => null,
            'tabs' => null, // @todo - we might rename this to fieldGroups, more generic
            'uriAdd' => null,
            'uriCancel' => index_uri(),
            'viewOverride' => false,
            'formOverride' => false,
            'values' => array(),
        );
        
        // Set redirects to null
        //$redirects = $this->getValidRedirects();

        // Why?
        /*foreach ($redirects as $key) {
            $defaultAttributes['redirect'.Str::studly($key)] = null;
        }*/

        return $defaultAttributes;
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

    /**
     * Messages
     * 
     * @return Pyro\Module\Streams_core\AbstractUi 
     */
    public function messages(array $messages = array())
    {
        foreach ($messages as $key => $value) {
            $method = 'message'.Str::studly($key);
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
     * @return string
     */
    public function getEntryModelClass($stream_slug, $stream_namespace)
    {
        return StreamModel::getEntryModelClass($stream_slug, $stream_namespace);
    }

    /**
     * Total Records
     * 
     * @param  integer $totalRecords The total records
     * @return Pyro\Module\Streams_core\AbstractUi
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
     * Get is multi form value
     * 
     * @return boolean
     */
    public function getIsMultiForm()
    {
        return ! empty($this->nested_fields);
    }

    /**
     * Get the object after triggering all the modifiers
     * 
     * @return Pyro\Module\Streams_core\AbstractUi
     */
    public function getUi()
    {
        $this->render(true);

        return $this;
    }

    /**
     * Set render
     * @param  boolean $return
     * @return object
     */
    public function render($return = false)
    {
        $this->{$this->getTriggerMethod()}();

        if ($return) return $this->content;

        ci()->template->build($this->get('viewWrapper', 'admin/partials/blank_section'), $this->attributes);
    }

    /**
     * Set title
     * @param  string $title
     * @return Pyro\Module\Streams_core\AbstractUi
     */
    public function title($title = null)
    {
        ci()->template->title(lang_label($title));

        $this->attributes['title'] = $title;

        return $this;
    }

    /**
     * View wrapper
     * @param  string $viewWrapper
     * @param  array  $data
     * @return Pyro\Module\Streams_core\AbstractUi
     */
    public function viewWrapper($viewWrapper = null, array $attributes = array())
    {
        $this->viewWrapper = $viewWrapper;
        
        $this->mergeAttributes($attributes);

        return $this;
    }

    /**
     * On query callback
     * @param  function $callback
     * @return Pyro\Module\Streams_core\AbstractUi
     */
    public function onQuery(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On saved callback
     * @param  function $callback
     * @return Pyro\Module\Streams_core\AbstractUi
     */
    public function onSaved(Closure $callback)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On saving callback
     * @param  function $callback
     * @return Pyro\Module\Streams_core\AbstractUi
     */
    public function onSaving(Closure $callback)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * Set pagination config
     * @param  integer $pagination
     * @param  string $paginationUri
     * @return Pyro\Module\Streams_core\AbstractUi
     */
    public function pagination($limit = null, $paginationUri = null)
    {
        $this->limit = $limit;
        $this->paginationUri = $paginationUri;

        // -------------------------------------
        // Find offset URI from array
        // -------------------------------------

        if (is_numeric($this->limit)) {
            $segs = explode('/', $this->$paginationUri);
            $this->offsetUri = count($segs)+1;

            $this->offset = ci()->input->get('page');

            // Calculate actual offset if not first page
            if ( $this->offset > 0 ) {
                $this->offset = ($this->offset - 1) * $this->limit;
            }
        } else {
            $this->offsetUri = null;
            $this->offset = 0;
        }

        return $this;
    }

    /**
     * Set excluded types
     * @param  array  $exclude_types
     * @return object
     */
/*    public function excludeTypes(array $exclude_types = array())
    {
        $this->exclude_types = $exclude_types;

        return $this;
    }*/

    /**
     * Set included types
     * @param  array  $include_types
     * @return object
     */
/*    public function includeTypes(array $include_types = array())
    {
        $this->include_types = $include_types;

        return $this;
    }*/

    /**
     * Set fields
     * @param  string  $columns
     * @param  boolean $exclude
     * @return object
     */
    /*    public function fields($view_options = '*', $exclude = false)
    {
        $this->data->view_options = is_string($view_options) ? array($view_options) : $view_options;
        $this->exclude = $exclude;

        return $this;
    }*/

    /**
     * Redirects
     * 
     * @param string|array $redirect
     * @return Pyro\Module\Streams_core\AbstractUi
     */ 
    public function redirects($redirects = null)
    {
        if (is_string($redirects)) {

            $this->redirectSave($redirects);

        } elseif (is_array($redirects)) {
            
            foreach ($redirects as $key => $value) {

                $this->{'redirect'.Str::studly($key)}($value);
            }
        }

        return $this;
    }

    /**
     * Redirect save
     * 
     * @param string $redirect
     * @return Pyro\Module\Streams_core\AbstractUi 
     */ 
    public function redirectSave($redirect)
    {
        $this->attributes['redirectSave'] = $redirect;

        // There is a high probability this will be the same as uriCancel
        // so we set a default here and you can still override it
        if (! $this->uriCancel) {
            $this->uriCancel($redirect);
        }

        return $this;
    }

    /**
     * Run redirect
     * 
     * @param null|object|array $data
     * @return void
     */
    protected function runRedirect($data = null, $actionName = 'btnAction')
    {
        $uri = site_url(uri_string());

        $action = ci()->input->post($actionName);

        foreach ($this->getValidRedirects() as $name) {
            if ($action == Str::camel($name)) {
                echo $uri = site_url(ci()->parser->parse_string($this->{'redirect'.Str::studly($name)}, $data, true));
            }
        }
die;
        redirect($uri);
    }

    /**
     * Uris
     * 
     * @param array $uris
     * @return Pyro\Module\Streams_core\AbstractUi
     */ 
    public function uris(array $uris = array())
    {
        if (is_array($uris)) {
            foreach ($uris as $key => $value) {
                $this->{'uri'.Str::studly($key)}($value);
            }
        }

        return $this;
    }

    /**
     * Get buttons
     * @return array|null
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Get fields
     * @return array|null
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get filters
     * @return array|null
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Render the object when treated as a string
     * @return string [description]
     */
    public function __toString()
    {
        return $this->render(true);
    }

}
