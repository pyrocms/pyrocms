<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\FieldTypeManager;

/**
 * Admin controller for field types.
 *
 * @package   PyroCMS\Core\Modules\Addons\Controllers
 * @author    PyroCMS Dev Team
 * @copyright Copyright (c) 2012, PyroCMS LLC
 */
class Admin_field_types extends Admin_Controller
{

	/** @var string The current active section */
	protected $section = 'field_types';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->language('addons');
	}

	/**
	 * Index method
	 *
	 * Lists all plugins.
	 */
	public function index()
	{
		$modes = array();

		$this->load->driver('Streams');

		$types = FieldTypeManager::getAllTypes();

		foreach ($types as $type) {
			$modes[$type->field_type_mode][] = array(
				'name'		=> $type->field_type_name,
				'version'	=> (isset($type->version)) ? $type->version : null
			);
		}

		ksort($modes);

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/field_types/index', array('modes' => $modes));
	}

}
