<?php
/**
* @author badsyntax.co.uk & pyrocms
*/

class Tinycimm_model extends Model {

	public $allowed_types = array();
	
	function Tinycimm_model(){
		parent::Model();
		$upload_config = $this->config->item('tinycimm_image_upload_config');
		$this->allowed_types = explode('|', $upload_config['allowed_types']);
	}
	
	/**
	* Get an asset from the database
	**/
	function get_asset($asset_id=0){
		return $this->db->where('id', (int) $asset_id)->get('asset', 1)->row();
	}

	/**
	* Get a list of assets by folder from the database
	**/
	function get_assets($folder_id=0, $user_id=1, $offset=NULL, $limit=NULL, $search_query=''){
		if (trim($search_query) != '') {
			$this->db->where('name', $search_query);
			$this->db->or_like('filename', $search_query);
			$this->db->or_like('description', $search_query);
		}
		(int) $folder_id and $this->db->where('folder_id', (int) $folder_id);
		// return assets belonging to user
		// (int) $user_id and $this->db->where('user_id', (int) $user_id);
		if (count($this->allowed_types)){
			$this->db->where("(extension = '.".implode("' or extension = '.", (array) $this->allowed_types)."')");
		}
		$this->db->order_by('dateadded', 'desc');
		return $this->db->get('asset', $limit, $offset)->result_array();
	}
	
	/**
	* Deletes an asset's data from the database
	**/
	function delete_asset($asset_id=0){
		return $this->db->where('id', (int) $asset_id)->delete('asset');	
	}

	/** 
	* Inserts an asset into the database
	**/
	function insert_asset($fields = array()){
		$this->db->set($fields)->insert('asset');
		return $this->db->insert_id();
	}

	function get_filesize_assets($folder_id=0){
		$this->db->select('SUM(filesize) AS filesize');
		if ((int) $folder_id) {
			$this->db->where('folder_id', $folder_id);
		}
		$result = $this->db->get('asset')->row();
		return $result->filesize;
	}
	
	function get_total_assets($folder_id=0){
		$this->db->select('COUNT(id) AS assets');
		if ((int) $folder_id) {
			$this->db->where('folder_id', $folder_id);
		}
		$result = $this->db->get('asset')->row();
		return $result->assets;
	}
	
	/** 
	* Updates an asset details in the database
	**/
	function update_asset($id=0, $fields=array()){
		return $this->db->where('id', $id)->update('asset', $fields); 
	}

	function update_assets($where=array(),$fields=array()){
		foreach($where as $fieldname=>$fieldvalue) {
			$this->db->where($fieldname, $fieldvalue);
		}
		return $this->db->update('asset', $fields);
	}

	/** 
	* Inserts a folder into the database
	**/
	function save_folder($folder_id=0, $folder_name='', $type_name=''){
		if ($folder_id) {
			$fields['name'] = $folder_name;
			return $this->db->where('id', $folder_id)->update('asset_folder', $fields);
		} else {
			$fields = array('name' => $folder_name);
			$this->db->set($fields)->insert('asset_folder');
			return $this->db->insert_id();
		}
	}
	
	/**
	* Get all image folders, or folders owned by $user_id
	**/
	function get_folders($type='image', $order_by='name', $user_id=FALSE){
		return $this->db->orderby('smart','desc')->orderby($order_by)->get('asset_folder')->result_array();
	}

	/**
	* Deletes a folder from the database
	**/
	function delete_folder($folder_id=0){
		return $this->db->where('id', (int) $folder_id)->delete('asset_folder');	
	}
	
	/**
	* Returns number of affected rows
	**/
	function affected_rows(){
		return $this->db->affected_rows();
	}

	// for use in the pyrocms link manager
	function get_pages_by_parent_id($parent_id=0) {
		$this->load->model('pages_m');
		return $this->pages_m->get_many_by('parent_id', $parent_id);
	}

	function has_children($parent_id=0){
		$this->load->model('pages_m');
		return $this->pages_m->has_children($parent_id);
	}
}
?>
