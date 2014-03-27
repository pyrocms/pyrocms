<?php

use \Pyro\Module\Addons\WidgetModel;

/**
 * Ajax controller for the widgets module
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Widgets\Controllers
 */
class Ajax extends MY_Controller
{
    /**
     * Constructor method
     *
     * @return void
     */
    public function __construct()
    {
        // Call the parent's constructor method
        parent::__construct();

        $this->lang->load('widgets');

        $this->widgets = new WidgetModel();
    }

    /**
     * Update the order of the widgets
     *
     * @return void
     */
    public function update_order($to = 'instance')
    {
        $ids = explode(',', $this->input->post('order'));

        $i = 0;

        switch ($to) {
            case 'instance':
                foreach ($ids as $id) {
                    $id = str_replace('instance-', '', $id);
                    $this->widgets->whereId($id)->update(array('order' => $i++));
                }
                break;

            case 'widget':
                foreach ($ids as $id) {
                    $this->widgets->update_widget_order($id, ++$i);
                }
                break;
        }

        $this->cache->forget('widget_m');
    }
}
