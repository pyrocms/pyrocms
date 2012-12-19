<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Comments Plugin
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Comments\Plugins
 */
class Plugin_Comments extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Comments',
	);
	public $description = array(
		'en' => 'Display information about site comments.',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'your_method' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Displays some data from some module.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'order-dir' => array(// this is the order-dir="asc" attribute
						'type' => 'flag',// Can be: slug, number, flag, text, array, any.
						'flags' => 'asc|desc|random',// flags are predefined values like this.
						'default' => 'asc',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '20',
						'required' => false,
					),
				),
			),// end first method
		);
	
		//return $info;
		return array();
	}

	/**
	 * Count
	 *
	 * Usage:
	 * {{ comments:count item_id="{{ page:id }}" [module="pages"] [type="number"] }}
	 *
	 * @param array
	 * @return array
	 */
	public function count()
	{
		$item_id = $this->attribute('item_id', 0);
		$module  = $this->attribute('module', $this->module);
		$type    = $this->attribute('type', false);
		
		$this->load->helper('comments/comments');
		
		return count_comments($item_id, $module, $type);
	}
}

/* End of file plugin.php */
