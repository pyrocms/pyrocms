<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

    function __construct() {
        parent::Admin_Controller();
        $this->load->helper('galleries');
        $this->load->model('galleries_m');
    }

	// Public: List Galleries
    function index() {
        $this->load->helper('string');
        
    	// Get Pages and create pages tree
    	$tree = array();
		if($galleries_data = $this->galleries_m->getGalleries())
	    	foreach($galleries_data as $gallery)
	    	{
	    		$tree[$gallery->parent][] = $gallery;
	    	}
    	$this->data->galleries =& $tree;

    	$this->layout->create('admin/index', $this->data);
    }
    
    // Admin: Create a new Gallery
    function create() {
        
    	// Get Pages and create pages tree
    	$tree = array();
		if($galleries_data = $this->galleries_m->getGalleries())
		{
	    	foreach($galleries_data AS $data)
	    	{
	    		$tree[$data->parent][] = $data;
	    	}
		}
    	$this->data->galleries = $tree;
    	
    	$this->load->library('validation');
        $rules['title'] = 'trim|required|callback__createCheckTitle';
        $rules['description'] = 'trim|required';
        $rules['parent'] = 'trim|numeric';
        $this->validation->set_rules($rules);
        $this->validation->set_fields();
        
    
		foreach(array_keys($rules) as $field) {
			$this->data->gallery->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
		}
		
        $spaw_cfg = array('name'=>'description', 'content'=>$this->data->gallery->description);
        $this->load->library('spaw', $spaw_cfg);
		// setting directories for a SPAW editor instance:
		$this->spaw->setConfigItem(
			'PG_SPAWFM_DIRECTORIES',
			  array(
			    array(
			      'dir'     => '/uploads/gallery/flash/',
			      'caption' => 'Flash movies', 
			      'params'  => array(
			        'allowed_filetypes' => array('flash')
			      )
			    ),
			    array(
			      'dir'     => '/uploads/gallery/images/',
			      'caption' => 'Images',
			      'params'  => array(
			        'default_dir' => true, // set directory as default (optional setting)
			        'allowed_filetypes' => array('images')
			      )
			    ),
			  ),
			  SPAW_CFG_TRANSFER_SECURE
		);
        
        if ($this->validation->run()) {
            if ($this->galleries_m->newGallery($_POST)) {
                $this->session->set_flashdata(array('success'=>'Your gallery was saved.'));
            } else {
                $this->session->set_flashdata(array('error'=>'An error occurred.'));
            }
            redirect('admin/galleries');
        }
        
        $this->layout->create('admin/form', $this->data);
    }

    // Admin: Edit a Gallery
    function edit($slug = '') {

    	$this->data->gallery = $this->galleries_m->getGallery($slug);
		
		if (empty($slug) or !$this->data->gallery)
		{
			redirect('admin/galleries/index');
    	}
		
		$tree = array();
    	foreach(@$this->galleries_m->getGalleries() AS $data)
    	{
    		$tree[$data->parent][] = $data;
    	}
    	$this->data->galleries = $tree;

    	$this->load->library('validation');
		$rules['id'] = '';
		$rules['title'] = 'trim|required';
		$rules['description'] = 'trim|required';
		$rules['parent'] = 'trim|numeric';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();

		foreach(array_keys($rules) as $field) {
			if(isset($_POST[$field]))
			$this->data->gallery->$field = $this->validation->$field;
		}

		$spaw_cfg = array('name'=>'description', 'content'=>$this->data->gallery->description);
		$this->load->library('spaw', $spaw_cfg);
		// setting directories for a SPAW editor instance:
		$this->spaw->setConfigItem(
			'PG_SPAWFM_DIRECTORIES',
			  array(
			    array(
			      'dir'     => '/uploads/gallery/flash/',
			      'caption' => 'Flash movies', 
			      'params'  => array(
			        'allowed_filetypes' => array('flash')
			      )
			    ),
			    array(
			      'dir'     => '/uploads/gallery/images/',
			      'caption' => 'Images',
			      'params'  => array(
			        'default_dir' => true, // set directory as default (optional setting)
			        'allowed_filetypes' => array('images')
			      )
			    ),
			  ),
			  SPAW_CFG_TRANSFER_SECURE
		);

		if ($this->validation->run()) {
			if ($this->galleries_m->updateGallery($_POST, $slug)) {
				$this->session->set_flashdata(array('success'=>'Your gallery was saved.'));
			} else {
				$this->session->set_flashdata(array('error'=>'An error occurred.'));
			}
			redirect('admin/galleries');
		}

		$this->layout->create('admin/form', $this->data);
  
    }
    
    // Admin: Delete a Gallery
    function delete($slug = '') {
        // Delete one
		if($slug)
		{
			if($this->_delete_directory('./assets/img/galleries/'.$slug))
			{
				if($this->galleries_m->deleteGallery($slug))
				{
					$this->session->set_flashdata('success', 'Gallery '.$slug.' successfully deleted.');
				} else {
					$this->session->set_flashdata('error', 'Error occurred while trying to delete gallery '.$slug);
				}
			} else {
				$this->session->set_flashdata('error', 'Unable to delete dir '.$slug);
			}
		} else {
		// Delete multiple
			if(isset($_POST['delete']))
			{
				$deleted = 0;
				$to_delete = 0;
				foreach ($this->input->post('delete') as $slug => $value)
				{
					if($this->_delete_directory('./assets/img/galleries/'.$slug))
					{
						if($this->galleries_m->deleteGallery($slug))
						{
							$deleted++;
						} else {
							$this->session->set_flashdata('error', 'Error occurred while trying to delete gallery '.$slug);
						}
					} else {
						$this->session->set_flashdata('error', 'Unable to delete dir '.$slug);
					}
					$to_delete++;
				}
				if( $deleted > 0 ) $this->session->set_flashdata('success', $deleted.' galleries out of '.$to_delete.' successfully deleted.');
			} else {
				$this->session->set_flashdata('error', 'You need to select galleries first.');
			}
		}

		redirect('admin/galleries/index');
    }

	function _delete_directory($dirname) 
	{ 
		if (is_dir($dirname)) 
			$dir_handle = opendir($dirname); 
		else
			return false; 
		
		while($file = readdir($dir_handle)) 
		{ 
			if ($file != "." && $file != "..") 
			{ 
				if (!is_dir($dirname."/".$file)) 
					if(!@unlink($dirname."/".$file)) return false; 
				else 
					$this->_delete_directory($dirname.'/'.$file);	
			} 
		} 
		
		closedir($dir_handle); 
		if(!@rmdir($dirname))
		{
			return false;
		}
		
		return true; 
	}

 	// Admin: Delete Gallery Photos
    function deletephoto() {
    	if (!$this->input->post('btnDelete')) redirect('admin/galleries/index');
        foreach ($this->input->post('delete') as $photos => $value) {
            $this->galleries_m->deleteGalleryPhoto($photos);
        }
        redirect('admin/galleries/index');
        return;
    }
    
    // Admin: Upload a photo
    function upload($slug = '') {
		
		if (empty($slug)) redirect('admin/galleries/index');
            $this->load->library('validation');
            $rules['userfile'] = 'trim';
            $rules['description'] = 'trim';
            $this->validation->set_rules($rules);
            $this->validation->set_fields();
            
            $upload_cfg['upload_path'] = './assets/img/galleries/' . $slug;
            $upload_cfg['allowed_types'] = 'gif|jpg|png';
            $upload_cfg['max_size'] = '2048';
    		$upload_cfg['overwrite'] = TRUE;
            $this->load->library('upload', $upload_cfg);
            
            if (($this->validation->run()) && ($this->upload->do_upload())) {
                $image = $this->upload->data();
                $this->galleries_m->addPhoto($image, $slug, $this->input->post('description'));
            }
            
            $this->data->photos = $this->galleries_m->getPhotos($slug);
            
            $this->layout->create('admin/upload', $this->data);

    }
    
    // Callback: from create()
    function _createTitleCheck($title = '') {
        if ($this->galleries_m->checkTitle($title)) {
            $this->validation->set_message('_createTitleCheck', 'A gallery with this name already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	

}

?>