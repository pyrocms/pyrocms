<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page_Variables_Data_m extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->_table = 'page_variables_data';
	}

	public function update_all($page_id, $inputs) {
		foreach($inputs as $name => $value) {
			if(stristr($name, 'variable_')) {
				$variable_info = explode('_', $name);
				// Get the current row if it exists
				$current_row = $this->get_where('page_variables_data', array('page_id' => $page_id, 'variable_id' => $variable_info[1]))->result_array();
				if(empty($current_row)) {
					$data = array(
							'page_id' => $page_id,
							'variable_id' => $variable_info[1],
							'data' => $value
						);
					$this->insert($data);
				} else {
					$this->update($current_row[0]['id'], array('data' => $value));
				}
			}
		}
	}
}