<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();  
		$this->load->model('photos_m');   
		$this->load->model('photo_albums_m');
		$this->lang->load('photos');
		$this->lang->load('photo_albums');
		
		$this->template->set_partial('sidebar', 'admin/sidebar');
	}
	
	// Public: List Galleries
	function index()
	{
		$this->load->helper('string');
		
		// Get Galleries and create pages tree
		$tree = array();
		$albums = $this->photo_albums_m->get();

		foreach($albums as $album)
		{
			$tree[$album->parent][] = $album;
		}
		unset($albums);
		$this->data->albums =& $tree;		
		$this->template->build('admin/index', $this->data);
	}
	
	// Admin: Create a new Album
	function create()
	{
		// Get Galleries and create pages tree
		$tree = array();
		
		$albums = $this->photo_albums_m->get();
		foreach($albums as $album)
		{
			$tree[$album->parent][] = $album;
		}
		unset($albums);
		$this->data->albums = $tree;
			
		$this->load->library('validation');
		$rules['title'] = 'trim|required|max_length[255]|callback__createCheckTitle';
		$rules['description'] = 'trim|required';
		$rules['parent'] = 'trim|numeric';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		foreach(array_keys($rules) as $field)
		{
			$album->{$field} = (string) $this->input->post($field);
		}
		
		if ($this->validation->run())
		{
			if ($this->photo_albums_m->insert($_POST))
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('photo_albums.add_success'), $this->input->post('title')) );
			}
			else
			{
				$this->session->set_flashdata(array('error'=>$this->lang->line('photo_albums.add_error')));
			}
			redirect('admin/photos');
		}
		
		$this->data->album =& $album;
		
		// Load WYSIWYG editor
		$this->template->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->template->build('admin/form', $this->data);
	}
	
	// Admin: Edit an album
	function edit($id = 0)
	{
		$album = $this->photo_albums_m->get($id);

		if (empty($id) or !$album)
		{
			redirect('admin/photos/index');
		}
		
		$tree = array();
		foreach(@$this->photo_albums_m->get() as $album)
		{
			$tree[$album->parent][] = $album;
		}
		$this->data->albums = $tree;
		
		$this->load->library('validation');
		$rules['id'] = '';
		$rules['title'] = 'trim|required|max_length[255]';
		$rules['description'] = 'trim|required';
		$rules['parent'] = 'trim|numeric';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		// Run through all fields and auto-set data fields
		foreach(array_keys($rules) as $field)
		{
			if( $this->input->post($field) )
			{
				$album->$field = $this->validation->$field;
			}
		}
		
		
		// Run validation
		if ($this->validation->run())
		{
			if ($this->photo_albums_m->update($id, $_POST))
			{
				$this->session->set_flashdata('success', sprintf(lang('photo_albums.edit_success'), $album->title));
			}
			else
			{
				$this->session->set_flashdata('error', lang('photo_albums.edit_error'));
			}
			
			redirect('admin/photos');
		}

	
		$this->data->album =& $album;
		
		// Load WYSIWYG editor
		$this->template->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->template->build('admin/form', $this->data);		
	}
	
	// Admin: Delete an album
	function delete($id = 0)
	{
		// An ID was passed in the URL, lets delete that
		$ids_array = ($id != '') ? array($id) : $this->input->post('action_to');
		
		if(empty($ids_array))
		{
			$this->session->set_flashdata('error', $this->lang->line('photo_albums.delete_no_select_error'));
			redirect('admin/photos');
		}
		
		$deleted = 0;
		foreach ($ids_array as $id)
		{
			if($this->photo_albums_m->delete($id))
			{
				$deleted++;
			}				
			else
			{
				$this->session->set_flashdata('error', sprintf($this->lang->line('photo_albums.delete_error'), $id));
			}
		}
		
		if( $deleted > 0 )
		{
			$this->session->set_flashdata('success', sprintf($this->lang->line('photo_albums.mass_delete_success'), $deleted, count($ids_array)));
		}
		
		redirect('admin/photos/index');
	}
	
	// Admin: Upload a photo
	function manage($id = '')
	{	
		if (empty($id)) redirect('admin/photos');
		
		$this->data->gallery = $this->photo_albums_m->get($id); 
		$this->data->photos = $this->photos_m->get($id);		
		$this->template->build('admin/manage', $this->data);
	}
	
	
	function upload($id = '')
	{
		$this->load->library('validation');
		$rules['userfile'] = 'trim';
		$rules['description'] = 'trim|required';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		$upload_cfg['upload_path'] = APPPATH.'assets/img/photos/' . $id;
		$upload_cfg['allowed_types'] = 'gif|jpg|png';
		$upload_cfg['max_size'] = '2048';
		$upload_cfg['encrypt_name'] = TRUE;
		$this->load->library('upload', $upload_cfg);
		
		if ($this->validation->run())
		{
			if($this->upload->do_upload())
			{
				$image = $this->upload->data();			
				if( $this->photos_m->addPhoto($image, $id, $this->input->post('description')) )
				{
					$this->session->set_flashdata('success', sprintf($this->lang->line('photos.upload_success'), $image['file_name']));
				}				
				else
				{
					$this->session->set_flashdata('error', sprintf($this->lang->line('photos.upload_error'), $image['file_name']));
				}
			}			
			else
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}
		}
		
		else
		{
			$this->session->set_flashdata('error', $this->validation->error_string);
		}
		
		redirect('admin/photos/manage/'.$id);              	
	}
	
	// Admin: Delete Gallery Photos
	function delete_photo($id = 0)
	{
		$album_id = $this->input->post('album_id');
				
		$ids_array = ( $id > 0 ) ? array($id) : $this->input->post('action_to');
		
		if(empty($ids_array))
		{
			$this->session->set_flashdata('error', $this->lang->line('photos.delete_no_select_error'));
		}
		
		else
		{
			$deleted = 0;
			foreach ($ids_array as $photo_id)
			{
				if($this->photos_m->delete($photo_id))
				{
					$deleted++;
				}
			}
		
			if($deleted > 0)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('photos.delete_success'), $deleted));
			}
			
			else
			{
				$this->session->set_flashdata('notice', $this->lang->line('photos.delete_error'));
			}
		}		
		redirect('admin/photos/manage/'.$album_id);
	}
	
	// Callback: from create()
	function _createTitleCheck($title = '')
	{
		if ($this->photos_m->check_title($title))
		{
			$this->validation->set_message('_createTitleCheck', $this->lang->line('photo_albums.name_already_exist_error'));
			return FALSE;
		}		
		
		return TRUE;
	}
}
?>
