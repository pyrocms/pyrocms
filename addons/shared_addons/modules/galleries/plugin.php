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
	 * {pyro:galleries:images slug="nature" limit="5"}
	 * 	<a href="{pyro:url:base}galleries/{gallery_slug}/{id}" title="{name}">
	 * 		<img src="{pyro:url:base}files/thumb/{file_id}/75/75" alt="{description}"/>
	 * 	</a>
	 * {/pyro:galleries:images}
	 * 
	 * The following is a list of tags that are available to use from this method
	 * 
	 * 	{file_id}
	 * 	{folder_id}
	 * 	{gallery_id}
	 * 	{gallery_slug}
	 * 	{title}
	 * 	{order}
	 * 	{name}
	 * 	{filename}
	 * 	{description}
	 * 	{extension}
	 * 
	 * @return	array
	 */
	function images()
	{
		$limit	= $this->attribute('limit');
		$slug	= $this->attribute('slug');
		$offset = $this->attribute('offset');
		
		$this->load->model(array(
			'galleries_m',
			'gallery_images_m'
		));

		$gallery = $this->galleries_m->get_by('slug', $slug);

		return $gallery ? $this->gallery_images_m->get_images_by_gallery($gallery->id, array(
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

		$this->load->model('galleries_m');

		return (int) ($slug ? $this->galleries_m->count_by('slug', $slug) > 0 : FALSE);
	}
}

/* End of file plugin.php */