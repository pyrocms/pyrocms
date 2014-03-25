<?php

use Pyro\Module\Redirects\Model\Redirect;
use Pyro\Module\Redirects\Model\RedirectEntryModel;
use Pyro\Module\Redirects\Ui\RedirectEntryUi;

/**
 * Cms controller for the redirects module
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Redirects\Controllers
 */
class Admin extends Admin_Controller
{
    /**
     * Create new Admin instance
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('redirects');

        $this->redirects = new RedirectEntryModel();
        $this->ui        = new RedirectEntryUi();
    }

    /**
     * List all redirects
     */
    public function index()
    {
        $this->ui->table($this->redirects)->render();
    }

    /**
     * Create a new redirect
     */
    public function add()
    {
        $this->ui->form($this->redirects)->render();
    }

    /**
     * Edit an existing redirect
     *
     * @param int $id The ID of the redirect
     * @return void
     */
    public function edit($id)
    {
        $this->ui->form($this->redirects, $id)->render();
    }

    /**
     * Delete an existing redirect
     *
     * @param int $id The ID of the redirect
     * @return void
     */
    public function delete($id)
    {
        $this->redirects->find($id)->delete();

        redirect('admin/redirects');
    }
}
