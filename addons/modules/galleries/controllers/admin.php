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
	public $id = 0;

	/**
	 * Validation rules for creating a new gallery
	 *
	 * @var array
	 * @access private
	 */
	private $gallery_validation_rules = array(
		array(
			'field' => 'title',
			'label' => 'lang:galleries.title_label',
			'rules' => 'trim|max_length[255]|required'
		),
		array(
			'field' => 'slug',
			'label' => 'lang:galleries.slug_label',
			'rules' => 'trim|max_length[255]|required|callback__check_slug'
		),
		array(
			'field' => 'folder_id',
			'label' => 'lang:galleries.folder_label',
			'rules' => 'trim|numeric|required|callback__check_folder'
		),
		array(
			'field' => 'description',
			'label' => 'lang:galleries.description_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'enable_comments',
			'label' => 'lang:galleries.comments_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'published',
			'label' => 'lang:galleries.published_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'gallery_thumbnail',
			'label'	=> 'lang:galleries.thumbnail_label',
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
			'label' => 'lang:gallery_images.title_label',
			'rules' => 'trim|max_length[255]|required'
		),
		array(
			'field' => 'userfile',
			'label' => 'lang:gallery_images.image_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'gallery_id',
			'label' => 'lang:gallery_images.gallery_label',
			'rules' => 'trim|integer|required'
		),
		array(
			'field' => 'description',
			'label' => 'lang:gallery_images.description_label',
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

		$this->load->model('files/file_folders_m');

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	}

	/**
	 * List all existing albums
	 *
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
	 * @access public
	 * @return void
	 */
	public function create()
	{
		$this->file_folders_m->folder_tree();
		$file_folders = $this->file_folders_m->get_folders();

		// Set the validation rules
		$this->form_validation->set_rules($this->gallery_validation_rules);

		if ($this->form_validation->run() )
		{
			if ($this->galleries_m->insert($_POST))
			{
				// Everything went ok..
				$this->session->set_flashdata('success', lang('galleries.create_success'));
				redirect('admin/galleries');
			}
			
			// Something went wrong..
			else
			{
				$this->session->set_flashdata('error', lang('galleries.create_error'));
				redirect('admin/galleries/create');
			}
		}

		// Required for validation
		foreach ($this->gallery_validation_rules as $rule)
		{
			$gallery->{$rule['field']} = $this->input->post($rule['field']);
		}

		$this->template
			->append_metadata( js('form.js', 'galleries') )
			->append_metadata(js('functions.js', 'galleries') )
			->append_metadata( css('galleries.css', 'galleries') )
			->title($this->module_details['name'], lang('galleries.new_gallery_label'))
			->set('gallery', $gallery)
			->set('file_folders', $file_folders)
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

		$this->id = $id;

		// Valid form data?
		if ($this->form_validation->run() )
		{
			// Try to update the gallery
			if ($this->galleries_m->update($id, $_POST) === TRUE )
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
		foreach ($this->gallery_validation_rules as $rule)
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
		if ($_POST )
		{
			$id_array = $_POST['action_to'];
		}
		else
		{
			if ($id !== NULL )
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
				if ($this->galleries_m->delete($id) AND $this->gallery_images_m->delete_by('gallery_id', $id) )
				{
					$this->session->set_flashdata('error', sprintf( lang('galleries.folder_error'), $gallery->title));
					redirect('admin/galleries');
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
	 * @author PyroCMS Dev Team
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
		
		//lets put the gallery id into flashdata.  We be usin' this later
		$this->session->set_flashdata('gallery_id', $this->input->post('gallery_id'));
		
		if ($this->form_validation->run() )
		{
			
			if ($this->gallery_images_m->upload_image($_POST) === TRUE )
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

		foreach ($this->image_validation_rules as $rule)
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
				'order' => $i
			));

			if ($i === 1)
			{
				$preview = $this->gallery_images_m->get($id);

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

	/**
	 * Sort images in an existing gallery
	 *
	 * @author Phil Sturgeon - PyroCMS Dev Team
	 * @access public
	 */
	public function ajax_select_folder($folder_id)
	{
		$folder = $this->file_folders_m->get($folder_id);

		echo json_encode($folder);
	}

	/**
	 * Callback method that checks the slug of the gallery
	 * @access public
	 * @param string title The slug to check
	 * @return bool
	 */
	public function _check_slug($slug = '')
	{
		if ( ! $this->galleries_m->check_slug($slug, $this->id))
		{
			return TRUE;
		}

		$this->form_validation->set_message('_check_slug', sprintf(lang('galleries.already_exist_error'), $slug));

		return FALSE;
	}

	/**
	 * Callback method that checks the file folder of the gallery
	 * @access public
	 * @param int id The id to check if file folder exists or prep to create new folder
	 * @return bool
	 */
	public function _check_folder($id = 0)
	{
		// Is not creating or folder exist.. Nothing to do.
		if ($this->method !== 'create')
		{
			return $id;
		}
		elseif ($this->file_folders_m->exists($id))
		{
			if ($this->galleries_m->count_by('folder_id', $id) > 0)
			{
				$this->form_validation->set_message('_check_folder', lang('galleries.folder_duplicated_error'));

				return FALSE;
			}

			return $id;
		}

		$folder_name = $this->input->post('title');
		$folder_slug = url_title(strtolower($folder_name));

		// Check if folder already exist, rename if necessary.
		$i = 0;
		$counter = '';
		while ( ((int) $this->file_folders_m->count_by('slug', $folder_slug . $counter) > 0))
		{
			$counter = '-' . ++$i;
		}

		// Return data to create a new folder to this gallery.
		return array(
			'name' => $folder_name . ($i > 0 ? ' (' . $i . ')' : ''),
			'slug' => $folder_slug . $counter
		);
	}
}
