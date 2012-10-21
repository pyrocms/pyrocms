<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page_Variables_m extends MY_Model {

	public function update_delete($input) {
		var_dump($input);
		foreach($input['edit_variable'] as $edit_variable) {
			$this->update($edit_variable['id'], array('name' => $edit_variable['name'],
													  'description' => $edit_variable['description'],
													  'type' => $edit_variable['type'],
													  'options' => $edit_variable['options']));
		}
		if(isset($input['new_variable'])) {
			foreach($input['new_variable'] as $new_variable) {
				$this->insert(array('name' => $new_variable['name'],
									'description' => $new_variable['description'],
									'type' => $new_variable['type'],
									'options' => $new_variable['options'],
									'layout_id' => $new_variable['layout_id']));
			}
		}

		if(!empty($input['delete_variables'])) {
			foreach($input['delete_variables'] as $delete_id) {
				// First we will delete the data that corresponds to this variable
				$this->page_variables_data_m->delete_by('variable_id', $delete_id);
			}
			$this->delete_many($input['delete_variables']);
		}
	}
}