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
class Galleries extends Public_Controller
{
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
		
		// Load the required classes
		$this->load->model('galleries_m');
		$this->load->model('gallery_images_m');
		$this->lang->load('galleries');
		$this->lang->load('gallery_images');
		$this->load->helper('html');
	}
	
	/**
	 * Index method
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->data->galleries = $this->galleries_m->get_all_with_filename();
		$this->template->build('index', $this->data);
	}
	
	/**
	 * View a single gallery
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param string $slug The slug of the gallery
	 */
	public function gallery($slug = NULL)
	{
		if ( empty($slug) )
		{
			show_404();
		}
		
		$this->data->gallery 		= $this->galleries_m->get_by('slug', $slug);
		$this->data->gallery_images = $this->gallery_images_m->get_images_by_gallery($this->data->gallery->id);
		$this->data->sub_galleries 	= $this->galleries_m->get_all_with_filename('parent', $this->data->gallery->id);
		$this->template->build('gallery', $this->data);
	}
	
	/**
	 * View a single image
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param 
	 */
	public function image($gallery_slug = NULL, $image_id = NULL)
	{
		// Got the required variables?
		if ( empty($gallery_slug) OR empty($image_id) )
		{
			show_404();
		}
		
		$gallery 		= $this->galleries_m->get_by('slug', $gallery_slug);
		$gallery_image	= $this->gallery_images_m->get_by('id', $image_id);
		
		// Do the gallery and the image ID match?
		if ( $gallery->id != $gallery_image->gallery_id )
		{
			show_404();
		}
		
		// Load the view
		$this->data->gallery 		=& $gallery;
		$this->data->gallery_image 	=& $gallery_image;
		$this->template->build('image', $this->data);
	}
}