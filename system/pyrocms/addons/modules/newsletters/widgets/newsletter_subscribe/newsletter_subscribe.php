<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Newsletter Subscribe Widget
 *
 * @author 	Stephen Cozart - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Newsletters
 * @category	Widgets
 */
class Widget_Newsletter_subscribe extends Widgets
{
	
	public $title = 'Newsletter Subscribe';
	public $description = 'Places a newsletter subscribe form for use in a widget area.';
	public $author = 'Stephen Cozart';
	public $website = 'http://github.com/clip';
	public $version = '1.0';
	
	/**
	 * array for storing widget options in the database.
	 * 
	 * html_upper for text to display above form input.
	 * html_lower for text to display below form input.
	 */
	public $fields = array(
		array(
			'field'   => 'html_upper',
			'label'   => 'HTML Upper',
			'rules'   => 'trim|xss_clean'
		),
		array(
			'field' => 'html_lower',
			'label' => 'HTML Lower',
			'rules' => 'trim|xss_clean'
		)
	);
	
	//run the widget
	public function run($options)
	{
		$this->load->model('modules/module_m');
		
		//check that the module is installed AND enabled
		$newsletters = $this->module_m->get('newsletters');
	
		//Prevent the widget from displaying if disabled or not installed		
		if($newsletters === FALSE OR empty($newsletters))
		{
			return FALSE;
		}
		
		$this->lang->load('newsletters/newsletter');

		if(!isset($options['html_upper']))
		{
			$options['html_upper'] = FALSE;	
		}
		
		if(!isset($options['html_lower']))
		{
			$options['html_lower'] = FALSE;	
		}

		return $options;
		
	}
}
/* End of file newsletter_subscribe.php */
