<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Ui\FieldUi;

/**
 * Admin Blog Fields
 *
 * Manage custom blogs fields for
 * your blog.
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Users\Controllers
 */
class Admin_fields extends Admin_Controller
{
    protected $section = 'fields';

    protected $fieldsUi;
    // --------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // If they cannot administer profile fields,
        // then they can't access anythere here.
        role_or_die('users', 'admin_blog_fields');

        $this->lang->load(array('blog', 'categories'));
        $this->fieldsUi = new FieldUi;
    }

    // --------------------------------------------------------------------------

    /**
     * List out profile fields
     *
     * @return 	void
     */
    public function index()
    {
        $buttons = array(
            array(
                'url'		=> 'admin/blog/fields/edit/{{ id }}',
                'label'		=> $this->lang->line('global:edit')
            ),
            array(
                'url'		=> 'admin/blog/fields/delete/{{ id }}',
                'label'		=> $this->lang->line('global:delete'),
                'confirm'	=> true
            )
        );

        $this->fieldsUi->assignmentsTable('blog', 'blogs')
            ->title(lang('global:custom_fields'))
            ->addUri('admin/blog/fields/create')
            ->pagination(Settings::get('records_per_page'), 'admin/blog/fields/index')
            ->buttons($buttons)
            ->render();
    }

    // --------------------------------------------------------------------------

    /**
     * Create
     *
     * Create a new custom blog field
     *
     * @return 	void
     */
    public function create()
    {
        $this->fieldsUi->assignmentForm('blog', 'blogs')
            ->title(lang('streams:add_field'))
            ->redirects('admin/blog/fields')
            ->enableSetColumnTitle(false)
            ->render();
    }

    // --------------------------------------------------------------------------

    /**
     * Delete
     *
     * Delete a custom blog profile field.
     *
     * @return 	void
     */
    public function delete()
    {
        if ( ! $assign_id = $this->uri->segment(5)) {
            show_error(lang('streams:cannot_find_assign'));
        }

        // Tear down the assignment
        if ( ! $this->streams->cp->teardown_assignment_field($assign_id)) {
            $this->session->set_flashdata('notice', lang('streams:field_delete_error'));
        } else {
            $this->session->set_flashdata('success', lang('streams:field_delete_success'));
        }

        redirect('admin/blog/fields');
    }

    // --------------------------------------------------------------------------

    /**
     * Edit a profile field
     *
     * @return 	void
     */
    public function edit()
    {
        $this->fieldsUi->assignmentForm('blog', 'blogs', $this->uri->segment(5))
            ->title(lang('streams:edit_field'))
            ->redirects('admin/blog/fields')
            ->enableSetColumnTitle(false)
            ->render();
    }
}
