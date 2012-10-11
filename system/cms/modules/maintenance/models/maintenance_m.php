<?php defined('BASEPATH') OR die('No direct script access allowed');
/**
 * Maintenance Module
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Maintenance\Models
 */
class Maintenance_m extends MY_Model
{
	public function export($table = '', $type = 'xml', $table_list)
	{
		switch ($table)
		{
			case 'users':
				$data_array = $this->db
					->select('users.id, email, IF(active = 1, "Y", "N") as active', false)
					->select('first_name, last_name, display_name, company, lang, gender, website')
					->join('profiles', 'profiles.user_id = users.id')
					->get('users')
					->result_array();
				break;

			case 'files':
				$data_array = $this->db
					->select('files.*, file_folders.name folder_name, file_folders.slug')
					->join('file_folders', 'files.folder_id = file_folders.id')
					->get('files')
					->result_array();
				break;

			default:
				$data_array = $this->db
					->get($table)
					->result_array();
				break;
		}
		force_download($table.'.'.$type, $this->format->factory($data_array)
			->{'to_'.$type}());
	}
}