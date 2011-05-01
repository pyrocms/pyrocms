<?php defined('BASEPATH') OR exit('No direct script access allowed');
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
	}
	
	/**
	 * Get all gallery images in a folder
	 *
	 * @author PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the gallery
	 * @param array $options Options
	 * @return mixed
	 */
	public function get_images_by_gallery($id, $options = array())
	{
		// Find new images on files
		$this->set_new_image_files($id);

		// Clear old files on images
		$this->unset_old_image_files($id);

		if (isset($options['offset']))
		{
			$this->db->limit($options['offset']);
		}

		if (isset($options['limit']))
		{
			$this->db->limit($options['limit']);
		}

		// Grand finale, do what you gotta do!!
		$images = $this->db
				// Select fields on gallery images table
				->select('gi.*, f.name, f.filename, f.extension, f.description, f.name as title, g.folder_id, g.slug as gallery_slug, g.title as gallery_title')
				// Set my gallery by id
				->where('g.id', $id)
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
				->result();

		return $images;
	}

	public function set_new_image_files($gallery_id = 0)
	{
		$this->db
			// Select fields on files table
			->select('f.id as file_id, g.id as gallery_id')
			->from('files f')
			// Set my gallery by id
			->where('g.id', $gallery_id)
			// Filter files from my gallery folder
			->join('galleries g', 'g.folder_id = f.folder_id', 'left')
			// Filter files type image
			->where('f.type', 'i')
			// Not require image files from my gallery in gallery images, prevent duplication
			->ar_where[] = "AND `f`.`id` NOT IN (SELECT file_id FROM (gallery_images) WHERE `gallery_id` = '$gallery_id')";

		// Already updated, nothing to do here..
		if ( ! $new_images = $this->db->get()->result())
		{
			return FALSE;
		}

		// Get the last position of order count
		$last_image = $this->db
			->select('`order`')
			->order_by('`order`', 'desc')
			->limit(1)
			->get_where('gallery_images', array('gallery_id' => $gallery_id))
			->row();

		$order = isset($last_image->order) ? $last_image->order + 1: 1;

		// Insert new images, increasing the order
		foreach ($new_images as $new_image)
		{
			$this->db->insert('gallery_images', array(
				'gallery_id'	=> $new_image->gallery_id,
				'file_id'		=> $new_image->file_id,
				'`order`'		=> $order++
			));
		}

		return TRUE;
	}

	public function unset_old_image_files($gallery_id = 0)
	{
		// Get all image files from folder of my gallery...
		$this->db
			->select('f.id')
			->from('files f')
			->join('galleries g', 'g.folder_id = f.folder_id')
			->where('f.type', 'i')
			->where('g.id', $gallery_id);
		$subquery = str_replace("\n", ' ', $this->db->_compile_select());
		$this->db->_reset_select();

		$this->db
			// Select fields on gallery images table
			->select('gi.id')
			->from('gallery_images gi')
			// Set my gallery by id
			->where('g.id', $gallery_id)
			// Filter images from my gallery
			->join('galleries g', 'g.id = gi.gallery_id')
			// Not required images that exists on my files table
			->ar_where[] = "AND `gi`.`file_id` NOT IN ($subquery)";

		// Already updated, nothing to do here..
		if ( ! $old_images = $this->db->get()->result())
		{
			return FALSE;
		}

		// Remove missing files images
		foreach ($old_images as $old_image)
		{
			$this->gallery_images_m->delete($old_image->id);
		}

		return TRUE;
	}
	
	/**
	 * Preview images from folder
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the folder
	 * @param array $options Options
	 * @return mixed
	 */
	public function get_images_by_file_folder($id, $options = array())
	{

		if (isset($options['offset']))
		{
			$this->db->limit($options['offset']);
		}

		if (isset($options['limit']))
		{
			$this->db->limit($options['limit']);
		}

		// Grand finale, do what you gotta do!!
		$images = $this->db
				->select('files.*')
				->where('folder_id', $id)
				->where('files.type', 'i')
				->get('files')
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