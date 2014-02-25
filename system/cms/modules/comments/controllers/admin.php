<?php

use Pyro\Module\Comments\Model\Comment;

/**
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Comments\Controllers
 */
class Admin extends Admin_Controller
{
    /**
     * Array that contains the validation rules
     *
     * @var array
     */
    private $validation_rules = array(
        array(
            'field' => 'user_name',
            'label' => 'lang:comments:name_label',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_email',
            'label' => 'lang:global:email',
            'rules' => 'trim|valid_email'
        ),
        array(
            'field' => 'user_website',
            'label' => 'lang:comments:website_label',
            'rules' => 'trim'
        ),
        array(
            'field' => 'comment',
            'label' => 'lang:comments:send_label',
            'rules' => 'trim|required'
        ),
    );

    /**
     * Constructor method
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Load the required libraries, models, etc
        $this->load->library('form_validation');
        $this->load->library('comments');

        $this->lang->load('comments');

        // Set the validation rules
        $this->form_validation->set_rules($this->validation_rules);
    }

    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        $filter = array();

        if ( ! is_null($this->input->post('f_active'))) {
            $filter['is_active'] = (bool) $this->input->post('f_active');
        } elseif ( ! is_null($this->session->flashdata('is_active'))) {
            $filter['is_active'] = (bool) $this->session->flashdata('is_active');
        } else {
            $filter['is_active'] = (bool) Settings::get('moderate_comments');
        }

        //capture module slug
        if ($this->input->post('module_slug')) {
            $filter += array('module' => $this->input->post('module_slug'));
        }

        // Create pagination links
        $total_rows = Comment::countWithFilter($filter);
        $pagination = create_pagination('admin/comments/index', $total_rows);

        // Add "limit" and "offset"
        $filter += $pagination;

        $filter['order-by'] = 'created_at';
        $filter['order-dir'] = 'desc';

        $comments = Comment::findWithFilter($filter);

        $content_title = $filter['is_active']
            ? lang('comments:active_title')
            : lang('comments:inactive_title');

        if ($this->input->is_ajax_request()) {
            $this->template->set_layout(false);
        }

        $this->template
            ->title($this->module_details['name'])
            ->append_js('admin/filter.js')
            ->set('module_list', Comment::getModuleSlugs())
            ->set('content_title', $content_title)
            ->set('comments', $this->comments->process($comments))
            ->set('comments_active', $filter['is_active'])
            ->set('pagination', $pagination);

        $this->input->is_ajax_request()
            ? $this->template->build('admin/tables/comments')
            : $this->template->build('admin/index');
    }

    /**
     * Action method, called whenever the user submits the form
     *
     * @return void
     */
    public function action()
    {
        $action = strtolower($this->input->post('btnAction'));

        if ($action) {
            // Get the id('s)
            $id_array = $this->input->post('action_to');

            // Call the action we want to do
            if (method_exists($this, $action)) {
                $this->{$action}($id_array);
            }
        }

        redirect('admin/comments');
    }

    /**
     * Edit an existing comment
     *
     * @return void
     */
    public function edit($id = 0)
    {
        $id or redirect('admin/comments');

        // Get the comment based on the ID
        $comment = Comment::find($id);

        // Validate the results
        if ($this->form_validation->run()) {
            if ($comment->user_id > 0) {
                $comment->user_id = $this->input->post('user_id');
            } else {
                $comment->user_name = $this->input->post('user_name');
                $comment->user_email = $this->input->post('user_email');
            }

            $comment->user_website = $this->input->post('user_website');
            $comment->comment = $this->input->post('comment');

            // Update the comment
            $comment->save()
                ? $this->session->set_flashdata('success', lang('comments:edit_success'))
                : $this->session->set_flashdata('error', lang('comments:edit_error'));

            // Fire an event. A comment has been updated.
            Events::trigger('comment_updated', $comment);

            redirect('admin/comments');
        }

        // Loop through each rule
        foreach ($this->validation_rules as $rule) {
            if ($this->input->post($rule['field']) !== null) {
                $comment->{$rule['field']} = $this->input->post($rule['field']);
            }
        }

        $this->template
            ->title($this->module_details['name'], sprintf(lang('comments:edit_title'), $comment->id))
            ->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
            ->set('comment', $comment)
            ->build('admin/form');
    }

