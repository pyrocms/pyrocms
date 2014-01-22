<?php namespace Pyro\Module\Streams_core;

use Closure;
use Pyro\Module\Streams_core\Exception\ClassNotInstanceOfEntryException;

class EntryUi extends AbstractUi
{
    /**
     * Search index params or false
     * @var mixed
     */
    protected $index = false;

    /**
     * The filter events that have run
     * @var array
     */
    public $fieldTypeFilterEventsRun = array();

    /**
     * Get default attributes
     * @return array
     */ 
    public function getDefaultAttributes()
    {
        return array_merge(parent::getDefaultAttributes(), array(
            'index' => false,
        ));
    }

    /**
     * Entries Table
     *
     * Creates a table of entries.
      *
     * @param	string - the stream slug
     * @param	string - the stream namespace slug
     * @param	[mixed - pagination, either null for no pagination or a number for per page]
     * @param	[null - pagination uri without offset]
     * @param	[bool - setting this to true will take care of the $this->template business
     * @param	[array - extra params (see below)]
     * @return	mixed - void or string
     *
     * Extra parameters to pass in $extra array:
     *
     * title	- Title of the page header (if using view override)
     *			$extra['title'] = 'Streams Sample';
     *
     * buttons	- an array of buttons (if using view override)
     *			$extra['buttons'] = array(
     *				'label' 	=> 'Delete',
     *				'url'		=> 'admin/streams_sample/delete/-entry_id-',
     *				'confirm'	= true
     *			);
     * columns  - an array of field slugs to display. This overrides view options.
     * 			$extra['columns'] = array('field_one', 'field_two');
     *
      * sorting  - bool. Whether or not to turn on the drag/drop sorting of entries. This defaults
      * 			to the sorting option of the stream.
     *
     * see docs for more explanation
     */
    public static function table($stream_slug, $stream_namespace = null)
    {
        // Prepare the stream, model and trigger method
        $instance = new static;

        $instance->triggerMethod(__FUNCTION__);

        // If we are not passing the stream namespace we probably are passing an Entry model class
        if (! $stream_namespace) {
            $model = new $stream_slug;
        } else {
            $class = $instance->getEntryModelClass($stream_slug, $stream_namespace);
            $model = new $class;     
        }

        if ( ! ($model instanceof EntryDataModel) and ! ($model instanceof EntryModel)) {
            throw new ClassNotInstanceOfEntryException;
        }

        return $instance
            
            ->with($model->getRelationFieldsSlugs())
            
            ->model($model);
    }


    /**
     * trigger table
     * @return void
     */
    protected function triggerTable()
    {
        $this->formatter($this->model->getFormatter());

        $this->formatter->viewOptions($this->fields);

        $this
            ->assignments($this->model->getAssignments())
            
            ->query($this->model->newQuery())
            
            ->stream($this->model->getStream())
            
            ->viewOptions($this->formatter->getViewOptions())
            
            ->fieldNames($this->formatter->getViewOptionsFieldNames())

            ->searchId(isset($_COOKIE['streams_core_filters']) ? $_COOKIE['streams_core_filters'] : null)

            ->runFieldTypeFilterEvents();

        // Allow to modify the query before we execute it
        // We pass the model to get access to its methods but you also can run query builder methods against it
        // Whatever you do on your closure, it must return an EntryBuilder instance
        if ($query = $this->fireOnQuery($this->model) and $query instanceof EntryQueryBuilder) {
            $this->query = $query;
        }

/*        if (isset($this->view_options) and is_array($this->view_options)) {
            $this->select = array_unique(array_merge($this->view_options, array('id')));
            $this->select = array_unique(array_merge($this->view_options, $this->select));
        }
        if (is_array($this->select)) {
            $this->select = array_unique($this->select);
        }
*/
        $this->entries = $this->model
            ->with((array) $this->with)
            ->take($this->limit)
            ->skip($this->offset)
            ->get($this->select);

        if ($this->limit > 0) {
            $this->paginationTotalRecords($this->model->count());    
        }
        
        if ($this->get('sorting', $this->stream->sorting) == 'custom') {
            $instance->stream->sorting = 'custom';

            // As an added measure of obsurity, we are going to encrypt the
            // slug of the module so it isn't easily changed.
            ci()->load->library('encrypt');

            // We need some variables to use in the sort.
            ci()->template->append_metadata('<script type="text/javascript" language="javascript">var stream_id='
                .$this->stream->id.'; var stream_offset='.$offset
                .'; var streams_module="'.ci()->encrypt->encode(ci()->module_details['slug'])
                .'";</script>');

            ci()->template->append_js('streams/entry_sorting.js');
        }

        $this->content = ci()->load->view('streams_core/entries/table', $this->attributes, true);

        return $this;
    }

