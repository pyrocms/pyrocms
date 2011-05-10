<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * The galleries module enables users to create albums, upload photos and manage their existing albums.
 *
 * @author 		PyroCMS Dev Team
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
	 * @author PyroCMS Dev Team
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
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$data->galleries = $this->galleries_m->get_all_with_filename();

		$this->template
			->title($this->module_details['name'])
			->build('index', $data);
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
		$slug or show_404();

		$gallery		= $this->galleries_m->get_by('slug', $slug) or show_404();
		$gallery_images	= $this->gallery_images_m->get_images_by_gallery($gallery->id);
		$sub_galleries	= $this->galleries_m->get_all_with_filename('parent_id', $gallery->folder_id);
        if($gallery->css) {
            $this->template->append_metadata('<style type="text/css">' . PHP_EOL . $gallery->css . PHP_EOL . '</style>');
        }
        if($gallery->js) {
            $this->template->append_metadata('<script type="text/javascript">' . PHP_EOL . $gallery->js . PHP_EOL . '</script>');
        }
        
		$this->template->build('gallery', array(
			'gallery'			=> $gallery,
			'gallery_images'	=> $gallery_images,
			'sub_galleries'		=> $sub_galleries
		));
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
		
		$gallery		= $this->galleries_m->get_by('slug', $gallery_slug);
		$gallery_image	= $this->gallery_images_m->get($image_id);

		// Do the gallery and the image ID match?
		if ( ! $gallery OR ($gallery->id != $gallery_image->gallery_id))
		{
			show_404();
		}
		
		$this->template->build('image', array(
			'gallery'		=> $gallery,
			'gallery_image'	=> $gallery_image
		));
	}
}