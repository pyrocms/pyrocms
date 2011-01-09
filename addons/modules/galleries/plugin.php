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
	 * {pyro:galleries:images slug="nature" limit="5"}
	 *      <a href="galleries/{slug}/{id}"><img src="uploads/galleries/{slug}/full/{filename}{extension}" alt="{description}"/></a>
	 * {/pyro:galleries:images}
	 *
	 * @return	array
	 */
	function images()
	{
		$limit = $this->attribute('limit');
		$slug = $this->attribute('slug');
		
		return $this->db->select('gallery_images.*, galleries.slug, galleries.id as galleries_table_id')
						->from('gallery_images')
						->join('galleries', 'gallery_images.gallery_id = galleries.id')
						->where('slug', $slug)
						->order_by('`order`', 'desc')
						->limit($limit)
						->get()
						->result_array();
	}
}

/* End of file plugin.php */