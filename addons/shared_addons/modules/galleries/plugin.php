<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Galleries Plugin
 *
 * Create a list of images
 *
 * @package		PyroCMS
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
 */
class Plugin_Galleries extends Plugin
{
	/**
	 * Image List
	 * 
	 * Creates a list of gallery images
	 * 
	 * Usage:
	 * 
	 * {{ galleries:images slug="nature" limit="5" }}
	 * 	<a href="{{ url:base }}galleries/{{ gallery_slug }}/{{ id }}" title="{{ name }}">
	 * 		<img src="{{ url:site }}files/thumb/{{ file_id }}/75/75" alt="{{ description }}"/>
	 * 	</a>
	 * {{ /galleries:images }}
	 * 
	 * The following is a list of tags that are available to use from this method
	 * 
	 * 	{{ file_id }}
	 * 	{{ folder_id }}
	 * 	{{ gallery_id }}
	 * 	{{ gallery_slug }}
	 * 	{{ title }}
	 * 	{{ order }}
	 * 	{{ name }}
	 * 	{{ filename }}
	 * 	{{ description }}
	 * 	{{ extension }}
	 * 
	 * @return	array
	 */
	function images()
	{
		$limit	= $this->attribute('limit');
		$slug	= $this->attribute('slug');
		$offset = $this->attribute('offset');
		
		$this->load->model(array(
			'gallery_m',
			'gallery_image_m'
		));

		$gallery = $this->gallery_m->get_by('slug', $slug);

		return $gallery ? $this->gallery_image_m->get_images_by_gallery($gallery->id, array(
			'limit' => $limit,
			'offset' => $offset
		)) : array();
	}

	/**
	 * Gallery exists
	 * 
	 * Check if a gallery exists
	 * 
	 * @return	int 0 or 1
	 */
	function exists()
	{
		$slug = $this->attribute('slug');

		$this->load->model('gallery_m');

		return (int) ($slug ? $this->gallery_m->count_by('slug', $slug) > 0 : FALSE);
	}
}

/* End of file plugin.php */