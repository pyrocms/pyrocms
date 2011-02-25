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
		// Get unknown images from folder files to this gallery images
		if ($new_images = $this->db
				->select('f.id as file_id, g.id as gallery_id')
				->join('galleries g', 'g.folder_id = f.folder_id', 'left')
				->join('gallery_images gi', 'gi.file_id = f.id', 'left')
				->where('f.type', 'i')
				->where('g.id', $id)
				->where('gi.id', NULL)
				->order_by('`f`.`date_added`', 'asc')
				->get('files f')
				->result())
		{
			$last_image = $this->db
				->select('`order`')
				->order_by('`order`', 'desc')
				->limit(1)
				->get_where('gallery_images', array('gallery_id' => $id))
				->row();

			$order = isset($last_image->order) ? $last_image->order + 1: 1;

			foreach ($new_images as $new_image)
			{
				$this->db->insert('gallery_images', array(
					'gallery_id'	=> $new_image->gallery_id,
					'file_id'		=> $new_image->file_id,
					'`order`'		=> $order++
				));
			}
		}

		$images = $this->db
				->select('gi.*, f.name, f.filename, f.extension, f.description, f.name as title, g.folder_id, g.slug as gallery_slug')
				->join('galleries g', 'g.id = gi.gallery_id', 'left')
				->join('files f', 'f.id = gi.file_id', 'left')
				->where('g.id', $id)
				->where('f.type', 'i')
				->order_by('`order`', 'asc')
				->get('gallery_images gi')
				->result();

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
			->select('gi.*, f.name, f.filename, f.extension, f.description, f.name as title, g.folder_id, g.slug as gallery_slug')
			->join('galleries g', 'gi.gallery_id = g.id', 'left')
			->join('files f', 'f.id = gi.file_id', 'left')
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