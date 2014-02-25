<?php

use Illuminate\Support\Str;
use Pyro\Module\Streams\Entry\EntryModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Module\Streams\Ui\EntryUi;

/**
 * Streams Plugin
 *
 * @package        Streams
 * @author         Ryan Thompson - PyroCMS
 * @copyright      Copyright (c) 2008 - 2013, Ryan Thompson - PyroCMS
 * @license        http://www.aiwebsystems.com/docs/streams
 * @link           http://www.aiwebsystems.com/streams
 */
class Plugin_Streams_core extends Plugin
{

    /**
     * Cache Vars
     * These variables control the cache of
     * PyroStreams tags.
     */
    public $cache_type = 'query'; // tag or query
    public $cache_time_format = 'minutes'; // minutes or seconds
    public $cache_ttl = null; // num of seconds or minutes
    public $cache_hash = null;
    public $write_tag_cache = false; // Whether or not we need
    public $runtime_cache = array();

    /**
     * Possible entries parameters
     *
     * @var array
     */
    public $entries_parameters = array(
        'stream'     => null,
        'namespace'  => null,
        'select'     => '*',
        'load'       => null,
        'limit'      => null,
        'date_by'    => 'created_at',
        'where'      => null,
        'exclude'    => null,
        'exclude_by' => 'id',
        'include'    => null,
        'include_by' => 'id',
        'order_by'   => 'created_at',
        'sort'       => 'desc',
        'debug'      => 'no',
    );

    /**
     * Possible form parameters
     *
     * @var array
     */
    public $form_parameters = array(
        'stream'                 => null,
        'namespace'              => null,
        'entry_id'               => null,
        'id'                     => null,
        'use_recaptcha'          => 'no',
        'save_success_message'   => 'lang:streams:new_entry_success',
        'save_error_message'     => 'lang:streams:new_entry_error',
        'update_success_message' => 'lang:streams:edit_entry_success',
        'update_error_message'   => 'lang:streams:edit_entry_error',
        'skips'                  => null,
        'include'                => null,
        'exclude'                => null,
        'hidden'                 => null,
        'order'                  => null,
        'class'                  => null,
        'redirect'               => null,
        'exit_redirect'          => null,
        'continue_redirect'      => null,
        'create_redirect'        => null,
        'cancel_uri'             => null,
    );

    /**
     * Possible pagination configuration parameters
     *
     * @var array
     */
    public $pagination_configuration = array(
        'num_links',
        'full_tag_open',
        'full_tag_close',
        'first_link',
        'first_tag_open',
        'first_tag_close',
        'prev_link',
        'prev_tag_open',
        'prev_tag_close',
        'cur_tag_open',
        'cur_tag_close',
        'num_tag_open',
        'num_tag_close',
        'next_link',
        'next_tag_open',
        'next_tag_close',
        'last_link',
        'last_tag_open',
        'last_tag_close',
        'suffix',
        'first_url',
        'reuse_query_string'
    );

    /**
     * Default Calendar Template
     *
     * @access    public
     * @var        string
     */
    public $calendar_template = '

        {table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}

