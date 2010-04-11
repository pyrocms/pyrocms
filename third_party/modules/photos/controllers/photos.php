<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photos extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();
		
		$this->load->model('photos_m');
		$this->load->model('photo_albums_m');
		
		$this->lang->load('photos');
		$this->lang->load('photo_albums');
	}
	
	// Public: List albums
	function index()
	{
		$this->data->photo_albums = $this->photo_albums_m->get_many_by('parent', 0);
		$this->template->build('index', $this->data);
	}

	// Public: View an album
	function album($slug = '')
	{
		if( !$album = $this->photo_albums_m->get_by('slug', $slug))
		{
			show_404();
		}

		$album->children = $this->photo_albums_m->get_many_by('parent', $album->id);

		$this->data->photos = $this->photos_m->get_many_by('album_id', $album->id);
		$this->data->album =& $album;

		$this->template
			->title(lang('photos.title'), $album->title)
			->build('album', $this->data);
	}

	// Public: View a photo
	function view($album_slug = '', $photo_id = 0)
	{
		if( !$album = $this->photo_albums_m->get_by('slug', $album_slug))
		{
			show_404();
		}

		$this->data->photo = $this->photos_m->get($photo_id);
		$this->data->album =& $album;

		$this->template
			->title(lang('photos.title'), $album->title)
			->build('view', $this->data);
	}
}
?>