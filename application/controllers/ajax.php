<?php
class Ajax extends Controller
{
	function url_title()
	{
		$slug = url_title(strtolower(htmlentities($this->input->post('title'))));
		
		$this->output->set_output( $slug );
	}
}