<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photos extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();
		$this->load->model('photos_m');
		$this->lang->load('photos');
	}
	
	// Public: List Galleries
	function index()
	{
		$this->data->photos = $this->photos_m->getGalleries(array('parent'=>0));
		$this->template->build('index', $this->data);
	}
	
	// Public: View an Gallery
	function view($slug = '')
	{
		$this->load->model('comments/comments_m');
		
		if($this->data->gallery = $this->photos_m->getGallery($slug))
		{
			$this->data->photos = $this->photos_m->getPhotos($slug);		
			$this->data->children = $this->photos_m->getGalleries(array('parent'=>$this->data->gallery->id));		
			$this->template->title($this->data->gallery->title);
			$this->template->build('view', $this->data);
		}		
		else
		{
			$this->session->set_flashdata('notice', $this->lang->line('gal_already_exist_error'));
			redirect('photos');
		}
	}    
}
?>