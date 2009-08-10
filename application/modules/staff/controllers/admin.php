<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('staff_m');
		$this->lang->load('staff');
	}

	// Admin: List all Staff Members
	function index()
	{
		// Create pagination links
    $total_rows = $this->staff_m->countStaff();
    $this->data->pagination = create_pagination('admin/staff/index', $total_rows);
		
    // Using this data, get the relevant results
    $this->data->staff = $this->staff_m->getStaff(array('limit' => $this->data->pagination['limit']));
    $this->layout->create('admin/index', $this->data);
	}

	// Admin: Create a new Staff Member
	function create()
	{
		$this->load->library('validation');		
		$rules['user_id'] = 'trim|numeric';
		$rules['name'] = 'trim';
		$rules['email'] = 'trim';
		$rules['userfile'] = 'trim';
		$rules['position'] = 'trim|required|max_length[40]';
		$rules['body'] = 'trim|required';
		$rules['fact'] = 'trim';
		
		// No user id? Force a name & email out of them
		if(!$this->input->post('user_id'))
		{
			$rules['name'] .= '|required|max_length[40]|callback__name_check';
			$rules['email'] .= '|required|valid_email';
		}
		
		$this->validation->set_rules($rules);
		
		$fields['userfile'] = 'Photo';
		$fields['body'] = 'Bio';
		$this->validation->set_fields($fields);

		if ($this->validation->run())
		{
			$upload_cfg['upload_path'] = APPPATH.'assets/img/staff';
			$upload_cfg['overwrite'] = TRUE;
			
			if($this->input->post('user_id'))
			{
				$staff_user = $this->users_m->getUser( array('id' => $this->input->post('user_id')) );
				$_POST['name'] = $staff_user->full_name;
				$upload_cfg['new_name'] = url_title($staff_user->full_name);
			}			
			else 
			{
				$upload_cfg['new_name'] = url_title($this->input->post('name'));
			}
			
			$upload_cfg['allowed_types'] = 'gif|jpg|png';
			$this->load->library('upload', $upload_cfg);
			
			// Validation passed, attempt uploading the file
			if ( $this->upload->do_upload() )
			{
				$image = $this->upload->data();
				$this->_create_resize($image['file_name'], $this->config->item('staff_width'), $this->config->item('staff_height'));
				
				$staff_id = $this->staff_m->newStaff($_POST, $image);
				
				// New staff member added to the database ok
				if($staff_id > 0)
				{
					$this->session->set_flashdata('success', sprintf($this->lang->line('staff_member_add_success'), $this->input->post('name')));
				}				
				else
				{
					$this->session->set_flashdata('error', $this->lang->line('staff_mamber_add_error'));
				}				
				redirect('admin/staff/crop/' . $staff_id);
			}			
			show_error($this->upload->display_errors());
		}		
		$this->_user_select();
		
    	// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->layout->create('admin/create', $this->data);
	}

	// Admin: Edit a Staff Member
	function edit($slug = '')
	{		
		$this->load->library('validation');
		$rules['user_id'] = 'trim|numeric';
		$rules['slug'] = 'trim|numeric';
		$rules['name'] = 'trim';
		$rules['email'] = 'trim';
		$rules['position'] = 'trim|required|max_length[40]';
		$rules['body'] = 'trim|required';
		$rules['fact'] = 'trim';
		$rules['userfile'] = 'trim';
		
		// No user id? Force a name & email out of them
		if(!$this->input->post('user_id'))
		{
			$rules['name'] .= '|required|max_length[40]';
			$rules['email'] .= '|required|valid_email';
		}
		
		$this->validation->set_rules($rules);
		
		$fields['body'] = 'Bio';
		$this->validation->set_fields($fields);
		$this->data->member = $this->staff_m->getStaff( array("slug" => $slug) );
			
    foreach(array_keys($rules) as $field)
    {
    	if(isset($_POST[$field]))
      {
      	$this->data->member->$field = $this->validation->$field;
      }
    }
		
		if ($this->validation->run()) 
		{
			$data_array = $_POST;
			if ($_FILES['userfile']['name']) 
			{
				$upload_cfg['upload_path'] = APPPATH.'assets/img/staff';
				$upload_cfg['overwrite'] = TRUE;
				
				if($this->input->post('user_id'))
				{
					$staff_user = $this->users_m->getUser( array('id' => $this->input->post('user_id')) );
					$data_array['name'] = $staff_user->full_name;
					$upload_cfg['new_name'] = url_title($staff_user->full_name);
				}				
				else
				{
					$upload_cfg['new_name'] = url_title($this->input->post('name'));
				}
				$upload_cfg['allowed_types'] = 'gif|jpg|png';
				$this->load->library('upload', $upload_cfg);
				
				if ($this->upload->do_upload()) 
				{
					$image = $this->upload->data();
					$this->_create_resize($image['file_name'], $this->settings->item('staff_width'), $this->settings->item('staff_height'));
					$data_array['filename'] = $image['file_name'];
				}
			}			
			$this->staff_m->updateStaff($slug, $data_array);
			$this->session->set_flashdata('success', sprintf($this->lang->line('staff_member_edit_success'), $data_array['name']));
			
			if(isset($data_array['filename']))
			{
				redirect('admin/staff/crop/' . $slug);
			}			
			else
			{
				redirect('admin/staff/index');
			}
		}	    
		$this->_user_select();

    	// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );				
		$this->layout->create('admin/edit', $this->data);
	}

	// Admin: Delete a Staff Member
	function delete($slug = '')
	{
  		$img_folder = APPPATH.'assets/img/staff/';
		$slug_array = ($slug) ? array($slug) : array_keys($this->input->post('delete'));
		
		// Delete multiple
		if(!empty($slug_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($slug_array as $slug) 
			{
				$member_data = $this->staff_m->getStaff( array("slug" => $slug) );
				if( !$this->_delete_file( $img_folder , $member_data->filename ) )
				{
					// end the delete process, cant delete normally.
					redirect('admin/staff/index');
				}
				
				if($this->staff_m->deleteStaff($slug))
				{
					$deleted++;
				}
				else
				{
					$this->session->set_flashdata('error', sprintf($this->lang->line('staff_member_delete_error'), $slug));
				}
				$to_delete++;
			}
			
			if( $deleted > 0 )
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('staff_member_mass_delete_success'), $deleted, $to_delete));
			}
		}		
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('staff_member_mass_delete_error'));
		}		
		redirect('admin/staff/index');
	}
	
	function _delete_file($folder = FALSE, $file = FALSE)
	{
		if(!$folder || !$file) 
		{
			$this->session->set_flashdata('error', $this->lang->line('staff_folder_file_error'));
		}
		else
		{
			if(@file_exists($folder.$file))
			{
				if(@unlink($folder.$file))
				{
					return TRUE;
				}
				else
				{
					$this->session->set_flashdata('error', $this->lang->line('staff_delete_error'));
				}
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('staff_file_not_exist_error'));
			}
		}
		return FALSE;
	}

	// Admin: Crop for Home Page
  function crop($id = '')
	{
		if (empty($id)) redirect('admin/staff/index');
        
    $this->load->library('validation');
    $rules['x1'] = 'trim|required|numeric';
    $rules['y1'] = 'trim|required|numeric';
    $rules['x2'] = 'trim|required|numeric';
    $rules['y2'] = 'trim|required|numeric';
    $this->validation->set_rules($rules);
    $this->validation->set_fields();
        
		if( $this->data->member = $this->staff_m->getStaff(array("id" => $id)) )
		{
    	$this->data->image =& $this->data->member->filename;
    }

    if( empty($this->data->image) ) redirect('admin/staff/index');
        
		$this->load->library('image_lib');
		$this->load->config('image_settings');
		$this->data->image_data = $this->image_lib->get_image_properties(APPPATH.'assets/img/staff/'.$this->data->image, TRUE);

    if ($this->validation->run())
		{
			// 1. Crope the image
      $this->_create_home_crop($this->data->image, $this->input->post('x1'), $this->input->post('y1'), $this->input->post('x2'), $this->input->post('y2'));
			
      // 2. Resize the image
			$this->_create_resize($this->data->image, $this->config->item('staff_width'), $this->config->item('staff_height'));            
			redirect('admin/staff/index');
    }
    $this->layout->create('admin/crop', $this->data);
	}    
    
  // Private: Create the Crop for Home Page
  function _create_home_crop($image = '', $x = '', $y = '', $x2 = '', $y2 = '')
	{
  	$new_img = substr($image, 0, -4) . '_home' . substr($image, -4);
    unset($img_cfg);
    $img_cfg['source_image'] = APPPATH.'assets/img/staff/' . $image;
    $img_cfg['maintain_ratio'] = FALSE;
    $img_cfg['x_axis'] = $x;
    $img_cfg['y_axis'] = $y;
    $img_cfg['width'] = $x2 - $x;
    $img_cfg['height'] = $y2 - $y;
    $this->load->library('image_lib');
    $this->image_lib->initialize($img_cfg);
    $this->image_lib->crop();
  }

	// Private: Create resize of Cropped Image to ensure it's a certain size
	function _create_resize($homeimg = '', $x, $y)
	{
		unset($img_cfg);
		$img_cfg['source_image'] = APPPATH.'assets/img/staff/' . $homeimg;
		$img_cfg['new_image'] = APPPATH.'assets/img/staff/' . $homeimg;
		$img_cfg['maintain_ratio'] = true;
		$img_cfg['width'] = $x;
		$img_cfg['height'] = $y;
		$this->load->library('image_lib');
		$this->image_lib->initialize($img_cfg);
		$this->image_lib->resize();
	}

	function _user_select()
	{
		$this->load->module_model('users', 'users_m');
		$this->data->users = array(0=> $this->lang->line('staff_user_select_default'));
		foreach($this->users_m->getUsers(array('order'=>'full_name')) as $user)
		{
			$this->data->users[$user->id] = $user->full_name .' - '. $user->role;
		}
	}	

  // Callback: from create()
  function _name_check($title = '')
	{
  	if ($this->staff_m->checkName($title))
		{
    	$this->validation->set_message('_name_check', sprintf($this->lang->line('staff_member_already_exist'), $title));
      return FALSE;
    }
		else
		{
    	return TRUE;
    }
  }	
}
?>