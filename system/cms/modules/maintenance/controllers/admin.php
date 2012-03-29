<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The Maintenance Module - currently only remove/empty cache folder(s)
 *
 * @author		Donald Myers
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Maintainance\Controllers
 */

class Admin extends Admin_Controller
{

	private $cache_path;

	public function __construct()
	{
		parent::__construct();

		$this->cache_path = FCPATH.APPPATH.'cache/'.SITE_REF.'/';

		$this->config->load('maintenance');
		$this->lang->load('maintenance');
	}


	/**
	 * List all folders
	 */
	public function index()
	{
		$folders = glob($this->cache_path.'*', GLOB_ONLYDIR);

		// get protected cache folders from module config file
		$protected = (array)$this->config->item('maintenance.cache_protected_folders');
		$cannot_remove = (array)$this->config->item('maintenance.cannot_remove_folders');

		// remove protected
		foreach ($folders as $key => $folder)
		{
			$basename = basename($folder);

			if (in_array($basename, $protected))
			{
				unset($folders[$key]);
			}
			else
			{
				// we just use the filename on the front end to not expose complete paths
				$folder_ary[] = (object)array(
					'name' => $basename,
					'count' => count(glob($folder.'/*')),
					'cannot_remove' => in_array($basename, $cannot_remove)
				);
			}
		}

		$i = 0;
		$table_list = config_item('maintenance.export_tables');
		asort($table_list);

		foreach ($table_list as $table)
		{
			$tables->{$i}->{'name'} = $table;
			$tables->{$i}->{'count'} = $this->db->count_all($table);
			$i++;
		}

		$this->template
			->title($this->module_details['name'])
			->set('tables', $tables)
			->set('folders', &$folder_ary)
			->build('admin/items');
	}


	public function cleanup($name = '', $andfolder = 0)
	{
		$andfolder = ($andfolder) ? true : false;
		if ( ! empty($name))
		{
			$apath = $this->_refind_apath($name);

			if ( ! empty($apath))
			{
				$item_count = count(glob($apath.'/*'));
				// just empty or empty and remove?
				$which = ($andfolder) ? 'remove' : 'empty';

				if ($this->delete_files($apath, $andfolder))
				{
					$this->session->set_flashdata('success', sprintf(lang('maintenance.'.$which.'_msg'), $item_count, $name));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('maintenance.'.$which.'_msg_err'), $name));
				}
			}
		}

		redirect('admin/maintenance/');
	}

	/**
	 * Delete files from a path
	 *
	 * @param string $apath The path to delete files from.
	 * @param bool $andfolder Whether to delete the folder itself or not.
	 *
	 * @return bool
	 */
	private function delete_files($apath, $andfolder = false)
	{
		$this->load->helper('file');

		if ( ! delete_files($apath, true))
		{
			return false;
		}

		if ($andfolder)
		{
			if ( ! rmdir($apath))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Export a table into a specified data format.
	 *
	 * @param string $table The name of the table to export.
	 * @param string $type The type in which to export the data.
	 */
	public function export($table = '', $type = 'xml')
	{
		$this->load->model('maintenance_m');
		$this->load->helper('download');
		$this->load->library('format');

		$table_list = config_item('maintenance.export_tables');

		if (in_array($table, $table_list))
		{
			$this->maintenance_m->export($table, $type, $table_list);
		}
		else
		{
			redirect('admin/maintenance');
		}
	}

	/**
	 * Rediscover a path.
	 *
	 * @param string $name The name of the path.
	 * @return string The folder name.
	 */
	private function _refind_apath($name)
	{
		$folders = glob($this->cache_path.'*', GLOB_ONLYDIR);

		foreach ($folders as $folder)
		{
			if (basename($folder) === $name)
			{
				return $folder;
			}
		}
	}

}