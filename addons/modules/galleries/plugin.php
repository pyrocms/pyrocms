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
	 * 	<a href="/galleries/{gallery_slug}/{file_id}">
	 *		<img src="/uploads/files/{filename}" alt="{title}" title="{title}" />
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
		$limit = $this->attribute('limit');
		$slug = $this->attribute('slug');
		
		$images = $this->db
				// Select fields on gallery images table
				->select('gi.*, f.name, f.filename, f.extension, f.description, f.name as title, g.folder_id, g.slug as gallery_slug')
				// Set my gallery by id
				->where('g.slug', $slug)
				// Filter images from my gallery
				->join('galleries g', 'g.id = gi.gallery_id', 'left')
				// Filter files from my images
				->join('files f', 'f.id = gi.file_id', 'left')
				// Filter files type image
				->where('f.type', 'i')
				// Order by user order
				->order_by('`gi`.`order`', 'asc')
				// Get all!
				->get('gallery_images gi')
				->result_array();
		
		return $images;
	}
}

/* End of file plugin.php */