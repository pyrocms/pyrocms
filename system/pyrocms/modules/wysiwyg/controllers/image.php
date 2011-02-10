<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		WYSIWYG
 * @author			Phil Sturgeon, Stephen Cozart
 *
 * Manages image selection and insertion for WYSIWYG editors
 */
class Image extends WYSIWYG_Controller
{
	function __construct()
	{
		parent::WYSIWYG_Controller();

	}
	
	public function index($id = FALSE)
	{
		//list of folders for the sidebar
		$folders = $this->file_folders_m->get_many_by('parent_id', 0);
		
		//for dropdown list
		$sub_folders = $this->file_folders_m->get_folders();

		$active_folder = array();

		if(!empty($folders) and !$id)
		{
			$active_folder = $folders[0];
			$active_folder->items = $this->file_m->get_many_by(array('folder_id' => $active_folder->id, 'type' => 'i'));
		}
		elseif(!empty($folders) and $id)
		{
			$active_folder = $this->file_folders_m->get($id);
			$active_folder->items = $this->file_m->get_many_by(array('folder_id' => $id, 'type' => 'i'));
		}
		
		$this->template
			->set('folders', $folders)
			->set('sub_folders', $sub_folders)
			->set('active_folder', $active_folder)
			->title('Images')
			->build('image/index');
	}

}