        {heading_row_start}<tr>{/heading_row_start}

        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}

        {cal_cell_content}{day}{content}{/cal_cell_content}
        {cal_cell_content_today}<div class="highlight">{day}{content}</div>{/cal_cell_content_today}

        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}
    ';

    ///////////////////////////////////////////////////////////////////////////////
    // --------------------------	  METHODS 	  ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * PyroStreams Plugin Construct
     * Just a bunch of loads and prep
     *
     * @access    public
     * @return    void
     */
    public function __construct()
    {
    }

    /**
     * _call
     * Fun little method to call a stream without
     * using cycle. Like:
     * {{ streams:stream }}
     *
     * @access    public
     *
     * @param    string
     * @param    string
     *
     * @return    void
     */
    public function __call($stream, $data)
    {
        return $this->entries($stream);
    }

    /**
     * Entries
     * Get entries in a stream.
     *
     * @access    public
     *
     * @param    string [$stream]    Option stream slug to pass.
     *
     * @return    string
     */
    public function entries($stream = null)
    {
        // Toggle debug mode
        $this->debug_status = $this->getAttribute('debug', 'on');

        // Load languages desired
        self::loadLanguages();

        // -------------------------------------
        // Get Plugin Attributes
        // -------------------------------------

        $parameters = array();

        foreach ($this->entries_parameters as $parameter => $parameter_default) {
            $parameters[$parameter] = $this->getAttribute($parameter, $parameter_default);
        }

        // -------------------------------------
        // Stream Slug Override
        // -------------------------------------
        // If we have a stream slug that has been
        // passed, we will take that value over
        // the passed $parameters value. This is so
        // if we have {{ streams:stream stream="another" }}
        // We will ignore "another" in favor of "stream"
        // -------------------------------------

        if ($stream) {
            $parameters['stream'] = $stream;
        }

        // -------------------------------------
        // Cache
        // -------------------------------------
        // Setup cache. If we have a full tag cache,
        // we will just go ahead and return that.
        // -------------------------------------

        $this->setupCache();

        if (!is_null($tag_cache = $this->getTagCache())) {
            return $tag_cache;
        }

        // -------------------------------------
        // Set Namespace
        // -------------------------------------
        // We can manually set the namespace
        // via a namespce="" parameter.
        // -------------------------------------

        $parameters['namespace'] = ($parameters['namespace']) ? $parameters['namespace'] : 'streams';

        // -------------------------------------
        // Stream Data Check
        // -------------------------------------
        // Check for a retrieve our stream.
        // -------------------------------------

        if (!isset($parameters['stream']) and $parameters['debug'] == 'yes') {
            $this->error(lang('streams:no_stream_provided'));
        }


        $stream = StreamModel::getStream($parameters['stream'], $parameters['namespace']);

        if (!$stream and $parameters['debug'] == 'yes') {
            $this->error(lang('streams:invalid_stream'));
        }

        // -------------------------------------
        // Get Entries
        // -------------------------------------

        if ($this->cache_type == 'query' and is_numeric($this->cache_ttl)) {
            // Try cache
            if (!$entries = ci()->cache->get($this->cache_hash)) {

                // Nothin.. Get entries
                $entries = self::get($stream, $parameters);

                // Save to cache
                ci()->cache->put($this->cache_hash, $entries, $this->cache_ttl);
            }
        } else {
            $entries = self::get($stream, $parameters);
        }

        // -------------------------------------
        // Rename
        // -------------------------------------
        // Allows us to rename variables in our
        // parameters. So, rename:old_name="new_name"
        // -------------------------------------

        $renames = array();

        foreach ($this->getAttributes() as $key => $to) {
            if (substr($key, 0, 7) == 'rename:' and strlen($key) > 7) {
                $pieces = explode(':', $key);

                $renames[$pieces[1]] = $to;
            }
        }

        if ($renames) {
            foreach ($entries as $k => &$entry) {
                foreach ($renames as $from => $to) {
                    if (isset($entry->{$from})) {
                        $entry->{$to} = $entry->$from;
                        unset($entry->{$from});
                    }
                }
            }
        }

        // -------------------------------------
        // Cache End Procedures
        // -------------------------------------

        $this->writeTagCache($entries);
        //$this->clearCacheVariables();

        // -------------------------------------
        //print_r($entries);die;
        return $entries;
    }

    /**
     * Loop through attributes and load
     * languages like foo_lang="foo/foo"
     *
     * @return void
     */
    private function loadLanguages()
    {
        // Load languages
        foreach ($this->getAttributes() as $key => $lang) {
            if (substr($key, -5) == '_lang') {
                ci()->lang->load($lang);
            }
        }
    }

    /**
     * Setup the Cache Vars
     * Set cache type, time format, and hash
     *
     * @access    private
     * @return    void
     */
    private function setupCache()
    {
        // 'tag' or 'query'
        $this->cache_type = $this->getAttribute('cache_type', 'query');

        // 'minutes' or 'seconds' or 'hours'
        $this->cache_time_format = $this->getAttribute('cache_time_format', 'minutes');

        // num of seconds / minutes / hours
        $this->cache_ttl = $this->getAttribute('cache_ttl', null);

        // Format the cache time.
        if (is_numeric($this->cache_ttl)) {
            // Seconds (do nothing)

            // Use minutes?
            if ($this->cache_time_format == 'minutes') {
                $this->cache_ttl = $this->cache_ttl * 60;
            }

            // Use hours?
            if ($this->cache_time_format == 'hours') {
                $this->cache_ttl = $this->cache_ttl * 3600;
            }
        }

        $this->setupCacheHash();
    }

    /**
     * Set the cache hash
     * This creates a unique cache hash based on the
     * unique set of tag parameters.
     *
     * @access    private
     * @return    void
     */
    private function setupCacheHash()
    {
        $this->cache_hash = md5(
            'streams_core' . implode('-', $this->getAttributes()) . (is_string($this->content()) ? $this->content(
            ) : null) . $_SERVER['QUERY_STRING']
        );
    }

    /**
     * Full tag cache
     *
     * @access    private
     * @return    mixed - null or string
     */
    private function getTagCache()
    {
        if (!$this->cache_hash) {
            $this->setupCacheHash();
        }

        // Check to see if we have a tag cache.
        if ($this->cache_type == 'tag' and !is_null($this->cache_ttl)) {
            if (!$tag_cache_content = ci()->cache->get($this->cache_hash)) {
                // Set this so functions know to write the
                // cache when necesary.
                $this->write_tag_cache = true;
            } else {
                return $tag_cache_content;
            }
        }

        return null;
    }

    /**
     * Output debug message or just
     * return false.
     *
     * @access    private
     *
     * @param    string
     *
     * @return    mixed
     */
    private function error($msg)
    {
        return ($this->debug_status == 'on') ? show_error($msg) : false;
    }

    /**
     * Get entries
     *
     * @return array
     */
    public function get($stream, $parameters)
    {
        // Build the runtime hash
        $hash = md5($stream . implode('', $parameters));

        // Does the runtime cache result exist?
        if (!isset($this->runtime_cache[$hash])) {

            /**
             * Get everything started
             */

            $entries = EntryModel::stream($stream)->select(explode('|', $parameters['select']));


            /**
             * Where statement
             */

            if ($parameters['where']) {
                $entries->whereRaw($parameters['where']);
            }


            /**
             * Process joins
             */

            foreach ($this->getAttributes() as $attribute => $value) {

                // Prefixed with "join_"?
                if (substr($attribute, 0, 5) == 'join_') {

                    // Grab the arguments
                    list($arg1, $condition, $arg2) = explode('|', $value);

                    // Execute it
                    $entries->join(substr($attribute, 5), $arg1, $condition, $arg2);
                }
            }


            /**
             * Lazy load (expiramental)
             */
            if ($parameters['load']) {
                $entries->with(explode('|', $parameters['load']));
            }


            /**
             * Limit
             */

            $entries->limit($parameters['limit']);


            /**
             * Order by
             */

            $entries->orderBy($parameters['order_by'], $parameters['sort']);


            /**
             * Debug
             */

            if ($parameters['debug'] == 'yes') {
                echo $entries->toSql();
            }


            /**
             * Get entries
             */

            $entries = $entries->enableAutoEagerLoading(true)->remember(10)->get()->getPresenter('plugin');


            /**
             * Process entries
             */

            foreach ($entries as $k => &$entry) {

                // Add the count
                $entry['count']       = $k;
                $entry['human_count'] = $k + 1;
            }

            $this->runtime_cache[$hash] = $entries;

        } else {
            $entries = $this->runtime_cache[$hash];
        }

        return $entries;
    }

    /**
     * Write tag cache if we need to
     *
     * @access    private
     *
     * @param    string - the content to write
     *
     * @return    void
     */
    private function writeTagCache($content)
    {
        if ($this->write_tag_cache === true) {
            ci()->cache->put($this->cache_hash, $content, $this->cache_ttl);
        }
    }

    /**
     * Field Function
     * Calls the plugin override function
     */
    public function field()
    {
        // Get the stream
        $stream = StreamModel::findBySlugAndNamespace($this->getAttribute('stream'), $this->getAttribute('namespace'));

        // Get the field type
        $field = FieldModel::findBySlugAndNamespace(
            $this->getAttribute('field_slug'),
            $this->getAttribute('namespace')
        );

        // Do we have a stream?
        if ($entry = EntryModel::stream($stream)) {

            // Do we have an entry?
            if ($this->getAttribute('entry_id') and $entry = $entry::find($this->getAttribute('entry_id'))) {

                // Sweet Jesus we do - get the bootstrapped type
                $type = $entry->getFieldType($field->field_slug);
            } else {

                // We don't - but we have what we need
                $type = $entry->getFieldType($field->field_slug);
            }
        }

        // Set the plugin
        $type->setPlugin($this);

        // Pattern the method name
        $method = 'plugin' . Str::studly($this->getAttribute('method'));

        // If the method exists - go for it
        // No reason for testing if plugin_override here..
        // Rage of motion is pretty limited already
        if (method_exists($type, $method)) {

            $arguments = array();

            foreach ($this->getAttributes() as $attribute => $value) {
                if (substr($attribute, 0, 4) == 'arg_') {
                    $arguments[substr($attribute, 4)] = $value;
                }
            }

            return call_user_func_array(array($type, $method), $arguments);
        }
    }

    /**
     * Return a shuffled array of entries
     *
     * @return array
     */
    public function shuffle()
    {
        $entries = self::entries();

        shuffle($entries);

        return $entries;
    }

    /**
     * Entry
     * Show a single stream entry.
     *
     * @access    public
     * @return    array
     */
    public function entry()
    {
        $this->setAttribute('limit', 1);

        $return = $this->entries();

        return empty($return) ? false : ci()->parser->parse_string(
            $this->content(),
            $return[0],
            true,
            false,
            null,
            false
        );
    }

    /**
     * Pagination
     *
     * @return string
     */
    public function pagination()
    {
        // Get a total
        $total = self::total();

        // Whip it up
        $pagination = create_pagination(
            $pag_uri = $this->getAttribute('pag_uri', uri_string()),
            $total,
            $limit = $this->getAttribute('limit', $this->entries_parameters['limit']),
            $offset_uri = 2
        );

        // Do whatever this is
        $pagination['links'] = str_replace('-1', '1', $pagination['links']);

        return $pagination;
    }

    /**
     * Get total entries
     *
     * @return integer
     */
    public function total()
    {
        // -------------------------------------
        // Get Plugin Attributes
        // -------------------------------------

        $parameters = array();

        foreach ($this->entries_parameters as $parameter => $parameter_default) {
            $parameters[$parameter] = $this->getAttribute($parameter, $parameter_default);
        }

        // Boom. Stream.
        $stream = StreamModel::getStream($parameters['stream'], $parameters['namespace']);

        // Start up the query
        $entries = EntryModel::stream($stream)
            ->select('id')
            ->whereRaw($parameters['where'])
            ->limit($parameters['limit'])
            ->orderBy($parameters['order_by'], $parameters['sort']);

        // Check for joins
        foreach ($this->getAttributes() as $attribute => $value) {

            // Prefixed with "join_"?
            if (substr($attribute, 0, 5) == 'join_') {

                // Grab the arguments
                list($arg1, $condition, $arg2) = explode('|', $value);

                // Execute it
                $entries->join(substr($attribute, 5), $arg1, $condition, $arg2);
            }
        }

        return $entries = $entries->count();
    }

    /**
     * Output an input form for a stream
     *
     * @access    public
     * @return    array
     */
    public function form()
    {
        // Load languages desired
        self::loadLanguages();

        // -------------------------------------
        // Get Plugin Attributes / Paramaters
        // -------------------------------------

        $attributes = $this->getAttributes();

        $parameters = array();

        foreach ($this->form_parameters as $parameter => $parameter_default) {
            $parameters[$parameter] = $this->getAttribute($parameter, $parameter_default);
        }

        $parameters = array_merge($attributes, $parameters);

        // -------------------------------------
        // Fire up EntryUi
        // -------------------------------------

        $form = new EntryUi;

        $form = $form->form($parameters['stream'], $parameters['namespace'], $parameters['entry_id']);

        /**
         * Set default values
         */

        // Get em!
        $defaults = array();

        foreach ($this->getAttributes() as $key => $default) {
            if (substr($key, -8) == '_default') {
                $defaults[substr($key, 0, -8)] = $default;
            }
        }

        $form = $form->defaults($defaults);

        /**
         * Skip fields
         */

        // Determine initial skips from the include / exclude params
        $skips = $this->getSkipsFromSkipsIncludeExclude(
            $parameters['skips'],
            $parameters['include'],
            $parameters['exclude'],
            $form->model->getStream()
        );

        if (!empty($skips)) {
            $form = $form->skips($skips);
        }

        /**
         * Hide these fields
         */

        if ($parameters['hidden']) {
            $form = $form->hidden(explode('|', $parameters['hidden']));
        }

        /**
         * Set some redirects
         */

        if ($parameters['redirect']) {
            $form = $form->redirectSave($parameters['redirect']);
        } else {
            $form = $form->redirectSave(ci()->uri->uri_string());
        }

        /*if ($parameters['redirect_exit'])
            $form = $form->redirectExit($parameters['redirect_exit']);*/

        /*if ($parameters['redirect_continue'])
            $form = $form->redirectContinue($parameters['redirect_continue']);*/

        /*if ($parameters['redirect_create'])
            $form = $form->redirectCreate($parameters['redirect_create']);*/

        /*if ($parameters['uri_cancel'])
            $form = $form->uriCancel($parameters['uri_cancel']);*/

        /**
         * Set success and error messages
         */

        /*if (! $parameters['entry_id'])
            $form = $form->messages(array(
                'success' => $parameters['save_message_success'],
                'error' => $parameters['save_message_error'],
            ));
        else
            $form = $form->messages(array(
                'success' => $parameters['update_message_success'],
                'error' => $parameters['update_message_error'],
            ));*/

        /**
         * DONE = Fetch the object
         */

        $fields = $form->getUi()->fields->toArray();

        /**
         * Override any labels
         */

        foreach ($fields as $k => $field) {
            if (isset($parameters[$field['field']['field_slug'] . '_label'])) {
                $fields[$k]['field_name'] = $parameters[$field['field']['field_slug'] . '_label'];
            }
        }

        /**
         * Override form order
         */

        if ($parameters['order']) {
            $fields = $this->reorderFormFields($fields, $parameters['order']);
        }

        /**
         * Build our return
         */

        $return = array(
            'fields'     => $fields,
            'form_open'  => form_open_multipart(ci()->uri->uri_string(), array('class' => $parameters['class'])),
            'form_close' => '</form>',
        );

        foreach ($fields as $k => $field) {

            // Copy it
            $return[$field['field']['field_slug']] = $field;
        }

        // Return our goodness
        return array($return);
    }

    /**
     * Get all the skips from skips, includes and excludes
     *
     * @param  mixed  $skips
     * @param  mixed  $include
     * @param  mixed  $exclude
     * @param  object $stream
     *
     * @return array
     */
    private function getSkipsFromSkipsIncludeExclude($skips, $include, $exclude, $stream)
    {
        // Make sure these are arrays
        $skips   = is_string($skips) ? explode('|', $skips) : $skips;
        $include = is_string($include) ? explode('|', $include) : $include;
        $exclude = is_string($exclude) ? explode('|', $exclude) : $exclude;

        // Get the streams assignments first
        $assignments = $stream->assignments->toArray();

        // Manually set skips first
        $skips = $skips;

        // Are we using include?
        if (!empty($include)) {

            // Skip unless they're in the include
            foreach ($assignments as $assignment) {

                // Is it included?
                if (!in_array($assignment['field']['field_slug'], $include)) {

                    // Nope.. Seeya
                    $skips[] = $assignment['field']['field_slug'];
                }
            }
        }

        // Skip excludes
        foreach ((array)$exclude as $skip) {
            $skips[] = $skip;
        }

        // Return unique
        return array_unique($skips);
    }

    ///////////////////////////////////////////////////////////////////////////////
    // --------------------------	 UTILITIES 	  ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Reorder the form inputs
     *
     * @param  array  $fields
     * @param  string $order Pipe delimited field slugs
     *
     * @return array
     */
    private function reorderFormFields($fields, $order)
    {
        $order = explode('|', $order);

        $sorted = array();

        // Loop and save fields as sorted
        foreach ($order as $field_slug) {
            foreach ($fields as $k => $field) {
                if ($field['field']['field_slug'] == $field_slug) {
                    $sorted[] = $field;
                    unset($fields[$k]);
                }
            }
        }

        // Add the rest
        foreach ($fields as $field) {
            $sorted[] = $field;
        }

        return $sorted;
    }

    /**
     * Form assets
     *
     * @access    public
     * @return    string
     */
    public function form_assets()
    {
        if (!empty($this->type->assets)) {
            // Weird fix that seems to work for fixing WYSIWYG
            // since it is throwing missing variable errors
            $html = '<script type="text/javascript">var SITE_URL = "' . $this->config->item('base_url') . '";</script>';

            foreach ($this->type->assets as $asset) {
                $html .= $asset . "\n";
            }

            return $html;
        }
    }

    /**
     * Form CSRF input
     * You might need this if you are not using the {{ form_open }} variable.
     *
     * @access    public
     * @return    mixed - null or string
     */
    public function form_csrf()
    {
        if ($this->config->item('csrf_protection')) {
            return form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash());
        }
    }

    /**
     * Form Fields
     * Allows you to simple show form fields without
     */
    public function form_fields()
    {
        $this->load->library(array('form_validation', 'streams_core/Fields'));

        $mode      = $this->getAttribute('mode', 'new');
        $edit_id   = $this->getAttribute('edit_id', false);
        $stream    = $this->getAttribute('stream');
        $namespace = $this->getAttribute('namespace', $this->core_namespace);
        $include   = $this->getAttribute('include');
        $exclude   = $this->getAttribute('exclude');
        $required  = $this->getAttribute('required', '<span class="required">* required</span>');

        // -------------------------------------
        // Get Stream Data
        // -------------------------------------

        $data->stream = $this->streams_m->get_stream($stream, true, $namespace);

        if (!$data->stream) {
            return lang('streams:invalid_stream');
        }

        $data->stream_id = $data->stream->id;
        $vars            = array();

        // -------------------------------------
        // Get the row in edit mode
        // -------------------------------------

        $entry = false;

        if ($mode == 'edit') {
            $entry = $this->row_m->get_row($edit_id, $data->stream, false);
        }

        // -------------------------------------
        // Set up skips & values
        // -------------------------------------

        $stream_fields = $this->streams_m->get_stream_fields($data->stream_id);

        $skips = $this->determine_skips($include, $exclude, $data->stream_id, $stream_fields);

        $values = $this->fields->set_values($stream_fields, $entry, $mode, $skips);

        // -------------------------------------
        // Get & Return Fields
        // -------------------------------------

        $vars['fields'] = $this->fields->build_fields($stream_fields, $values, $entry, $mode, $skips, $required);

        // -------------------------------------
        // Individual Field Access
        // -------------------------------------
        // For greater form control, this allows
        // users to access each form item
        // individually.
        // -------------------------------------

        foreach ($vars['fields'] as $field) {
            $vars[$field['input_slug']]['label'] = $field['input_title'];
            $vars[$field['input_slug']]['slug']  = $field['input_slug'];
            $vars[$field['input_slug']]['value'] = $field['value'];

            if ($field['input_parts'] !== false) {
                $vars[$field['input_slug']]['input']       = $field['input_parts'];
                $vars[$field['input_slug']]['input_built'] = $field['input'];
            } else {
                $vars[$field['input_slug']]['input']       = $field['input'];
                $vars[$field['input_slug']]['input_built'] = $field['input'];
            }

            $vars[$field['input_slug']]['error_raw'] = $field['error_raw'];
            $vars[$field['input_slug']]['error']     = $field['error'];
            $vars[$field['input_slug']]['required']  = ($field['required']) ? true : false;
            $vars[$field['input_slug']]['required']  = $field['required'];
            $vars[$field['input_slug']]['odd_even']  = $field['odd_even'];
        }

        return array($vars);
    }

    /**
     * Determine the fields to skip
     * based on include/exclude
     */
    private function determine_skips($include, $exclude, $stream_id, $stream_fields = null)
    {
        $skips = array();

        if ($include) {
            $includes = explode('|', $include);

            if (is_null($stream_fields)) {
                $stream_fields = $this->streams_m->get_stream_fields($stream_id);
            }

            // We need to skip everything else
            foreach ($stream_fields as $field) {
                if (!in_array($field->field_slug, $includes)) {
                    $skips[] = $field->field_slug;
                }
            }
        }
        if ($exclude) {
            // Exlcudes are just our skips
            $excludes = explode('|', $exclude);

            $skips = array_merge($excludes, $skips);
        }

        return $skips;
    }

    /**
     * Delete a row field
     *
     * @access    public
     * @return    mixed
     */
    public function delete_entry()
    {
        // -------------------------------------
        // General Loads
        // -------------------------------------

        $this->load->library(array('form_validation', 'streams_core/Fields'));

        // -------------------------------------
        // Get vars
        // -------------------------------------

        $stream    = $this->getAttribute('stream');
        $namespace = $this->getAttribute('namespace', $this->core_namespace);
        $entry_id  = $this->getAttribute('entry_id', false);
        $return    = $this->getAttribute('return', '');
        $vars      = array();

        // -------------------------------------
        // Create Hidden Hash
        // -------------------------------------

        $hidden['delete_id'] = md5($stream . $entry_id);

        // -------------------------------------
        // Get Stream Data
        // -------------------------------------

        $stream = $this->streams_m->get_stream($stream, true, $namespace);

        if (!$stream) {
            show_error(lang('streams:invalid_stream'));
        }

        // -------------------------------------
        // Check Delete
        // -------------------------------------

        if (
            $this->input->post('delete_confirm')
            and $this->input->post('delete_id') == $hidden['delete_id']
        ) {
            $this->db->where('id', $entry_id)->delete($stream->stream_prefix . $stream->stream);

            $this->load->helper('url');

            redirect(str_replace('-id-', $entry_id, $return));
        } else {
            // -------------------------------------
            // Get stream fields
            // -------------------------------------

            $this->fields = $this->streams_m->get_stream_fields($stream->id);

            // -------------------------------------
            // Get entry data
            // -------------------------------------
            // We may want to display it
            // -------------------------------------

            $parameters = array(
                'stream'        => $stream->stream,
                'namespace'     => $namespace,
                'id'            => $entry_id,
                'limit'         => 1,
                'offset'        => 0,
                'order_by'      => false,
                'exclude'       => false,
                'show_upcoming' => null,
                'show_past'     => null,
                'where'         => null,
                'disable'       => array(),
                'year'          => null,
                'month'         => null,
                'day'           => null,
                'restrict_user' => 'no',
                'single'        => 'yes'
            );

            $entries = $this->row_m->get_rows($parameters, $this->fields, $stream);

            if (!isset($entries['rows'][0])) {
                return $this->getAttribute('no_entry', lang('streams:no_entry'));
            }

            $vars['entry'][0] = $entries['rows'][0];

            // -------------------------------------
            // Parse other vars
            // -------------------------------------

            $vars['form_open']      = form_open($this->uri->uri_string(), null, $hidden);
            $vars['form_close']     = '</form>';
            $vars['delete_confirm'] = '<input type="submit" name="delete_confirm" value="' . lang(
                    'streams:delete'
                ) . '" />';

            $entries = null;

            return array($vars);
        }
    }

    ///////////////////////////////////////////////////////////////////////////////
    // --------------------------	 UTILITIES 	  ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Calendar
     *
     * @access    public
     * @return    string
     */
    public function calendar()
    {
        // -------------------------------------
        // Cache
        // -------------------------------------

        $this->setupCache();

        if (!is_null($tag_cache = $this->getTagCache())) {
            return $tag_cache;
        }

        // -------------------------------------
        // Get vars
        // -------------------------------------

        $passed_streams     = $this->getAttribute('stream');
        $date_fields_passed = $this->getAttribute('date_field', 'created');
        $year               = $this->getAttribute('year', date('Y'));
        $year_segment       = $this->getAttribute('year_segment');
        $month              = $this->getAttribute('month', date('n'));
        $month_segment      = $this->getAttribute('month_segment');
        $passed_display     = $this->getAttribute('display', '<strong>[id]</strong>');
        $passed_link        = $this->getAttribute('link', '');
        $title_col          = $this->getAttribute('title_col', 'id');
        $template           = $this->getAttribute('template', false);

        // -------------------------------------
        // Figure out year & month
        // -------------------------------------

        if (is_numeric($year_segment) AND is_numeric($this->uri->segment($year_segment))) {
            $year = $this->uri->segment($year_segment);
        }

        if (is_numeric($month_segment) and is_numeric($this->uri->segment($month_segment))) {
            $month = $this->uri->segment($month_segment);
        }

        // Default to current
        if (!is_numeric($year)) {
            $year = date('Y');
        }
        if (!is_numeric($month)) {
            $month = date('n');
        }

        // -------------------------------------
        // Run through streams & create
        // calendar data
        // -------------------------------------

        $calendar = array();

        $displays    = explode("|", $passed_display);
        $links       = explode("|", $passed_link);
        $streams     = explode("|", $passed_streams);
        $date_fields = explode("|", $date_fields_passed);

        $count = 0;

        foreach ($streams as $stream) {
            $date_field = $date_fields[$count];

            $stream = $this->streams_m->get_stream($stream, true, $this->core_namespace);

            $this->fields = $this->streams_m->get_stream_fields($stream->id);

            $parameters = array(
                'date_by' => $date_field,
                'get_day' => true,
                'year'    => $year,
                'month'   => $month
            );

            // -------------------------------------
            // Get rows
            // -------------------------------------

            if ($this->cache_type == 'query' and !is_null($this->cache_ttl)) {
                $entries = $this->pyrocache->model(
                    'row_m',
                    'get_rows',
                    array($parameters, $this->fields, $stream),
                    $this->cache_ttl
                );
            } else {
                $entries = $this->row_m->get_rows($parameters, $this->fields, $stream);
            }

            $this->clearCacheVariables();

            // -------------------------------------
            // Format Calendar Data
            // -------------------------------------

            foreach ($entries as $above) {
                foreach ($above as $entry) {
                    if (isset($displays[$count])) {
                        // Replace fields
                        $display_content = $displays[$count];
                        $link_content    = $links[$count];

                        $parser = new Lex\Parser;
                        $parser->scopeGlue(':');

                        $display_content = str_replace(array('[', ']'), array('{{ ', ' }}'), $display_content);
                        $link_content    = str_replace(array('[', ']'), array('{{ ', ' }}'), $link_content);

                        $display_content = $parser->parse(
                            $display_content,
                            $entry,
                            array($this->parser, 'parser_callback')
                        );
                        $link_content    = $parser->parse(
                            $link_content,
                            $entry,
                            array($this->parser, 'parser_callback')
                        );

                        // Link
                        if ($link_content != '') {
                            $display_content = '<a href="' . site_url(
                                    $link_content
                                ) . '" class="' . $stream . '_link">' . $display_content . '</a>';
                        }

                        // Adding to the array
                        if (isset($calendar[$entry['pyrostreams_cal_day']])) {
                            $calendar[$entry['pyrostreams_cal_day']] .= $display_content . '<br />';
                        } else {
                            $calendar[$entry['pyrostreams_cal_day']] = $display_content . '<br />';
                        }
                    }
                }
            }

            $count++;
        }

        // -------------------------------------
        // Get Template
        // -------------------------------------

        if ($template) {
            $this->db->limit(1)->select('body')->where('title', $template);
            $db_obj = $this->db->get('page_layouts');

            if ($db_obj->num_rows() > 0) {
                $layout                  = $db_obj->row();
                $this->calendar_template = $layout->body;
            }
        }

        // -------------------------------------
        // Generate Calendar
        // -------------------------------------

        $calendar_prefs['template']       = $this->calendar_template;
        $calendar_prefs['start_day']      = strtolower($this->getAttribute('start_day', 'sunday'));
        $calendar_prefs['month_type']     = $this->getAttribute('month_type', 'long');
        $calendar_prefs['day_type']       = $this->getAttribute('day_type', 'abr');
        $calendar_prefs['show_next_prev'] = $this->getAttribute('show_next_prev', 'yes');
        $calendar_prefs['next_prev_url']  = $this->getAttribute('next_prev_uri', '');

        if ($calendar_prefs['show_next_prev'] == 'yes') {
            $calendar_prefs['show_next_prev'] = true;
        } else {
            $calendar_prefs['show_next_prev'] = false;
        }

        $this->load->library('calendar', $calendar_prefs);

        $return_content = $this->calendar->generate($year, $month, $calendar);

        // -------------------------------------
        // Cache End Procedures
        // -------------------------------------

        $this->writeTagCache($return_content);

        $this->clearCacheVariables();

        // -------------------------------------

        return $return_content;
    }

    /**
     * Reset the cache vars to their defaults
     *
     * @access    private
     * @return    void
     */
    private function clearCacheVariables()
    {
        $this->cache_type        = 'query';
        $this->cache_time_format = 'minutes';
        $this->cache_ttl         = null;
        $this->cache_hash        = null;
        $this->write_tag_cache   = false;
    }

    /**
     * Seach Form
     *
     * @access    public
     * @return    string
     */
    public function search_form()
    {
        $this->load->helper('form');

        $stream    = $this->getAttribute('stream');
        $namespace = $this->getAttribute('namespace', $this->core_namespace);
        $fields    = $this->getAttribute('fields');

        $search_types = array('keywords', 'full_phrase');

        $search_type  = strtolower($this->getAttribute('search_type', 'full_phrase'));
        $results_page = $this->getAttribute('results_page');
        $variables    = array();

        // -------------------------------------
        // Check our search type
        // -------------------------------------

        if (!in_array($search_type, $search_types)) {
            show_error($search_type . ' ' . lang('streams:invalid_search_type'));
        }

        // -------------------------------------
        // Check for our search term
        // -------------------------------------

        if (isset($_POST['search_term'])) {
            $this->load->model('streams/search_m');

            // Write cache
            $cache_id = $this->search_m->perform_search(
                $this->input->post('search_term'),
                $search_type,
                $stream,
                $fields,
                $this->core_namespace
            );

            // Redirect
            $this->load->helper('url');
            redirect($results_page . '/' . $cache_id);
        }

        // -------------------------------------
        // Build Form
        // -------------------------------------

        $vars['form_open'] = form_open($this->uri->uri_string());

        $search_input = array(
            'name' => 'search_term',
            'id'   => 'search_term'
        );

        $vars['search_input'] = form_input($search_input);
        $vars['form_submit']  = form_submit('search_submit', lang('streams:search'));
        $vars['form_close']   = '</form>';

        return array($vars);
    }

    /**
     * Search Results
     *
     * @access    public
     * @return    string
     */
    public function search_results()
    {
        $paginate      = $this->getAttribute('paginate', 'yes');
        $cache_segment = $this->getAttribute('cache_segment', 3);
        $per_page      = $this->getAttribute('per_page', 25);
        $variables     = array();

        // Pagination segment is always right after the cache hash segment
        $pag_segment = $cache_segment + 1;

        // -------------------------------------
        // Check for Cached Search Query
        // -------------------------------------

        $this->load->model('streams/search_m');

        if (!$cache = $this->search_m->get_cache($this->uri->segment($cache_segment))) {
            // Invalid search
            show_error(lang('streams:search_not_found'));
        }

        $stream = $this->streams_m->get_stream($cache->stream, true, $cache->stream_namespace);

        $this->fields = $this->streams_m->get_stream_fields($stream->id);

        // Easy out for no results
        if ($cache->total_results == 0) {
            return array(
                'no_results'    => $this->getAttribute('no_results', lang('streams:no_results')),
                'results_exist' => false,
                'results'       => array(),
                'pagination'    => null,
                'search_term'   => $this->getAttribute('search_term', $cache->search_term),
                'total_results' => (string)'0'
            );
        }

        // -------------------------------------
        // Pagination
        // -------------------------------------

        $return = array();

        $return['total'] = $cache->total_results;

        if ($paginate == 'yes') {
            // Add in our pagination config
            // override varaibles.
            foreach ($this->pagination_config as $key => $var) {
                $this->pagination_config[$key] = $this->attribute($key, $this->pagination_config[$key]);

                // Make sure we obey the false parameters
                if ($this->pagination_config[$key] == 'false') {
                    $this->pagination_config[$key] = false;
                }
            }

            $return['pagination'] = $this->row_m->build_pagination(
                $pag_segment,
                $per_page,
                $return['total'],
                $this->pagination_config
            );

            $offset = $this->uri->segment($pag_segment, 0);

            $query_string = $cache->query_string . " LIMIT $offset, $per_page";
        } else {
            $return['pagination'] = null;
            $query_string         = $cache->query_string;
        }

        // -------------------------------------
        // Get & Format Results
        // -------------------------------------

        $return['results'] = $this->row_m->format_rows(
            $this->db->query($query_string)->result_array(),
            $stream
        );

        // -------------------------------------
        // Extra Data
        // -------------------------------------

        $return['no_results']    = '';
        $return['total_results'] = $cache->total_results;
        $return['results_exist'] = true;
        $return['search_term']   = $cache->search_term;

        return $this->streams_content_parse($this->content(), $return, $cache->stream);
    }

    ///////////////////////////////////////////////////////////////////////////////
    // --------------------------	 LEGACY 	  ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Format date variables
     * Legacy. This is now done by the date helper
     * or in the datetime field type.
     *
     * @access    public
     * @return    string - formatted date
     */
    public function date()
    {
        $date_formats = array(
            'DATE_ATOM',
            'DATE_COOKIE',
            'DATE_ISO8601',
            'DATE_RFC822',
            'DATE_RFC850',
            'DATE_RFC1036',
            'DATE_RFC1123',
            'DATE_RFC2822',
            'DATE_RSS',
            'DATE_W3C'
        );

        $date   = $this->attribute('date');
        $format = $this->attribute('format');

        // No sense in trying to get down
        // with somedata that isn't there
        if (!$date or !$format) {
            return null;
        }

        $this->load->helper('date');

        // Make sure we have a UNIX date
        if (!is_numeric($date)) {
            $date = mysql_to_unix($date);
        }

        // Is this a preset?
        if (in_array($format, $date_formats)) {
            return standard_date($format, $date);
        }

        // Default is PHP date
        return date($format, $date);
    }

}
