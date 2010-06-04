<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * The galleries module enables users to create albums, upload photos and manage their existing albums.
 *
 * @author 		Yorick Peterse - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Gallery Module
 * @category 	Modules
 * @license 	Apache License v2.0
 */
class Admin extends Admin_Controller
{
	/**
	 * Validation rules for creating a new gallery
	 * 
	 * @var array
	 * @access private
	 */
	private $gallery_validation_rules = array();
	
	/**
	 * Validation rules for uploading photos
	 *
	 * @var array
	 * @access private
	 */
	private $photo_validation_rules = array();
	
	/**
	 * Constructor method
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// First call the parent's constructor
		parent::__construct();
		
		// Load all the required classes
		$this->load->model('galleries_m');
		$this->load->model('gallery_images_m');
		$this->load->library('form_validation');
		
		// Set the validation rules
		$this->gallery_validation_rules = array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'trim|max_length[255]|required'
			),
			array(
				'field' => 'slug',
				'label' => 'Slug',
				'rules' => 'trim|max_length[255]|required'
			),
			array(
				'field' => 'parent',
				'label' => 'Parent',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'trim'
			),
			array(
				'field' => 'gallery_thumbnail',
				'label'	=> 'Thumbnail',
				'rules'	=> 'trim'
			)
			
		);
		$this->image_validation_rules	= array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'trim|max_length[255]|required'
			),
			array(
				'field' => 'userfile',
				'label' => 'Image',
				'rules' => 'trim'
			),
			array(
				'field' => 'gallery_id',
				'label' => 'Gallery',
				'rules' => 'trim|integer|required'
			),
			array(
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'trim'
			)
		);
		
		$this->template->set_partial('sidebar', 'admin/sidebar');
	}

	/**
	 * List all existing albums
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Get all the galleries
		$galleries = $this->galleries_m->get_all();
		
		// Load the view
		$this->data->galleries =& $galleries;
		$this->template->build('admin/index', $this->data);
	}
	
	/**
	 * Create a new gallery
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Get all the galleries
		$galleries = $this->galleries_m->get_all();
		
		// Set the validation rules
		$this->form_validation->set_rules($this->gallery_validation_rules);
		
		if ( $this->form_validation->run() )
		{			
			// Insert the gallery
			if ( $this->galleries_m->insert_gallery($_POST) === TRUE )
			{
				// Everything went ok..
				$this->session->set_flashdata('success', 'The gallery has been created successfully.');
				redirect('admin/galleries');
			}
			// Something went wrong..
			else
			{
				// Remove the directory
				$this->galleries_m->rm_gallery_dir($_POST['slug']);
				
				$this->session->set_flashdata('error', 'The gallery could not be created.');
				redirect('admin/galleries/create');
			}
		}
		
		// Required for validation
		foreach($this->gallery_validation_rules as $rule)
		{
			$gallery->{$rule['field']} = $this->input->post($rule['field']);
		}
		
		// Load the view
		$this->data->gallery 	=& $gallery;
		$this->data->galleries 	=& $galleries;
		// $this->template->append_metadata( js('form.js', 'galleries') );
		$this->template->build('admin/new_gallery', $this->data);
	}
	
	/**
	 * Manage an existing gallery
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the gallery to manage
	 * @return void
	 */
	public function manage($id)
	{
		$this->form_validation->set_rules($this->gallery_validation_rules);
		
		// Get the gallery and all images
		$galleries 		= $this->galleries_m->get_all();
		$gallery 		= $this->galleries_m->get($id);
		$gallery_images = $this->gallery_images_m->get_images_by_gallery($id);
		
		if ( empty($gallery) )
		{
			$this->session->set_flashdata('error', 'The specified gallery does not exist.');
			redirect('admin/galleries');
		}
		
		// Valid form data?
		if ( $this->form_validation->run() )
		{
			// Try to update the gallery
			if ( $this->galleries_m->update_gallery($id, $_POST) === TRUE )
			{
				$this->session->set_flashdata('success', 'The gallery has been successfully updated.');
				redirect('admin/galleries');
			}
			else
			{
				$this->session->set_flashdata('error', 'The gallery could not be updated.');
				redirect('admin/galleries/manage/' . $id);
			}
		}
		
		// Required for validation
		foreach($this->gallery_validation_rules as $rule)
		{
			if ($this->input->post($rule['field']))
			{
				$gallery->{$rule['field']} = $this->input->post($rule['field']);
			}
		}	
		
		// Load the view data
		$this->data->gallery 		=& $gallery;
		$this->data->galleries		=& $galleries;
		$this->data->gallery_images =& $gallery_images;
		
		// Load the view itself
		$this->template->append_metadata( css('galleries.css', 'galleries') )
		   			   ->append_metadata( js('jcrop.js', 'galleries') )
		   			   ->append_metadata( js('jcrop_init.js', 'galleries') );
		$this->template->build('admin/manage_gallery', $this->data);
	}
	
