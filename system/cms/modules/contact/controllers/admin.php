<?php

use Pyro\Module\Contact\Model\ContactLog;

/**
 * The admin controller for the Contact module.
 *
 * @author PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Contact\Controllers
 */
class Admin extends Admin_Controller
{

    /**
     * Shows the contact messages list.
     */
    public function index()
    {
        $this->load->language('contact');

        $this->template
            ->set('contact_log', ContactLog::findAndSortByDate('desc'))
            ->build('index');
    }

}
