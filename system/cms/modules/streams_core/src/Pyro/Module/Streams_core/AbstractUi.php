<?php namespace Pyro\Module\Streams_core;

use Closure;
use Illuminate\Support\Str;
use Pyro\Support\AbstractCallable;

abstract class AbstractUi extends AbstractCallable
{
    /**
     * Construct and bring in assets
     */
    public function __construct(array $attributes = array())
    {
        ci()->load->language('streams_core/pyrostreams');
        ci()->load->config('streams_core/streams');

        // Load the language file
        if (is_dir(APPPATH.'libraries/Streams')) {
            ci()->lang->load('streams_api', 'english', false, true, APPPATH.'libraries/Streams/');
        }

        parent::__construct($attributes);
    }

     /**
     * Get default attributes
     * @return array
     */
    public function getDefaultAttributes()
    {
        return array(
            'addUri' => null,
            'allowSetColumnTitle' => false,
            'assignments' => array(),
            'cancelUri' => null,
            'continueRedirect' => null,
            'createRedirect' => null,
            'defaults' => array(),
            'disableFormOpen' => array(),
            'enableSave' => true,
            'fieldTypeEventsRun' => array(),
            'fieldTypePublicEventsRun' => array(),
            'fieldTypes' => array(),
            'fields' => null,
            'filters' => array(),
            'hidden' => array(),
            'method' => 'new',
            'mode' => 'new',
            'noEntriesMessage' => null,
            'noFieldsMessage' => null,
            'orderBy' => null,
            'orderDirection' => 'asc',
            'returnValidationRules' => false,
            'recaptcha' => false,
            'redirect' => null,
            'result' => null,
            'select' => array('*'),
            'skips' => array(),
            'stream' => null,
            'successMessage' => null,
            'tabs' => null, // @todo - we might rename this to fieldGroups, more generic
            'values' => array(),
            'exitRedirect' => null,
        );
    }

    public function addForm(EntryUi $entry_ui)
    {
        if ($stream = $entry_ui->getStream()) {
            $instance = $entry_ui->isNestedForm(true)->triggerForm();

            foreach ($instance->getFields() as $field_slug => $field) {
                $this->nested_fields[$stream->stream_slug.':'.$stream->stream_namespace.':'.$field_slug] = $field;
            }
        }

        return $this;
    }

    /**
     * Get entry model class
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
     * @param  integer $totalRecords The total records
     * @return array                 The pagination array
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

        } else {

            $this->attributes['pagination'] = null;
        }

        return $this;
    }

    /**
     * Get is multi form value
     * @return boolean
     */
    public function getIsMultiForm()
    {
        return ! empty($this->nested_fields);
    }

    /**
     * Set is_nested_form value
     * @param  boolean
     * @return object
     */
    public function isNestedForm($is_nested_form = false)
    {
        $this->is_nested_form = $is_nested_form;

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
     * Get the object after triggering all the modifiers
     * @param  boolean $array
     * @return object or array
     */
    public function getUi()
    {
        $this->render(true);

        return $this;
    }

    /**
     * Set title
     * @param  string $title
     * @return object
     */
    public function title($title = null)
    {
        ci()->template->title(lang_label($title));

        $this->attributes['title'] = $title;

        return $this;
    }

    /**
     * View
     * @param  string $view [description]
     * @return [type]       [description]
     */
/*    public function view($view = null, $data = array())
    {
        $this->view = $view;
        $this->mergeData($data);

        return $this;
    }*/

    /**
     * View wrapper
     * @param  string $viewWrapper
     * @param  array  $data
     * @return object
     */
    public function viewWrapper($viewWrapper = null, $data = array())
    {
        $this->viewWrapper = $viewWrapper;
        
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->attributes[$key] = $value;
            }            
        }

        return $this;
    }

    /**
     * Set view override option
     * @param  boolean $view_override
     * @return object
     */
/*    public function viewOverride($view_override = false)
    {
        $this->view_override = $view_override;

        return $this;
    }
*/
    /**
     * Set form override option
     * @param  boolean $form_override
     * @return object
     */
/*    public function formOverride($form_override = false)
    {
        $this->form_override = $form_override;

        return $this;
    }
*/
    /**
     * Set the limit
     * @param  integer $limit
     * @return object
     */
/*    public function limit($limit = 0)
    {
        $this->limit = $limit;

        return $this;
    }
*/
    /**
     * On query callback
     * @param  function $callback
     * @return object
     */
    public function onQuery(Closure $callback = null)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On saved callback
     * @param  function $callback
     * @return object
     */
    public function onSaved(Closure $callback)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * On saving callback
     * @param  function $callback
     * @return object
     */
    public function onSaving(Closure $callback)
    {
        $this->addCallback(__FUNCTION__, $callback);

        return $this;
    }

    /**
     * Set order direction
     * @param  string $direction
     * @return object
     */
/*    public function orderDirection($direction = 'asc')
    {
        $this->direction = $direction;

        return $this;
    }
*/
    /**
     * Set order by
     * @param  string $column
     * @return object
     */
/*    public function orderBy($column = null)
    {
        $this->order_by = $column;

        return $this;
    }*/

    /**
     * Set defaults
     * @param  array  $defaults
     * @return object
     */
/*    public function defaults(array $defaults = array())
    {
        $this->defaults = $defaults;

        return $this;
    }*/

    /**
     * Set pagination config
     * @param  [type] $pagination     [description]
     * @param  [type] $paginationUri [description]
     * @return [type]                 [description]
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
     * Set skipped fields
     * @param  array  $skips
     * @return object
     */
/*    public function skips(array $skips = array())
    {
        $this->skips = $skips;

        return $this;
    }
*/
    /**
     * Set enable saving
     * @param  boolean $enable_saving
     * @return object
     */
/*    public function enableSave($enable_save = false)
    {
        $this->enable_save = $enable_save;

        return $this;
    }
*/
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
     * Render the object when treated as a string
     * @return string [description]
     */
    public function __toString()
    {
        return $this->render(true);
    }

}