	/**
	 * Delete an existing gallery
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the gallery to delete
	 * @return void
	 */
	public function delete($id)
	{
		// Get the gallery
		$gallery = $this->galleries_m->get($id);
		
		// Does the gallery exist?
		if ( !empty($gallery) )
		{			
			// Delete the gallery along with all the images from the database
			if ( $this->galleries_m->delete($id) AND $this->gallery_images_m->delete_by('gallery_id', $id) )
			{
				// Delete the directory
				if ( $this->galleries_m->rm_gallery_dir($gallery->slug) === TRUE )
				{
					$this->session->set_flashdata('success', sprintf('The gallery "%s" has been deleted successfully.', $gallery->title));
				}
				else
				{
					$this->session->set_flashdata('error', 'The gallery\'s directory could not be deleted.');
				}
			}
			else
			{
				$this->session->set_flashdata('error', sprintf('The gallery "%s" could not be deleted.', $gallery->title));
			}			
		}
		else
		{
			$this->session->set_flashdata('error', sprintf('The gallery "%s" does not exist.', $gallery->title));
		}
		
		redirect('admin/galleries');
	}
	
	/**
	 * Upload a new image
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function upload()
	{
		// Set the validation rules
		$this->form_validation->set_rules($this->image_validation_rules);
		
		// Get all available galleries
		$galleries = $this->galleries_m->get_all();
		
		// Are there any galleries at all?
		if ( empty($galleries) )
		{
			$this->session->set_flashdata('error', 'No galleries have been created yet.');
			redirect('admin/galleries');
		}
		
		if ( $this->form_validation->run() )
		{
			if ( $this->gallery_images_m->upload_image($_POST) === TRUE )
			{
				$this->session->set_flashdata('success', 'The image has been uploaded successfully.');
				redirect('admin/galleries');
			}
			else
			{
				$this->session->set_flashdata('error', 'The image could not be uploaded.  ');
				redirect('admin/galleries/upload');
			}
		}
		
		foreach($this->image_validation_rules as $rule)
		{
			$gallery_image->{$rule['field']} = $this->input->post($rule['field']);
		}
		
		// Set the view data
		$this->data->galleries		=& $galleries;
		$this->data->gallery_image 	=& $gallery_image;
		
		// Load the views
		$this->template->append_metadata( css('galleries.css', 'galleries') );
		$this->template->build('admin/upload', $this->data);
	}
	
	/**
	 * Edit an existing image
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the image to edit
	 * @return void
	 */
	public function edit_image($id)
	{
		// Get the specific image
		$gallery_image 		= $this->gallery_images_m->get_image($id);
		
		if ( empty($gallery_image) )
		{
			$this->session->set_flashdata('error', 'The specified image does not exist.');
			redirect('admin/galleries');
		}
		
		// Get rid of the validation rules we don't need
		$validation_rules 	= $this->image_validation_rules;
		unset($validation_rules[1]);
		unset($validation_rules[2]);
		
		$this->form_validation->set_rules($validation_rules);
		
		// I can haz valid formdata?
		if ( $this->form_validation->run() )
		{
			// Successfully updated the changes?
			if ( $this->gallery_images_m->update_image($id, $_POST) === TRUE)
			{
				// The delete action requires a different message
				if ( $_POST['thumbnail_actions'] === 'delete' )
				{
					$this->session->set_flashdata('success', 'The image has been deleted.');
				}
				else
				{
					$this->session->set_flashdata('success', 'The changes have been saved.');
				}
			}
			
			// Something went wrong...
			else
			{
				// The delete action requires a different message
				if ( $_POST['thumbnail_actions'] === 'delete' )
				{
					$this->session->set_flashdata('success', 'The image could not be deleted.');
				}
				else
				{
					$this->session->set_flashdata('success', 'The changes could not be saved.');
				}
			}
			
			if ( $_POST['thumbnail_actions'] === 'delete' )
			{
				redirect('admin/galleries');
			}
			else
			{
				redirect($this->uri->uri_string());
			}
		}
		
		// Required for validation
		foreach($validation_rules as $rule)
		{
			if ($this->input->post($rule['field']))
			{
				$gallery_image->{$rule['field']} = $this->input->post($rule['field']);
			}
		}
		
		// Load the views
		$this->data->gallery_image =& $gallery_image;
		$this->template->append_metadata( css('galleries.css', 'galleries') )
		   			   ->append_metadata( js('jcrop.js', 'galleries') )
		   			   ->append_metadata( js('jcrop_init.js', 'galleries') );
		$this->template->build('admin/edit', $this->data);
	}
}