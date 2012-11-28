<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Hide_widget_title extends CI_Migration {

    public function up()
    {
		$instances = $this->db->get('widget_instances')->result();

		if ($instances)
		{
			foreach ($instances AS $instance)
			{
				$options = unserialize($instance->options);

				// we show the title by default on all existing widgets
				$options['show_title'] = true;

				$data = array('options' => serialize($options));

				$this->db->where('id', $instance->id)->update('widget_instances', $data);
			}
		}

		return true;
    }

    public function down()
    {
        return true;
    }
}