    /**
     * [form description]
     * @param  string|Pyro\Module\Streams_core\EntryModel $mixed            [description]
     * @param  [type] $stream_namespace [description]
     * @param  [type] $id               [description]
     * @return [type]                   [description]
     */
    public static function form($mixed, $stream_namespace = null, $id = null)
    {
        // Load up things we'll need for the form
        ci()->load->library(array('form_validation'));

        // Prepare the stream, model and trigger method
        $instance = new static;

        $instance->triggerMethod(__FUNCTION__);

        if ($instance->isSubclassOfEntryModel($mixed)) {
            $instance->entryModel = new $mixed;

            if (is_numeric($stream_namespace)) {
                $id = $stream_namespace;

                $instance->entryModel = $instance->entryModel->find($id);
            }
        
        } elseif ($mixed instanceof EntryModel and $mixed->getKey()) {
        
            $instance->entryModel = $mixed;
        
        } else {

            if ($stream_namespace) {
                $mixed = $class = $instance->getEntryModelClass($mixed, $stream_namespace);
            }

            $instance->entryModel = new $mixed;
            
            if ($id) {
                $instance->entryModel = $instance->entryModel->find($id);
            }
        }

        if (! $instance->entryModel) {
            // Throw error;
        }

        return $instance;
    }

    /**
     * trigger the form
     * @return string The triggered HTML
     */
    protected function triggerForm()
    {
        $this->fireOnSaving($this->entryModel);

        // Automatically index in search?
        if ($this->index) {
            $this->entryModel->setSearchIndexTemplate($this->index);
        }

        $this->stream = $this->entryModel->getStream();
        $this->form = $this->entryModel->newFormBuilder()->addAttributes($this->attributes);
        
        $this->fields = $this->form->buildForm() ?: new FieldCollection;

        if ($this->getIsMultiForm()) {

            $original_fields = $this->fields;

            $this->fields = array();

            foreach ($original_fields as $field_slug => $field) {
                $this->fields[$this->stream->stream_slug.':'.$this->stream->stream_namespace.':'.$field_slug] = $field;
            }

            $this->fields->merge($this->nested_fields);
        }

        if ($saved = $this->form->result() and $this->enable_save and ! $this->is_nested_form) {
            $this->fireOnSaved($saved);

            // Ooohh where to go..
            switch (ci()->input->post('btnAction')) {

                // Boring.
                case 'save':
                    $url = site_url(ci()->parser->parse_string($this->redirect, $saved->toArray(), true));
                    break;

                // Exit
                case 'save_exit':
                    $url = site_url(ci()->parser->parse_string($this->exitRedirect, $saved->toArray(), true));
                    break;

                // Create
                case 'save_create':
                    $url = site_url(ci()->parser->parse_string($this->createRedirect, $saved->toArray(), true));
                    break;

                // Continue
                case 'save_continue':
                    $url = site_url(ci()->parser->parse_string($this->continueRedirect, $saved->toArray(), true));
                    break;

                // Donknow
                default:
                    $url = site_url(uri_string());
                    break;
            }

            redirect($url);
        }

        $this->formUrl  = $_SERVER['QUERY_STRING'] ? uri_string().'?'.$_SERVER['QUERY_STRING'] : uri_string();

        if (empty($this->tabs)) {
            $this->content  = ci()->load->view($this->view ?: 'streams_core/entries/form', $this->attributes, true);
        } else {
            $this->tabs = $this->distributeFields($this->tabs, $this->fields->getFieldSlugs());

            $this->content  = ci()->load->view($this->view ?: 'streams_core/entries/tabbed_form', $this->attributes, true);
        }

        return $this;
    }

    /**
     * Distribute fields across tabs
     * @param  array  $tabs
     * @param  array  $available_fields
     * @return array
     */
    protected function distributeFields($tabs = array(), $available_fields = array())
    {
        foreach ($tabs as &$tab) {
            if ( ! empty($tab['fields']) and is_array($tab['fields'])) {
                foreach ($tab['fields'] as $field) {
                    if (isset($available_fields[$field])) unset($available_fields[$field]);
                }
            }
        }

        foreach ($tabs as &$tab) {
            if ( ! empty($tab['fields']) and $tab['fields'] === '*') {
                $tab['fields'] = $available_fields;

                break;
            }
        }

        return $tabs;
    }

    /**
     * Run Field Filter Events
     *
     * Runs all the filterEvent() functions for some
     * stream fields. The filterEvent() functions usually
     * have field asset loads.
     *
     * @access 	public
     * @param 	obj - stream fields
     * @param 	[array - skips]
     * @return 	array
     */
    // $stream_fields, $skips = array(), $values = array()
    public function runFieldTypeFilterEvents()
    {
        if ( ! $this->assignments or ( ! is_array($this->assignments) and ! is_object($this->assignments))) return null;

        foreach ($this->assignments as $field) {
            // We need the slug to go on.
            if ( ! $type = $field->getType($this->entryModel)) {
                continue;
            }

            $type->setStream($this->model->getStream());

            if ( ! in_array($field->field_slug, $this->get('skips', array()))) {
                // If we haven't called it (for dupes),
                // then call it already.
                if ( ! in_array($field->field_type, $this->fieldTypeFilterEventsRun)) {
                    $type->filterEvent();
                    $this->fieldTypeFilterEventsRun[] = $field->field_type;
                }

                // Field filter events run per field regardless of it the type
                // event ran or not
                $type->filterFieldEvent();
            }
        }
    }
}
