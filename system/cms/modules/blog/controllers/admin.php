<?php

use Pyro\Module\Blog\BlogEntryModel;
use Pyro\Module\Blog\BlogEntryUi;
use Pyro\Module\Comments\Model\Comment;

/**
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog\Controllers
 */
class Admin extends Admin_Controller
{
    /** @var string The current active section */
    protected $section = 'posts';

    protected $posts;
    protected $blogUi;

    /** @var array The validation rules */
    protected $validation_rules = array(
        'title' => array(
            'field' => 'title',
            'label' => 'lang:global:title',
            'rules' => 'trim|htmlspecialchars|required|max_length[200]'
        ),
        'slug'  => array(
            'field' => 'slug',
            'label' => 'lang:global:slug',
            'rules' => 'trim|required|alpha_dot_dash|max_length[200]'
        ),
        array(
            'field' => 'category_id',
            'label' => 'lang:blog:category_label',
            'rules' => 'trim|numeric'
        ),
        array(
            'field' => 'keywords',
            'label' => 'lang:global:keywords',
            'rules' => 'trim'
        ),
        array(
            'field' => 'body',
            'label' => 'lang:blog:content_label',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status',
            'label' => 'lang:blog:status_label',
            'rules' => 'trim|alpha'
        ),
        array(
            'field' => 'created_at',
            'label' => 'lang:blog:date_label',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'created_at_hour',
            'label' => 'lang:blog:created_hour',
            'rules' => 'trim|numeric|required'
        ),
        array(
            'field' => 'created_at_minute',
            'label' => 'lang:blog:created_minute',
            'rules' => 'trim|numeric|required'
        ),
        array(
            'field' => 'comments_enabled',
            'label' => 'lang:blog:comments_enabled_label',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'preview_hash',
            'label' => '',
            'rules' => 'trim'
        )
    );

    /**
     * Create a new Admin instance
     */
    public function __construct()
    {
        parent::__construct();

        $this->posts = new BlogEntryModel;
        $this->blogUi = new BlogEntryUi;

        $this->template->append_js('module::blog_form.js');
    }

    /**
     * Show all created blog posts
     */
    public function index()
    {
        // Build the table with Streams_core
        $this->blogUi->table($this->posts)->render();
    }

    /**
     * Create new post
     *
     * @return string
     */
    public function create()
    {
        // They are trying to put this live
        if ($this->input->post('status') == 'live') {
            role_or_die('blog', 'put_live');
            $hash = "";
        } else {
            $hash = $this->preview_hash();
        }

        // Build the form with Streams_core
        $this->blogUi->form($this->posts)->render();
    }

    /**
     * Generate a preview hash
     *
     * @return string
     */
    private function preview_hash()
    {
        return md5(microtime() + mt_rand(0, 1000));
    }

    /**
     * Edit blog post
     *
     * @param int $id The ID of the blog post to edit
     *
     * @return string
     */
    public function edit($id)
    {
        /*$hash = $this->input->post('preview_hash');

        if ($this->input->post('status') == 'draft' and $this->input->post('preview_hash') == '') {
            $hash = $this->preview_hash();
        }
        //it is going to be published we don't need the hash
        elseif ($this->input->post('status') == 'live') {
            $hash = '';
        }*/

        // Build the form with Streams_core
        $this->blogUi->form($this->posts, $id)->render();
    }

    /**
     * Preview blog post
     *
     * @param int $id The ID of the blog post to preview
     */
    public function preview($id = 0)
    {
        $post = $this->posts->find($id);

        $this->template
            ->set_layout('modal', 'admin')
            ->set('post', $post)
            ->build('admin/preview');
    }

    /**
     * Publish blog post
     *
     * @param int $id the ID of the blog post to make public
     */
    public function publish($id = 0)
    {
        role_or_die('blog', 'put_live');

        // Publish one
        $ids = ($id) ? array($id) : $this->input->post('action_to');

        if (!empty($ids)) {
            // Go through the array of slugs to publish
            $post_titles = array();
            foreach ($ids as $id) {
                // Get the current page so we can grab the id too
                if ($post = $this->blog_m->get($id)) {
                    $this->blog_m->publish($id);

                    // Wipe cache for this model, the content has changed
                    $this->cache->forget('blog_m');
                    $post_titles[] = $post->title;
                }
            }
        }

        // Some posts have been published
        if (!empty($post_titles)) {
            // Only publishing one post
            if (count($post_titles) == 1) {
                $this->session->set_flashdata(
                    'success',
                    sprintf($this->lang->line('blog:publish_success'), $post_titles[0])
                );
            } // Publishing multiple posts
            else {
                $this->session->set_flashdata(
                    'success',
                    sprintf($this->lang->line('blog:mass_publish_success'), implode('", "', $post_titles))
                );
            }
        } // For some reason, none of them were published
        else {
            $this->session->set_flashdata('notice', $this->lang->line('blog:publish_error'));
        }

        redirect('admin/blog');
    }

    /**
     * Delete blog post
     *
     * @param int $id The ID of the blog post to delete
     */
    public function delete($id = 0)
    {
        role_or_die('blog', 'delete_live');

        // Delete one
        $ids = ($id) ? array($id) : $this->input->post('action_to');

        // Go through the array of slugs to delete
        if (!empty($ids)) {
            $post_titles = array();
            $deleted_ids = array();
            foreach ($ids as $id) {
                // Get the current page so we can grab the id too
                if ($post = $this->posts->find($id)) {
                    if ($post->delete($id)) {
                        // Delete any blog comments for this entry
                        $comments = Comment::findManyByModuleAndEntryId('blog', $id);
                        $comments->delete();

                        // Wipe cache for this model, the content has changed
                        $this->cache->forget('blog_m');
                        $post_titles[] = $post->title;
                        $deleted_ids[] = $id;
                    }
                }
            }

            // Fire an event. We've deleted one or more blog posts.
            Events::trigger('post_deleted', $deleted_ids);
        }

        // Some pages have been deleted
        if (!empty($post_titles)) {
            // Only deleting one page
            if (count($post_titles) == 1) {
                $this->session->set_flashdata(
                    'success',
                    sprintf($this->lang->line('blog:delete_success'), $post_titles[0])
                );
            } else {
                // Deleting multiple pages
                $this->session->set_flashdata(
                    'success',
                    sprintf($this->lang->line('blog:mass_delete_success'), implode('", "', $post_titles))
                );
            }
        } else {
            // For some reason, none of them were deleted
            $this->session->set_flashdata('notice', lang('blog:delete_error'));
        }

        redirect('admin/blog');
    }
}
