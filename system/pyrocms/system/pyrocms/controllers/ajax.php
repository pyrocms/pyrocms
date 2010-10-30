<?php
class Ajax extends Controller
{
	function url_title()
	{
		$this->load->helper('text');

		$slug = url_title(htmlentities($this->input->post('title')), 'dash', TRUE);

		$this->output->set_output( $slug );
	}
}
