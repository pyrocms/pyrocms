<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Shared logic and data for all CMS controllers
 *
 * @package		MizuCMS
 * @subpackage	Libraries
 * @category	Controller
 * @author		Phil Sturgeon
 */
class WYSIWYG_Controller extends MY_Controller
{
	function WYSIWYG_Controller()
	{
		parent::MY_Controller();

	    //Not an admin and not allowed to see files, SO PISS OFF!
	    if($this->user->group !== 'admin' AND empty($this->permissions['files']))
	    {
			$this->ion_auth->logout();
	    	redirect('cms/login');
	    	exit;
	    }

		$this->load->vars(array(
			'editor_path' => $editor_path = APPPATH_URI . 'assets/js/editor/'
		));

		$this->template
			->set_layout('wysiwyg', 'admin')
	    	->append_metadata( js('jquery/jquery.js') )
	    	->append_metadata( '<script type="text/javascript">jQuery.noConflict();</script>' )
	    	->append_metadata( js('jquery/jquery.livequery.js') )
	    	->append_metadata( js('jquery/jquery.fancybox.js') )
	    	->append_metadata( js('jquery/jquery.fancybox.js') )
	    	->append_metadata( css('jquery/jquery.fancybox.css') );
	}
}