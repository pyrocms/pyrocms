<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * The galleries module enables users to create albums, upload photos and manage their existing albums.
 *
 * @author 		Yorick Peterse - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Gallery Module
 * @category 	Modules
 * @license 	Apache License v2.0
 */
class Galleries_m extends MY_Model {

	/**
	 * Get all galleries along with the total number of photos in each gallery
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return mixed
	 */
	public function get_all()
	{
		$galleries = parent::get_all();
		$results = array();

		// Loop through each gallery and add the count of photos to the results
		foreach ($galleries as $gallery)
		{
			$count = $this->db
				->select('id')
				->where('gallery_id', $gallery->id)
				->count_all_results('gallery_images');

			$gallery->photo_count = $count;
			$results[] = $gallery;
		}

		// Return the results
		return $results;
	}

	/**
	 * Get all galleries along with the thumbnail's filename and extension
	 *
	 * @access public
	 * @return mixed
	 */
	public function get_all_with_filename($where = NULL, $value = NULL)
	{
		$this->db
			->select('g.*, f.filename, f.extension')
			->from('galleries g')
			->join('gallery_images gi', 'g.thumbnail_id = gi.id', 'left')
			->join('files f', 'gi.file_id = f.id')
			->join('file_folders ff', 'g.folder_id = ff.id')
			->where('g.published', '1');

		// Where clause provided?
		if ( ! empty($where) AND ! empty($value))
		{
			$this->db->where($where, $value);
		}

		return $this->db->get()->result();
	}

	/**
	 * Insert a new gallery into the database
	 *
	 * @author PyroCMS Dev Team
	 * @access public
	 * @param array $input The data to insert (a copy of $_POST)
	 * @return bool
	 */
	public function insert($input)
	{
		return (bool) parent::insert(array(
			'title' => $input['title'],
			'slug' => $input['slug'],
			'folder_id' => $input['folder_id'],
			'description' => $input['description'],
			'enable_comments' => $input['enable_comments'],
			'published' => $input['published'],
			'updated_on' => time()
		));
	}

	/**
	 * Update an existing gallery
	 *
	 * @author PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the row to update
	 * @param array $input The data to use for updating the DB record
	 * @return bool
	 */
	public function update($id, $input)
	{
        return parent::update($id, array(
			'title' => $input['title'],
			'slug' => $input['slug'],
			'description' => $input['description'],
			'enable_comments' => $input['enable_comments'],
			'thumbnail_id' => ! empty($input['gallery_thumbnail']) ? (int) $input['gallery_thumbnail'] : 0,
			'published' => $input['published'],
			'updated_on' => time()
		));
	}

}