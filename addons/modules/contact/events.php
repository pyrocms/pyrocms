<?php defined('BASEPATH') or exit('No direct script access allowed');

class Events_Contact {

	public function __construct()
	{
		Events::register('public_controller', array($this, 'method_name'));
	}

	public function method_name()
	{
		echo 'it works';
	}
}
/* End of file events.php */
/* Location: ./pyrocms/addons/modules/contact/events.php */
