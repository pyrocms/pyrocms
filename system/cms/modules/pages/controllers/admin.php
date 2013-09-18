<?php

use Pyro\Module\Comments\Model\Comment;
use Pyro\Module\Navigation;
use Pyro\Module\Pages\Model\Page;
use Pyro\Module\Pages\Model\PageType;
use Pyro\Module\Users;
use Pyro\Module\Streams_core as Streams;

/**
 * Pages controller
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Pages\Controllers
 */
class Admin extends Admin_Controller
{
    /**
     * The current active section
     *
     * @var string
     */
    protected $section = 'pages';

    protected $form_data = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        // Load the required classes
        $this->lang->load('pages');
        $this->lang->load('page_types');

        $this->load->driver('Streams');
    }

    /**
     * Index methods, lists all pages
     */
    public function index()
    {
        $pages = Page::tree();

        $this->template

            ->title($this->module_details['name'])

            ->append_js('jquery/jquery.ui.nestedSortable.js')
            ->append_js('jquery/jquery.cooki.js')
            ->append_js('jquery/jquery.stickyscroll.js')
            ->append_js('module::index.js')

            ->append_css('module::index.css')

            ->set('pages', $pages)
            ->build('admin/index');
    }

    /**
     * Choose a page type
     */
    public function choose_type()
    {
        $types = PageType::all();

        // Do we have a parent ID?
        $parent = ($this->input->get('parent')) ? '&parent='.$this->input->get('parent') : null;

        // Who needs a menu when there is only one option?
        if (count($types) == 1) {
            redirect('admin/pages/create?page_type='.$types[0]->id.$parent);
        }

        // Directly output the menu if it's for the modal.
        // All we need is the <ul>.
        if ($this->input->is_ajax_request()) {
            $html  = '<h4>'.lang('pages:choose_type_title').'</h4>';
            $html .= '<ul class="modal_select">';

            foreach ($types as $pt) {
                $html .= '<li><a href="'.site_url('admin/pages/create?page_type='.$pt->id.$parent).'"><strong>'.$pt->title.'</strong>';

                if (trim($pt->description)) {
                    $html .= ' | '.$pt->description;
                }

                $html .= '</a></li>';
            }

            echo $html .= '</ul>';

            return;
        }

        // If this is not being displayed in the modal, we can
        // display an entire page.
        $this->template
            ->set('parent', $parent)
            ->set('page_types', $types)
            ->build('admin/choose_type');
    }

    /**
     * Order the pages and record their children
     *
     * Grabs `order` and `data` from the POST data.
     */
    public function order()
    {
        $order  = $this->input->post('order');
        $data   = $this->input->post('data');
        $root_pages = isset($data['root_pages']) ? $data['root_pages'] : array();

        if (is_array($order)) {

            //reset all parent > child relations
            Page::resetParentByIds($root_pages);

            foreach ($order as $i => $page)
            {
                $id = str_replace('page_', '', $page['id']);

                if (is_integer($i))
                {
                    //set the order of the root pages
                    $model = Page::find($id);
                    $model->skip_validation = true;
                    $model->order = $i;
                    $model->save();                    
                }

                //iterate through children and set their order and parent
                Page::setChildren($page);
            }

            // rebuild page URIs
            Page::updateLookup($root_pages);

            //@TODO Fix Me Bro https://github.com/pyrocms/pyrocms/pull/2514
            $this->cache->clear('navigation_m');
            $this->cache->clear('page_m');

            Events::trigger('page_ordered', array($order, $root_pages));
        }
    }

    /**
     * Get the details of a page.
     *
     * @param int $id The id of the page.
     */
    public function ajax_page_details($id)
    {
        $page = Page::find($id);

        $page->meta_keywords = Keywords::get_string($page->meta_keywords);

        $this->load->view('admin/ajax/page_details', compact('page'));
    }

    /**
     * Show a page preview
     *
     * @param int $id The id of the page.
     */
    public function preview($id = 0)
    {
        $page = Page::find($id);

        $this->template
            ->set_layout('modal', 'admin')
            ->build('admin/preview', compact('page'));
    }

    /**
     * Duplicate a page
     *
     * @param int $id The ID of the page
     * @param null $parent_id The ID of the parent page, if this is a recursive nested duplication
     */
    public function duplicate($id, $parent_id = null)
    {
        $page  = Page::with('children')->find($id);

        $new_slug = $page->slug;

        // No parent around? Do what you like
        if (is_null($parent_id)) {
            do {
                // Turn "Foo" into "Foo 2"
                $page->title = increment_string($page->title, ' ', 2);

                // Turn "foo" into "foo-2"
                $page->slug = increment_string($page->slug, '-', 2);

                // Find if this already exists in this level
                $has_dupes = Page::where('slug', $page->slug)
                    ->where('parent_id', $page->parent_id)
                    ->count() > 0;
            } while ($has_dupes === true);

        // Oop, a parent turned up, work with that
        } else {
            $page->parent_id = $parent_id;
        }

        $page->restricted_to = null;
        $page->navigation_group_id = 0;

        throw new Exception('FAIL BECAUSE STREAMS ARENT ELOQUENT YET');

        // TODO Streams need to be converted to Eloquent so we can make a "stream" or "entry" relationship
        $new_page = Page::create($page->toArray());

        // TODO Make this bit into page->children()->create($datastuff);
        // $this->streams_m->get_stream($page['stream_id']);

        foreach ($page->children as $child) {
            $this->duplicate($child->id, $new_page);
        }

        // only allow a redirect when everything is finished (only the top level page has a null parent_id)
        if (is_null($parent_id)) {
            redirect('admin/pages');
        }
    }

    /**
     * Create a new page
     *
     * @param int $parent_id The id of the parent page.
     */
    public function create()
    {
        $page = new Page;

        // What type of page are we creating?
        $page_type = PageType::find($this->input->get('page_type'));

        // Redirect to the page type selection menu if no page type was specified
        if ( ! $page_type) {
            redirect('admin/pages/choose_type');
        }
        
        // Get the stream that we are using for this page type.
        $stream = $page_type->stream;

        //$stream_validation = $this->_setup_stream_fields($stream);

        $enable_post = false;

        if ($input = ci()->input->post()) {

            // Do they have permission to proceed?
            if ($input['status'] === 'live') {
                role_or_die('pages', 'put_live');
            }

            // 
            $page->slug             = $input['slug'];
            $page->title            = $input['title'];
            $page->parent_id        = isset($input['parent_id']) ? (int) $input['parent_id'] : 0;
            $page->type_id          = (int) $page_type->id;
            $page->entry_type       = $stream->stream_slug.'.'.$stream->stream_namespace;
            $page->css              = isset($input['css']) ? $input['css'] : null;
            $page->js               = isset($input['js']) ? $input['js'] : null;
            $page->meta_title       = isset($input['meta_title']) ? $input['meta_title'] : null;
            $page->meta_keywords    = isset($input['meta_keywords']) ? $this->keywords->process($input['meta_keywords']) : null;
            $page->meta_description = isset($input['meta_description']) ? $input['meta_description'] : null;
            $page->rss_enabled      = ! empty($input['rss_enabled']);
            $page->comments_enabled = ! empty($input['comments_enabled']);
            $page->status           = $input['status'];
            $page->created_on       = time();
            $page->restricted_to    = isset($input['restricted_to']) ? implode(',', $input['restricted_to']) : 0;
            $page->strict_uri       = ! empty($input['strict_uri']);
            $page->is_home          = ! empty($input['is_home']);
            $page->order            = time();

            // Always set the uri for root pages
            if ( ! ($page->parent_id > 0) and isset($input['slug']))
            {   
                $page->uri = $input['slug'];
            }

            // Insert the page data, along with
            if ($enable_post = $page->save())
            {
                $page->buildLookup();
                
                if ( ! empty($input['is_home']))
                {
                    $page->setHomePage();
                }

                // We define this for the field type
                define('PAGE_ID', $page->id);

                // Add a Navigation Link
                if ( ! empty($input['navigation_group_id']) and is_array($input['navigation_group_id'])) {
                    foreach ($input['navigation_group_id'] as $group_id) {

                        $link = Navigation\Model\Link::create(array(
                            'title'                 => $page->title,
                            'link_type'             => 'page',
                            'page_id'               => $page->id,
                            'navigation_group_id'   => $group_id
                        ));

                        if ($link) {

                            //@TODO Fix Me Bro https://github.com/pyrocms/pyrocms/pull/2514
                            $this->cache->clear('navigation_m');

                            Events::trigger('post_navigation_create', $link);
                        }
                    }
                }

                //$this->cache->clear('page_m');

                Events::trigger('page_created', $page);
            }
        }

        // Run stream field events
        //$this->fields->run_field_events($stream_fields, array(), $values);*/

        // Set some data that both create and edit forms will need
        $this->_form_data();

        $this->form_data['page'] = $page;

        Streams\Cp\Entries::form($stream->stream_slug, $stream->stream_namespace)
            ->enablePost($enable_post) // This will interrupt submittion for the entry if the page was not created
            ->onSaved(function($entry) use ($page)
            {
                $page->entry()->associate($entry); // Save the relation Eloquent style
                $page->save();
            })
            ->tabs($this->_tabs())
            ->successMessage('Page saved.') // @todo - language
            ->redirect('admin/pages')
            ->render();
    }

    /**
     * Edit an existing page
     *
     * @param int $id The id of the page.
     */
    public function edit($id = 0)
    {
        // We are lost without an id. Redirect to the pages index.
        $id or redirect('admin/pages');

        $this->template->set('parent_id', null);

        // The user needs to be able to edit pages.
        role_or_die('pages', 'edit_live');

        // Retrieve the page data along with its data as part of the array.
        $page = Page::with('type')->find($id);

        // Got page?
        if (is_null($page)) {
            // Maybe you would like to create one?
            $this->session->set_flashdata('error', lang('pages:page_not_found_error'));
            redirect('admin/pages/choose_type');
        }

        // This is a temporary global until the page chunk field type is removed
        ci()->page_id = $id;

        // Note: we don't need to get the page type
        // from the URL since it is present in the $page data

        if (! $page->type) {
            show_error('No page type found.');
        }

        $stream = $page->type->stream;
        $page->entry_type       = $stream->stream_slug.'.'.$stream->stream_namespace;
        //$stream_validation = $this->_setup_stream_fields($stream, 'edit', $page->entry_id);

        // If there's a keywords hash
        if ($page->meta_keywords != '') {
            // Get comma-separated meta_keywords based on keywords hash
            $old_keywords_hash = $page->meta_keywords;
            $page->meta_keywords = Keywords::get_string($page->meta_keywords);
        }

        // Turn the CSV list back to an array
        $page->restricted_to = explode(',', $page->restricted_to);

        // Did they even submit?
        if (($input = $this->input->post())) {

            // do they have permission to proceed?
            if ($input['status'] == 'live') {
                role_or_die('pages', 'put_live');
            }

            // Were there keywords before this update?
            if (isset($old_keywords_hash)) {
                $input['old_keywords_hash'] = $old_keywords_hash;
            }

            // Set this one page as the homepage, and not the others
            if ( ! empty($input['is_home'])) {
                $page->setHomePage();
            }

            // Translate the data of restricted_to to something we can use in the form.
            if (isset($input['restricted_to']) and $input['restricted_to'][0] == '') {
                $input['restricted_to'][0] = '0';
            }

            // Assign post data to the page
            $page->slug             = $input['slug'];
            $page->title            = $input['title'];
            //$page->parent_id        = (int) $input['parent_id'];
            $page->css              = isset($input['css']) ? $input['css'] : null;
            $page->js               = isset($input['js']) ? $input['js'] : null;
            $page->meta_title       = isset($input['meta_title']) ? $input['meta_title'] : '';
            $page->meta_keywords    = isset($input['meta_keywords']) ? Keywords::process($input['meta_keywords'], (isset($input['old_keywords_hash'])) ? $input['old_keywords_hash'] : null) : '';
            $page->meta_description = isset($input['meta_description']) ? $input['meta_description'] : '';
            $page->rss_enabled      = ! empty($input['rss_enabled']);
            $page->comments_enabled = ! empty($input['comments_enabled']);
            $page->status           = $input['status'];
            $page->updated_on       = time();
            $page->restricted_to    = isset($input['restricted_to']) ? implode(',', $input['restricted_to']) : '0';
            $page->strict_uri       = ! empty($input['strict_uri']);

            // Always set the uri for root pages
            if ( ! ($page->parent_id > 0) and isset($input['slug']))
            {   
                $page->uri = $input['slug'];
            }

            // validate and insert
            if ($page->save())
            {    
                $page->buildLookup();
                
                Events::trigger('page_updated', $page);

                //$this->cache->clear('page_m');
                //@TODO Fix Me Bro https://github.com/pyrocms/pyrocms/pull/2514
                // $this->cache->clear('navigation_m');
            }
        }
        else
        {
            // Save the entry type if it was not set
            $page->setEntryType()->save();
        }

        // Go through our stream fields and set the current value
        // for the form. Since we are creating a new form, this should
        // simply be the post data if it is available.

        $page_content_data = array();

        // Run stream field events
        //$this->fields->run_field_events($stream_fields, array(), $values);*/

        $this->_form_data();

        $this->form_data['page'] = $page;

        if ($page->entry)
        {
            $page->entry->setStream($stream);
            $page->entry->setFields($stream->assignments->getFields());  
            // We can pass the page model to generate the form
            $cp = Streams\Cp\Entries::form($page->entry);          
        }
        // If for some reason the page does not have an entry, lets give it a chance to get a new one
        else
        {
            $cp = Streams\Cp\Entries::form($stream->stream_slug, $stream->stream_namespace)
                ->onSaved(function($entry) use ($page)
                {
                    $page->entry()->associate($entry); // Save the relation Eloquent style
                    $page->save();
                });
        }

        $cp->tabs($this->_tabs())
            ->successMessage('Page saved.') // @todo - language
            ->redirect('admin/pages')
            ->render();
    }

    /**
     * Setup Stream fields
     *
     * Sets up our validation and some other common
     * elements for our page create/edit functions.
     *
     * @param   obj
     * @param   string - new or edit
     * @param   int - entry id
     * @return  obj - the stream object
     */
    private function _setup_stream_fields($stream, $method = 'new', $id = null)
    {
        $this->load->driver('Streams');

        // Get validation for our page fields.
        $page_validation = $this->streams->streams->validation_array($stream->stream_slug, $stream->stream_namespace, $method, array(), $id);
    }

    /**
     * Sets up common form inputs.
     *
     * This is used in both the creation and editing forms.
     */
    private function _form_data()
    {
        $page_types = PageType::orderBy('title')->get();

        $this->template->page_types = array_for_select($page_types->toArray(), 'id', 'title');

        // Load navigation list
        $this->form_data['navigation_groups'] = $this->template->navigation_groups = Navigation\Model\Group::getGroupOptions();
        $this->form_data['group_options'] = $this->template->group_options = Users\Model\Group::getGroupOptions();

        $this->template
            ->append_js('jquery/jquery.tagsinput.js')
            ->append_js('jquery/jquery.cooki.js')
            ->append_js('module::form.js')
            ->append_css('jquery/jquery.tagsinput.css');
    }

    private function _tabs()
    {
        $form_details       = ci()->load->view('admin/pages/partials/form_details', $this->form_data, true);
        $form_css           = ci()->load->view('admin/pages/partials/form_css', $this->form_data, true);
        $form_javascript    = ci()->load->view('admin/pages/partials/form_javascript', $this->form_data, true);
        $form_options       = ci()->load->view('admin/pages/partials/form_options', $this->form_data, true);

        $tabs = array(
            array(
                'title'     => 'Details',
                'id'        => 'page-details',
                'content'    => $form_details
            ),
            array(
                'title'     => 'Content',
                'id'        => 'page-fields',
                'fields'    => '*'
            ),
            array(
                'title'     => 'Design',
                'id'        => 'page-design',
                'content'    => $form_css
            ),
            array(
                'title'     => 'Script',
                'id'        => 'page-script',
                'content'    => $form_javascript
            ),
            array(
                'title'     => 'Options',
                'id'        => 'page-options',
                'content'    => $form_options
            ),
        );

        return $tabs;  
    }

    /**
     * Delete a page.
     *
     * @param int $id The id of the page to delete.
     */
    public function delete($id = 0)
    {
        // The user needs to be able to delete pages.
        role_or_die('pages', 'delete_live');

        // @todo Error of no selection not handled yet.
        $ids = ($id) ? array($id) : $this->input->post('action_to');

        // Go through the array of slugs to delete
        if ( ! empty($ids)) {

            foreach ($ids as $id) {

                if ($id !== 1) {
                    if ( ! $page = Page::find($id)) {
                        continue;
                    }

                    $page->delete();

                    $deleted_ids = $id;

                    // Delete any page comments for this entry
                    $comments = Comment::where('module','=','pages')->where('entry_id','=',$id)->delete();

                    // Wipe cache for this model, the content has changd
                    $this->cache->clear('page_m');
                    //@TODO Fix Me Bro https://github.com/pyrocms/pyrocms/pull/2514
                    $this->cache->clear('navigation_m');

                } else {
                    $this->session->set_flashdata('error', lang('pages:delete_home_error'));
                }
            }

            // Some pages have been deleted
            if ( ! empty($deleted_ids)) {
                Events::trigger('page_deleted', $deleted_ids);

                // Only deleting one page
                if ( count($deleted_ids) == 1 ) {
                    $this->session->set_flashdata('success', sprintf(lang('pages:delete_success'), $deleted_ids[0]));

                // Deleting multiple pages
                } else {
                    $this->session->set_flashdata('success', sprintf(lang('pages:mass_delete_success'), count($deleted_ids)));
                }

            // For some reason, none of them were deleted
            } else {
                $this->session->set_flashdata('notice', lang('pages:delete_none_notice'));
            }
        }

        redirect('admin/pages');
    }

}