    // Admin: report a comment to local tables/Akismet as spam
    public function report($id)
    {
        $comment = Comment::find($id);

        $api_key = Settings::get('akismet_api_key');

        if ( ! empty($api_key)) {
            $akismet = new Akismet($api_key, BASE_URL);

            $akismet->submitSpam(
                $comment->ip_address,
                $comment->user_agent,
                $comment->comment,
                $comment->user_name,
                $comment->user_email,
                $comment->user_website
            );
        }

        CommentBlacklist::create(array(
            'website' => $comment->user_website,
            'email' => $comment->user_email
        ));

        $this->delete($id);

        redirect('admin/comments');
    }

        // Admin: Delete a comment
    public function delete($ids)
    {
        // Check for one
        $ids = ( ! is_array($ids)) ? array($ids) : $ids;

        // Go through the array of ids to delete
        $comments = array();
        foreach ($ids as $id) {
            // Get the current comment so we can grab the id too
            if ($comment = Comment::find($id)) {
                $comment->delete();

                // Wipe cache for this model, the content has changed
                $this->cache->forget('Comment');
                $comments[] = $comment;
            }
        }

        // Some comments have been deleted
        if ( ! empty($comments)) {
            (count($comments) == 1)
                ? $this->session->set_flashdata('success', sprintf(lang('comments:delete_single_success'), $comments[0]))				/* Only deleting one comment */
                : $this->session->set_flashdata('success', sprintf(lang('comments:delete_multi_success'), implode(', #', $comments )));	/* Deleting multiple comments */

            // Fire an event. One or more comments were deleted.
            Events::trigger('comment_deleted', $comments);
        }

        // For some reason, none of them were deleted
        else {
            $this->session->set_flashdata('error', lang('comments:delete_error'));
        }

        redirect('admin/comments');
    }

    /**
     * Approve a comment
     *
     * @param  mixed $ids		id or array of ids to process
     * @param  bool $redirect	optional if a redirect should be done
     * @return void
     */
    public function approve($id = 0, $redirect = true)
    {
        $id && $this->_do_action($id, 'approve');

        $redirect AND redirect('admin/comments');
    }

    /**
     * Unapprove a comment
     *
     * @param  mixed $ids		id or array of ids to process
     * @param  bool $redirect	optional if a redirect should be done
     * @return void
     */
    public function unapprove($id = 0, $redirect = true)
    {
        $id && $this->_do_action($id, 'unapprove');

        if ($redirect) {
            $this->session->set_flashdata('is_active', 1);

            redirect('admin/comments');
        }
    }

    /**
     * Do the actual work for approve/unapprove
     *
     * @param  int|array $ids	id or array of ids to process
     * @param  string $action	action to take: maps to model
     * @return void
     */
    protected function _do_action($ids, $action)
    {
        $ids		= ( ! is_array($ids)) ? array($ids) : $ids;
        $multiple	= (count($ids) > 1) ? '_multiple' : null;
        $status		= 'success';

        foreach ($ids as $id) {
            if ( ! $comment = Comment::find($id)) {
                $status = 'error';
                break;
            }

            if ($action == 'approve') {
                $comment->is_active = true;
                $comment->save();
                // add an event so third-party devs can hook on
                Events::trigger('comment_approved', $comment);
            } else {
                $comment->is_active = false;
                $comment->save();
                Events::trigger('comment_unapproved', $comment);
            }
        }

        $this->session->set_flashdata(array($status => lang('comments:' . $action . '_' . $status . $multiple)));
    }

    public function preview($id = 0)
    {
        $this->template
            ->set_layout(false)
            ->set('comment', Comment::find($id))
            ->build('admin/preview');
    }

}
