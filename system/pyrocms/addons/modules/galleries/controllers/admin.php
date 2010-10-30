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
	private $gallery_validation_rules = array(
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
			'field' => 'parent_id',
			'label' => 'Parent',
			'rules' => 'trim'
		),
		array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'trim'
		),
		array(
			'field' => 'enable_comments',
			'label' => 'Enable Comments',
			'rules' => 'trim'
		),
		array(
			'field' => 'published',
			'label' => 'Published',
			'rules' => 'trim'
		),
		array(
			'field' => 'gallery_thumbnail',
			'label'	=> 'Thumbnail',
			'rules'	=> 'trim'
		)

	);

	/**
	 * Validation rules for uploading photos
	 *
	 * @var array
	 * @access private
	 */
	private $image_validation_rules = array(
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

	/**
	 * Constructor method
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('galleries_m');
		$this->load->model('gallery_images_m');
		$this->load->library('form_validation');
		$this->lang->load('galleries');
		$this->lang->load('gallery_images');
		$this->load->helper('html');

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
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
		$this->template
			->title($this->module_details['name'])
			->append_metadata(js('functions.js', 'galleries'))
			->set('galleries', $galleries)
			->build('admin/index');
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
			if ($this->galleries_m->insert_gallery($_POST))
			{
				// Everything went ok..
				$this->session->set_flashdata('success', lang('galleries.create_success'));
				redirect('admin/galleries');
			}
			
			// Something went wrong..
			else
			{
				// Remove the directory
				$this->galleries_m->rm_gallery_dir($_POST['slug']);

				$this->session->set_flashdata('error', lang('galleries.create_error'));
				redirect('admin/galleries/create');
			}
		}

		// Required for validation
		foreach($this->gallery_validation_rules as $rule)
		{
			$gallery->{$rule['field']} = $this->input->post($rule['field']);
		}

		$this->template
			->append_metadata( js('form.js', 'galleries') )
			->append_metadata(js('functions.js', 'galleries') )
			->append_metadata( css('galleries.css', 'galleries') )
			->title($this->module_details['name'], lang('galleries.new_gallery_label'))
			->set('gallery', $gallery)
			->set('galleries', $galleries)
			->build('admin/new_gallery');
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
			$this->session->set_flashdata('error', lang('galleries.exists_error'));
			redirect('admin/galleries');
		}

		// Valid form data?
		if ( $this->form_validation->run() )
		{
			// Try to update the gallery
			if ( $this->galleries_m->update_gallery($id, $_POST) === TRUE )
			{
				$this->session->set_flashdata('success', lang('galleries.update_success'));
				redirect('admin/galleries/manage/' . $id);
			}
			else
			{
				$this->session->set_flashdata('error', lang('galleries.update_error'));
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

		$this->template
			->title($this->module_details['name'], lang('galleries.manage_gallery_label'))
			->append_metadata( css('galleries.css', 'galleries') )
		   	->append_metadata( js('drag_drop.js', 'galleries') )
			->append_metadata(js('functions.js', 'galleries') )
			->append_metadata( js('form.js', 'galleries') )
			->set('gallery', $gallery)
			->set('galleries', $galleries)
			->set('gallery_images', $gallery_images)
			->build('admin/manage_gallery');
	}

	/**
	 * Delete an existing gallery
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the gallery to delete
	 * @return void
	 */
	public function delete($id = NULL)
	{
		$id_array = array();

		// Multiple IDs or just a single one?
		if ( $_POST )
		{
			$id_array = $_POST['action_to'];
		}
		else
		{
			if ( $id !== NULL )
			{
				$id_array[0] = $id;
			}
		}

		if ( empty($id_array) )
		{
			$this->session->set_flashdata('error', lang('galleries.id_error'));
			redirect('admin/galleries');
		}

		// Loop through each ID
		foreach ( $id_array as $id)
		{
			// Get the gallery
			$gallery = $this->galleries_m->get($id);

			// Does the gallery exist?
			if ( !empty($gallery) )
			{

				// Delete the gallery along with all the images from the database
				if ( $this->galleries_m->delete($id) AND $this->gallery_images_m->delete_by('gallery_id', $id) )
				{
					if ( !$this->galleries_m->rm_gallery_dir($gallery->slug) )
					{
						$this->session->set_flashdata('error', sprintf( lang('galleries.folder_error'), $gallery->title));
						redirect('admin/galleries');
					}
				}
				else
				{
					$this->session->set_flashdata('error', sprintf( lang('galleries.delete_error'), $gallery->title));
					redirect('admin/galleries');
				}
			}
		}

		$this->session->set_flashdata('success', lang('galleries.delete_success'));
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
			$this->session->set_flashdata('error', lang('galleries.no_galleries_error'));
			redirect('admin/galleries');
		}

		if ( $this->form_validation->run() )
		{
			if ( $this->gallery_images_m->upload_image($_POST) === TRUE )
			{
				$this->session->set_flashdata('success', lang('gallery_images.upload_success'));
				redirect('admin/galleries/upload');
			}
			else
			{
				$this->session->set_flashdata('error', lang('gallery_images.upload_error'));
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
		$this->template
			->set_layout('modal', 'admin')
			->append_metadata(css('galleries.css', 'galleries'))
			->append_metadata(js('functions.js', 'galleries'))
			->title($this->module_details['name'], lang('galleries.upload_label'))
			->build('admin/upload', $this->data);
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
			$this->session->set_flashdata('error', lang('gallery_images.exists_error'));
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
				if ( isset($_POST['delete']) )
				{
					$this->session->set_flashdata('success', lang('gallery_images.delete_success'));
				}
				else
				{
					$this->session->set_flashdata('success', lang('gallery_images.changes_success'));
				}
			}

			// Something went wrong...
			else
			{
				// The delete action requires a different message
				if ( isset($_POST['delete']) )
				{
					$this->session->set_flashdata('success', lang('gallery_images.delete_error'));
				}
				else
				{
					$this->session->set_flashdata('success', lang('gallery_images.changes_error'));
				}
			}

			if ( isset($_POST['delete']) )
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
						->append_metadata(js('functions.js', 'galleries') )
		   			   ->append_metadata( js('jcrop.js', 'galleries') )
		   			   ->append_metadata( js('jcrop_init.js', 'galleries') )
					   ->title($this->module_details['name'], lang('gallery_images.edit_image_label'))
					   ->build('admin/edit', $this->data);
	}

	/**
	 * Method to install the module
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function install()
	{
		if ( $this->galleries_m->install_module() === TRUE )
		{
			$this->session->set_flashdata('success', lang('galleries.install_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('galleries.install_error'));
		}

		redirect('admin/galleries');
	}

	/**
	 * Sort images in an existing gallery
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 * @access public
	 */

	public function ajax_update_order()
	{
		$ids = explode(',', $this->input->post('order'));

		$i = 1;

		foreach ($ids as $id)
		{
			$this->gallery_images_m->update($id, array(
				'`order`' => $i
			));

			if ($i === 1)
			{
				$preview = $this->db->get_where('galleries', array('id' => $id))->row();

				if ($preview)
				{
					$this->db->where('id', $preview->gallery_id);
					$this->db->update('galleries', array(
						'preview' => $preview->filename
					));
				}
			}
			++$i;
		}
	}
}
