<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	// Set in constructor
	protected $validation_rules;
	
	function __construct()
	{
		parent::Admin_Controller();
		
		$this->load->model('photos_m');   
		$this->load->model('photo_albums_m');
		
		$this->lang->load('photos');
		$this->lang->load('photo_albums');
		
		$this->template->set_partial('sidebar', 'admin/sidebar');
		
		$this->validation_rules = array(
			array(
				'field'   => 'title',
				'label'   => lang('photo_albums.title_label'),
				'rules'   => 'trim|required|max_length[255]|callback__check_slug'
			),
			array(
				'field'   => 'slug',
				'label'   => lang('photo_albums.slug_label'),
				'rules'   => 'trim|required|max_length[255]|alpha_dash'
			),
			array(
				'field'   => 'description',
				'label'   => lang('photo_albums.desc_label'),
				'rules'   => 'trim|required'
			),
			array(
				'field'   => 'parent',
				'label'   => lang('photo_albums.parent_album_label'),
				'rules'   => 'trim|numeric'
			)
		);
	}
	
	// Public: List Galleries
	function index()
	{
		$this->load->helper('string');
		
		// Get Galleries and create pages tree
		$tree = array();
		$albums = $this->photo_albums_m->get_all();

		foreach($albums as $album)
		{
			$this->data->albums[$album->parent][] = $album;
		}
		
		$this->template->build('admin/index', $this->data);
	}
	
	// Admin: Create a new Album
	function create()
	{
		$albums = $this->photo_albums_m->get_all();
		$this->data->albums = array();
		
		foreach($albums as $album)
		{
			$this->data->albums[$album->parent][] = $album;
		}
			
		$this->load->library('form_validation', $this->validation_rules);
		
		foreach($this->validation_rules as $rule)
		{
			$album->{$rule['field']} = set_value($rule['field']);
		}
		
		if ($this->form_validation->run())
		{
			if ($this->photo_albums_m->insert($_POST))
			{
				$this->session->set_flashdata('success', sprintf( lang('photo_albums.add_success'), $this->input->post('title')) );
			}
			else
			{
				$this->session->set_flashdata(array('error'=> lang('photo_albums.add_error')));
			}
			redirect('admin/photos');
		}
		
		$this->data->album =& $album;
		
		// Load WYSIWYG editor
		$this->template->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('form.js', 'photos') );
					
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
		
		$albums = $this->photo_albums_m->get_all();
		$this->data->albums = array();
		
		foreach($albums as $this_album)
		{
			$this->data->albums[$this_album->parent][] = $this_album;
		}
		
		// Set validation
		$this->load->library('form_validation', $this->validation_rules);
		
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']) !== FALSE)
			{
				$album->{$rule['field']} = $this->input->post($rule['field']);
			}
		}
		
		// This will stop validation callback self-checking
		$this->id = $id; 
		
		// Run validation
		if ($this->form_validation->run())
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
		$this->template->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('form.js', 'photos') );
			
		$this->template->build('admin/form', $this->data);		
	}
	
	// Admin: Delete an album
	function delete($id = 0)
	{
		// An ID was passed in the URL, lets delete that
		$ids_array = ($id != '') ? array($id) : $this->input->post('action_to');
		
		if(empty($ids_array))
		{
			$this->session->set_flashdata('error',  lang('photo_albums.delete_no_select_error'));
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
				$this->session->set_flashdata('error', sprintf( lang('photo_albums.delete_error'), $id));
			}
		}
		
		if( $deleted > 0 )
		{
			$this->session->set_flashdata('success', sprintf( lang('photo_albums.mass_delete_success'), $deleted, count($ids_array)));
		}
		
		redirect('admin/photos');
	}
	
	// Admin: Upload a photo
	function manage($id = '')
	{	
		if (empty($id)) redirect('admin/photos');
		
		$this->data->album = $this->photo_albums_m->get($id);
		$this->data->photos = $this->photos_m->get_by_album($id);
		
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
					
				if( $this->photos_m->insert($image, $id, $this->input->post('description')) )
				{
					$this->session->set_flashdata('success', lang('photos.upload_success'));
				}
						
				else
				{
					$this->session->set_flashdata('error', sprintf( lang('photos.upload_error'), $image['file_name']));
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
		$album_id = $this->input->post('album');
				
		$ids_array = ( $id > 0 ) ? array($id) : $this->input->post('action_to');
		
		if(empty($ids_array))
		{
			$this->session->set_flashdata('error', lang('photos.delete_no_select_error'));
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
				$this->session->set_flashdata('success', sprintf( lang('photos.delete_success'), $deleted));
			}
			
			else
			{
				$this->session->set_flashdata('notice', lang('photos.delete_error'));
			}
		}
		
		redirect('admin/photos/manage/'.$album_id);
	}
	
	function ajax_update_order()
	{
		$ids = explode(',', $this->input->post('order'));
		
		$i = 1;
		
		foreach($ids as $id)
		{
			$this->photos_m->update($id, array(
				'`order`' => $i
			));
			
			++$i;
		}
	}
	
	// Callback: from create()
	function _check_slug($slug = '')
	{
		$id = isset($this->id) ? $this->id : NULL;
		
		if (!$this->photo_albums_m->check_slug($slug, $id))
		{
			$this->form_validation->set_message('_check_slug', lang('photo_albums.slug_already_exist_error'));
			return FALSE;
		}		
		
		return TRUE;
	}
}
?>
