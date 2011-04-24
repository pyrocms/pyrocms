<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		Galleries Widget
 * @author			Pawel Martuszewski
 * 
 * Show a list of blog categories.
 */

class Widget_Galleries extends Widgets
{
	public $title		= array(
		'en' => 'Galleries',
		'pl' => 'Galerie'	
	);
	public $description	= array(
		'en' => 'Show a list of galleries',
		'pl' => 'Pokaż listę galeri'
	);
	public $author		= 'Pawel Martuszewski';
	public $website		= 'http://github.com/rat4m3n/';
	public $version		= '1.0';
	
	public function run()
	{
		$this->load->model('galleries/galleries_m');
		
		$galleries = $this->galleries_m->get_all();
		
		return array('galleries' => $galleries);
	}	
}