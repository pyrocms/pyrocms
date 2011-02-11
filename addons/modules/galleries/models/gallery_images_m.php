<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * The galleries module enables users to create albums, upload photos and manage their existing albums.
 *
 * @author 		PyroCMS Dev Team
 * @modified	Jerel Unruh - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Gallery Module
 * @category 	Modules
 * @license 	Apache License v2.0
 */
class Gallery_images_m extends MY_Model
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
		
		// Load all required classes
		$this->config->load('gallery_config');
		$this->load->library('upload');
		$this->load->library('image_lib');
	}
	
	/**
	 * Get all gallery images in a folder
	 *
	 * @author PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the gallery
	 * @return mixed
	 */
	public function get_images_by_gallery($id)
	{
		$images = $this->db
				->select('gi.*, f.name, f.filename, f.extension, g.folder_id, g.slug as gallery_slug')
				->join('galleries g', 'gi.gallery_id = g.id')
				->join('files f', 'gi.file_id = f.id')
				->where('g.folder_id', $id)
				->order_by('`order`', 'asc')
				->get('gallery_images gi')
				->result();

		// Nothing? Return nothing
		if ( ! isset($images[0]))
		{
			return array();
		}

		// Which folder is this gallery lookig at? There may be unknown images
		$folder_id = $images[0]->folder_id;

		$file_ids = array();
		foreach ($images as &$image)
		{
			$file_ids[] = $image->file_id;
		}

		// Add these images to the array
		$images += $new_images = $this->db
			->select('id as file_id, name, filename, extension, date_added as `order`')
			->where('folder_id', $folder_id)
			->where('type', 'i')
			->where_not_in('id', $file_ids)
			->get('files')
			->result();

		// To avoid messing about with this in the future, add these to the gallery
		foreach ($new_images as $new_image)
		{
			$this->db->insert('gallery_images', array(
				'gallery_id' => $id,
				'file_id' => $new_image->file_id,
				'`order`' => $new_image->order
			));
		}

		return $images;
	}
	
	/**
	 * Get an image along with the gallery slug
	 * 
	 * @author PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the image
	 * @return mixed
	 */
	public function get($id)
	{
		$query = $this->db
			->select('gi.*, f.name, f.filename, f.extension, g.folder_id, g.slug as gallery_slug')
			->join('galleries g', 'gi.gallery_id = g.id')
			->join('files f', 'gi.file_id = f.id')
			->where('gi.id', $id)
			->get('gallery_images gi');
				
		if ( $query->num_rows() > 0 )
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
}