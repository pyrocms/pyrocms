<?php

use Pyro\Module\Comments\Model\Comment;
use Pyro\Module\Pages\Model\Page;
use Pyro\Module\Pages\Model\PageType;
use Pyro\Module\Pages\Ui\PageEntryUi;
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * Pages controller
 *
 * @author      Ryan Thompson - PyroCMS Development Team
 */
class Admin extends Admin_Controller
{
    /**
     * Section
     *
     * @var string
     */
    protected $section = 'pages';

    /**
     * Create a new Admin instance
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('pages');
        $this->lang->load('page_types');
        $this->load->library('keywords/keywords');

        $this->ui        = new PageEntryUi();
        $this->pages     = new Page();
        $this->pageTypes = new PageType();
    }

    /**
     * Display all pages as a tree
     */
    public function index()
    {
        $pages = $this->pages->tree();

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
        $types = $this->pageTypes->all();

        // Do we have a parent ID?
        $parent = ($this->input->get('parent')) ? '&parent=' . $this->input->get('parent') : null;

        // Who needs a menu when there is only one option?
        if (count($types) == 1) {
            redirect('admin/pages/create?pageType=' . $types[0]->id . $parent);
        }

        // Directly output the menu if it's for the modal.
        // All we need is the <ul>.
        if ($this->input->is_ajax_request()) {
            $html = '<h4>' . lang('pages:choose_type_title') . '</h4>';
            $html .= '<ul class="modal_select">';

            foreach ($types as $pt) {
                $html .= '<li><a href="' . site_url(
                        'admin/pages/create?page_type=' . $pt->id . $parent
                    ) . '"><strong>' . $pt->title . '</strong>';

                if (trim($pt->description)) {
                    $html .= ' | ' . $pt->description;
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
            ->set('types', $types)
            ->build('admin/choose_type');
    }

    /**
     * Update page order
     */
    public function order()
    {
        $order      = $this->input->post('order');
        $data       = $this->input->post('data');
        $root_pages = isset($data['root_pages']) ? $data['root_pages'] : array();

        if (is_array($order)) {

            //reset all parent > child relations
            Page::resetParentByIds($root_pages);

            foreach ($order as $i => $page) {
                $id = str_replace('page_', '', $page['id']);

                if (is_integer($i)) {
                    //set the order of the root pages
                    $model                  = Page::find($id);
                    $model->skip_validation = true;
                    $model->order           = $i;

                    $model->save();

                    if ($model->entry) {
                        $model->entry->updateOrderingCount($i);
                    }
                }

                //iterate through children and set their order and parent
                Page::setChildren($page);
            }

            // rebuild page URIs
            Page::updateLookup($root_pages);

            //@TODO Fix Me Bro https://github.com/pyrocms/pyrocms/pull/2514
            $this->cache->forget('navigation_m');
            $this->cache->forget('page_m');

            Events::trigger('page_ordered', array('order' => $order, 'root_pages' => $root_pages));
        }
    }

    /**
     * Ajax page details
     *
     * @param $id
     */
    public function ajax_page_details($id)
    {
        $page = $this->pages->find($id);

        $this->load->view('admin/ajax/page_details', compact('page'));
    }

    /**
     * Show a page preview
     *
     * @param int $id The id of the page.
     */
    public function preview($id = 0)
    {
        $page = $this->pages->find($id);

        $this->template->set_layout('modal', 'admin')->build('admin/preview', compact('page'));
    }

    /**
     * Duplicate a page
     *
     * @param int  $id       The ID of the page
     * @param null $parentId The ID of the parent page, if this is a recursive nested duplication
     */
    public function duplicate($id, $parent = null)
    {
        $page = Page::with('children')->find($id);

        $duplicate_page = $page->replicate();

        do {
            // Turn "Foo" into "Foo 2"
            $duplicate_page->title = increment_string($duplicate_page->title, ' ', 2);

            if ($parent) {
                $duplicate_page->uri = $parent->uri . '/' . $duplicate_page->slug;
            } else {
                $duplicate_page->uri = increment_string($duplicate_page->uri, '-', 2);
            }

            // Turn "foo" into "foo-2"
            $duplicate_page->slug = increment_string($duplicate_page->slug, '-', 2);

            // Find if this already exists in this level
            $has_dupes = Page::isUniqueSlug($duplicate_page->slug, $duplicate_page->parent_id);

        } while ($has_dupes === true);

        if ($parent) {
            $duplicate_page->parent()->associate($parent);
        }

        //$duplicate_page->restricted_to = null;
        //$duplicate_page->navigation_group_id = 0;

        if ($page->entry) {
            $duplicate_entry = $page->entry->replicate();
            $duplicate_entry->save();
            $duplicate_page->entry()->associate($duplicate_entry)->save();
        }

        foreach ($duplicate_page->children as $child) {
            $this->duplicate($child->id, $duplicate_page);
        }

        $this->pages->flushCacheCollection();

        // only allow a redirect when everything is finished (only the top level page has a null parent_id)
        if (is_null($parent)) {
            redirect('admin/pages');
        }
    }

    /**
     * Create
     */
    public function create()
    {
        if (!$pageType = $this->pageTypes->find($this->input->get('page_type'))) {
            redirect('admin/pages/choose_type');
        }

        if ($parentId = $this->input->get('parent')) {
            $parentPage = Page::find($parentId);
        } else {
            $parentPage = null;
        }

        $entryModelClass = StreamModel::getEntryModelClass(
            $pageType->stream->stream_slug,
            $pageType->stream->stream_namespace
        );

        $pages = $this->pages;

        $this->ui
            ->title(lang('pages:create_title'))
            ->form($entryModelClass)
            ->onSaved(
                function ($entry) use ($pages) {
                    $pages->createFromEntry($entry, ci()->input->get('page_type'), ci()->input->get('parent'));
                }
            )
            ->render();
    }

    /**
     * Edit
     *
     * @param $id
     */
    public function edit($id)
    {
        role_or_die('pages', 'edit_live');

        $page = $this->pages->with('type')->find($id);

        $pages = $this->pages;

        $this->ui
            ->title(sprintf(lang('pages:edit_title'), $page->entry->title))
            ->form($page->entry_type, $page->entry_id)
            ->onSaved(
                function ($entry) use ($pages) {
                    $pages->updateFromEntry($entry);
                }
            )
            ->render();
    }

    /**
     * Delete
     *
     * @param $id
     */
    public function delete($id)
    {
        role_or_die('pages', 'delete_live');

        $ids = ($id) ? array($id) : $this->input->post('action_to');

        // Go through the array of slugs to delete
        if (!empty($ids)) {

            foreach ($ids as $id) {

                if ($id !== 1) {
                    if (!$page = Page::find($id)) {
                        continue;
                    }

                    $page->delete();

                    $deleted_ids = $id;

                    // Delete any page comments for this entry
                    Comment::where('module', '=', 'pages')
                        ->where('entry_id', '=', $id)
                        ->delete();

                    // Wipe cache for this model, the content has changd
                    $this->cache->forget('page_m');
                    //@TODO Fix Me Bro https://github.com/pyrocms/pyrocms/pull/2514
                    $this->cache->forget('navigation_m');

                } else {
                    $this->session->set_flashdata('error', lang('pages:delete_home_error'));
                }
            }

            // Some pages have been deleted
            if (!empty($deleted_ids)) {
                Events::trigger('page_deleted', $deleted_ids);

                // Only deleting one page
                if (count($deleted_ids) === 1) {
                    $this->session->set_flashdata('success', sprintf(lang('pages:delete_success'), $deleted_ids[0]));

                    // Deleting multiple pages
                } else {
                    $this->session->set_flashdata(
                        'success',
                        sprintf(lang('pages:mass_delete_success'), count($deleted_ids))
                    );
                }

                // For some reason, none of them were deleted
            } else {
                $this->session->set_flashdata('notice', lang('pages:delete_none_notice'));
            }
        }

        redirect('admin/pages');
    }
}
