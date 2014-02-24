<?php

use Pyro\Module\Comments\Model\Comment;
use Pyro\Module\Comments\Model\CommentBlacklist;

/**
 * Comments controller (frontend)
 *
 * @package		PyroCMS\Core\Modules\Comments\Controllers
 * @author		PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
class Comments extends Public_Controller
{
    /**
     * An array containing the validation rules
     *
     * @var array
     */
    private $validation_rules = array(
        array(
            'field' => 'name',
            'label' => 'lang:comments:name_label',
            'rules' => 'trim'
        ),
        array(
            'field' => 'email',
            'label' => 'lang:global:email',
            'rules' => 'trim|valid_email'
        ),
        array(
            'field' => 'website',
            'label' => 'lang:comments:website_label',
            'rules' => 'trim|max_length[255]'
        ),
        array(
            'field' => 'comment',
            'label' => 'lang:comments:message_label',
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

        // Load the required classes
        $this->load->library('form_validation');
        $this->lang->load('comments');
    }

    /**
     * Create a new comment
     *
     * @param type $module The module that has a comment-able model.
     * @param int $id The id for the respective comment-able model of a module.
     */
    public function create($module = null)
    {
        if ( ! $module or ! $this->input->post('entry')) {
            show_404();
        }

        // Get information back from the entry hash
        // @HACK This should be part of the controllers lib, but controllers & libs cannot share a name
        $entry = unserialize($this->encrypt->decode($this->input->post('entry')));

        $comment = array(
            'module' 		=> $module,
            'entry_id' 		=> $entry['id'],
            'entry_title' 	=> $entry['title'],
            'entry_key' 	=> $entry['singular'],
            'entry_plural' 	=> $entry['plural'],
            'uri' 			=> $entry['uri'],
            'comment' 		=> $this->input->post('comment'),
            'is_active' 	=> (bool) (($this->current_user and $this->current_user->isSuperUser()) or ! Settings::get('moderate_comments')),
            'ip_address'    => $this->input->ip_address(),
        );

        // Logged in? in which case, we already know their name and email
        if ($this->current_user) {
            $comment['user_id'] = $this->current_user->id;
            $comment['user_name'] = $this->current_user->display_name;
            $comment['user_email'] = $this->current_user->email;

            if ($this->current_user->website) {
                $comment['user_website'] = $this->current_user->website;
            }

        } else {
            $this->validation_rules[0]['rules'] .= '|required';
            $this->validation_rules[1]['rules'] .= '|required';

            $comment['user_name'] = $this->input->post('name');
            $comment['user_email'] = $this->input->post('email');
            $comment['user_website'] = $this->input->post('website');
        }

        // Set the validation rules
        $this->form_validation->set_rules($this->validation_rules);

        // Validate the results
        if ($this->form_validation->run()) {
            // ALLOW ZEH COMMENTS!? >:D
            $result = $this->allowComment();

            foreach ($comment as $field => $value) {
                $comment[$field] = escape_tags($value);
            }

            // Run Akismet or the crazy CSS bot checker
            if ($result['status'] !== true) {
                $this->session->set_flashdata('comment', $comment);
                $this->session->set_flashdata('error', $result['message']);

                $this->repopulateComment();
            } else {
                // Save the comment
                if ($comment = Comment::create($comment)) {
                    // Approve the comment straight away
                    if ( ! Settings::get('moderate_comments') or ($this->current_user and $this->current_user->isSuperUser())) {
                        $this->session->set_flashdata('success', lang('comments:add_success'));

                        // Add an event so third-party devs can hook on
                        Events::trigger('comment_approved', $comment);
                    } else {
                        // Do we need to approve the comment?
                        $this->session->set_flashdata('success', lang('comments:add_approve'));

                        // Trigger an event
                        Events::trigger('comment_added', $comment);
                    }

                    // If markdown is allowed we will parse the body for the email
                    if (Settings::get('comment_markdown')) {
                        $comment->comment = parse_markdown($comment->comment);
                    }

                    // Send the notification email
                    $this->sendEmail($comment, $entry);

                } else {
                    // Failed to add the comment
                    $this->session->set_flashdata('error', lang('comments:add_error'));

                    $this->repopulateComment();
                }
            }

        } else {
            // The validation has failed
            $this->session->set_flashdata('error', validation_errors());

            $this->repopulateComment();
        }

        // If for some reason the post variable doesnt exist, just send to module main page
        $uri = ! empty($entry['uri']) ? $entry['uri'] : $module;

        // If this is default to pages then just send it home instead
        $uri === 'pages' and $uri = '/';

        redirect($uri);
    }

    /**
     * Repopulate Comment
     *
     * There are a few places where we need to repopulate
     * the comments.
     */
    private function repopulateComment()
    {
        // Loop through each rule
        foreach ($this->validation_rules as $rule) {
            if ($this->input->post($rule['field']) !== false) {
                $comment[$rule['field']] = escape_tags($this->input->post($rule['field']));
            }
        }
        $this->session->set_flashdata('comment', $comment);
    }

    /**
     * Method to check whether we want to allow the comment or not
     *
     * @return array
     */
    private function allowComment()
    {
        // Dumb-check
        $this->load->library('user_agent');

        // Sneaky bot-check
        if ($this->agent->is_robot() or $this->input->post('d0ntf1llth1s1n')) {
            return array('status' => false, 'message' => 'You are probably a robot.');
        }

        // Check Akismet if an API key exists
        if (Settings::get('akismet_api_key')) {
            $this->load->library('akismet');

            $comment = array(
                'author' => $this->current_user ? $this->current_user->display_name : $this->input->post('name'),
                'email' => $this->current_user ? $this->current_user->email : $this->input->post('email'),
                'website' => (isset($this->current_user->website)) ? $this->current_user->website : $this->input->post('website'),
                'body' => $this->input->post('body')
            );

            $config = array(
                'blog_url' => BASE_URL,
                'api_key' => Settings::get('akismet_api_key'),
                'comment' => $comment
            );

            $this->akismet->init($config);

            if ($this->akismet->is_spam()) {
                // @TODO Add me to language files
                return array('status' => false, 'message' => 'Looks like this is spam. If you believe this is incorrect please contact the site administrator.');
            }

            if ($this->akismet->errors_exist()) {
                return array('status' => false, 'message' => implode('<br />', $this->akismet->get_errors()));
            }
        }

        if (CommentBlacklist::findManyByEmailOrWebsite($this->input->post('email'), $this->input->post('website'))->count() > 0) {
            // @TODO Add me to language files
            return array('status' => false, 'message' => 'The website or email address posting this comment has been blacklisted.');
        }

        // F**k knows, its probably fine...
        return array('status' => true);
    }

    /**
     * Send an email
     *
     * @param array $comment The comment data.
     * @param array $entry The entry data.
     * @return boolean
     */
    private function sendEmail($comment, $entry)
    {
        $this->load->library('email');
        $this->load->library('user_agent');

        // Add in some extra details
        $comment['slug'] = 'comments';
        $comment['sender_agent'] = $this->agent->browser().' '.$this->agent->version();
        $comment['sender_ip'] = $this->input->ip_address();
        $comment['sender_os'] = $this->agent->platform();
        $comment['redirect_url'] = anchor(ltrim($entry['uri'], '/').'#'.$comment['comment_id']);
        $comment['reply-to'] = $comment['user_email'];

        //trigger the event
        return (bool) Events::trigger('email', $comment);
    }

}
